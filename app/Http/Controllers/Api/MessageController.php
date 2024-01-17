<?php

namespace App\Http\Controllers\Api;

use App\Events\NewConvoEvent;
use App\Events\RecieveMessageEvent;
use App\Http\Controllers\Controller;
use App\Repositories\InstructorRepository;
use App\Repositories\SchoolRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MessageController extends Controller
{


    public function getConversation(Request $request)
    {
        $code = 200;
        $conversation = [];
        try {
            $userId = $request->user()->id;
            $tempConvo = DB::table('conversation_users')
                ->join('users', 'conversation_users.user_id', "=", "users.id")
                ->whereIn('conversation_id', function ($query) use ($userId) {
                    $query->select('conversation_id')
                        ->from('conversation_users')
                        ->where('user_id', '=', $userId);
                })
                ->select(['conversation_users.*', 'users.profile_image', 'users.type', 'users.username'])
                ->where('user_id', '!=', $userId)
                ->get();

            foreach ($tempConvo as $value) {
                $value->name = $this->getOnlyName($value);
                $value->last_message = $this->getLastMessageOfConversation($value->conversation_id);
                array_push($conversation, $value);
            }
        } catch (\Exception $ex) {
            $code = $ex->getMessage();
        }
        usort($conversation, function ($a, $b) {
            $dateA = strtotime($a->last_message->date_created);
            $dateB = strtotime($b->last_message->date_created);
            if ($dateA == $dateB) {
                return 0;
            }
            return ($dateA > $dateB) ? -1 : 1;
        });
        return response()->json([
            'code' => $code,
            'conversation' => $conversation,
        ]);
    }

    public function getLastMessageOfConversation($id)
    {
        return DB::table('messages')->where('conversation_id', $id)->orderBy('date_created', "desc")->limit(1)->first();
    }
    public function getConvoIdWithUser(Request $request)
    {
        $convo_id = "";
        $userId1 = auth()->user()->id;
        $userId2 = $request->user_id;
        $conversation = DB::table('conversation_users as cu1')
            ->join('conversation_users as cu2', 'cu1.conversation_id', '=', 'cu2.conversation_id')
            ->where('cu1.user_id', $userId1)
            ->where('cu2.user_id', $userId2)
            ->select('cu1.conversation_id as id')
            ->first();

        if ($conversation) {
            $convo_id = $conversation->id;
        } else {
            $convo_id = Str::random(36);

            DB::table('conversations')->insert([
                'id' => $convo_id,
            ]);

            DB::table('conversation_users')->insert([
                ['conversation_id' => $convo_id, "user_id" => $userId1],
                ['conversation_id' => $convo_id, "user_id" => $userId2],
            ]);
        }
        return response()->json([
            'id' => $convo_id,
        ]);
    }
    
    public function getOnlyName($user)
    {

        if ($user->type == 1) {
            $school = new SchoolRepository();
            return $school->getInfo($user->user_id)->name;
        }
        if ($user->type == 2) {
            $instructor = new InstructorRepository();
            return $instructor->getInstructorDataUsingUserId($user->user_id)->firstname . " " . $instructor->getInstructorDataUsingUserId($user->user_id)->lastname;
        }
        if ($user->type == 3) {
            $student = DB::table('students')->where('student_id', $user->user_id)->first();
            return $student->firstname . " " . $student->lastname;
        }
        return "";
    }
    public function sentMessage(Request $request, $id)
    {
        $code = 200;
        try {
            $msgid = DB::table('messages')->insertGetId([
                'conversation_id' => $id,
                'sender_id' => auth()->user()->id,
                'body' => $request->body,
            ]);
            if (DB::table('messages')->where('conversation_id', $id)->count() == 1) {
                $user = DB::table('conversation_users')
                    ->where('user_id', '!=', auth()->user()->id)
                    ->where('conversation_id', $id)
                    ->first();
                event(
                    new NewConvoEvent(
                        $user->user_id,
                    )
                );
                $code= 201;
            }
            event(
                new RecieveMessageEvent(
                    $id,
                    DB::table('messages')->where('id', $msgid)->first(),
                )
            );
            event(
                new RecieveMessageEvent(
                    $id . "copy",
                    DB::table('messages')->where('id', $msgid)->first(),
                )
            );
        } catch (\Exception $ex) {
            $code = 505;
        }
        return response()->json([
            'code' => $code,

            'user'=>  $user,
        ]);
    }

    public function getConversationMessages($id)
    {
        $code = 200;
        $messages = [];
        try {
            $messages = DB::table('messages')->where('conversation_id', $id)->get();
        } catch (\Exception $ex) {
            $code = 505;
        }
        return response()->json([
            'code' => $code,
            'messages' => $messages,
        ]);
    }
}
