<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Instructor\InstructorProfileController;
use App\Http\Controllers\Api\Instructor\MockExamController;
use App\Http\Controllers\Api\Instructor\SchedulesContoller as InstructorSchedulesContoller;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\Student\CoursesController;
use App\Http\Controllers\Api\Student\OrderController;
use App\Http\Controllers\Api\Student\PromoController;
use App\Http\Controllers\Api\Student\ReportController;
use App\Http\Controllers\Api\Student\SchedulesContoller;
use App\Http\Controllers\Api\Student\SchoolController;
use App\Http\Controllers\Api\Student\MockExamController as StudentMockExamController;

use App\Http\Controllers\Api\Student\StudentProfileController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\AvailCourseController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\Instructor\SchedulesController;
use App\Http\Controllers\School\StudentController;
use App\Http\Controllers\Api\StudentController as APIStudentController;

use App\Http\Controllers\Validator\ValidateAccountController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Broadcast::routes(['middleware' => ['auth:sanctum']]);

Route::middleware('auth:sanctum')->post('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [LoginController::class, 'login']);
Route::post('/register', [RegisteredUserController::class, 'registerStudent']);

Route::POST('/retrieve/schools', [SchoolController::class, 'getDrivingSchool']);
Route::post('/email/send_verification', [EmailVerificationController::class, 'sendCodeMobile']);
Route::post('/validate/email_username', [ValidateAccountController::class, 'checkUsernameAndEmailMobile']);
Route::post('/retrieve/school/courses', [CoursesController::class, 'getDrivingSchoolCourses']);
Route::post('/retrieve/{course_id}/courses', [CoursesController::class, 'getDrivingSchoolSingleCourse']);
Route::get('/retrieve/{course_id}/courses/review', [CoursesController::class, 'getCoursesReview']);
Route::get('/retrieve/{school_id}/school/review', [SchoolController::class, 'getSchoolReview']);

Route::post('/retrieve/filltered_courses', [CoursesController::class, 'filterCourses']);
Route::post('/retrieve/filltered_drivingschool', [SchoolController::class, 'filterSchool']);
Route::get('/retrieve/{school_id}/about', [SchoolController::class, 'getSchoolAbout']);
Route::get('/retrieve/{school_id}/policy', [SchoolController::class, 'getSchoolPolicy']);


Route::middleware('auth:sanctum')->post('/conversation/retrieve', [MessageController::class, 'getConversation']);
Route::middleware('auth:sanctum')->post('/messages/{id}/sendmessage', [MessageController::class, 'sentMessage']);
Route::middleware('auth:sanctum')->post('/messages/{id}/retrieve', [MessageController::class, 'getConversationMessages']);
Route::middleware('auth:sanctum')->post('/conversation/getconvoid', [MessageController::class, 'getConvoIdWithUser']);



// Route::middleware('auth:sanctum')->post('/createstudent', [StudentController::class, 'create']);
// Route::middleware('auth:sanctum')->post('/alreadyRegisteredInDrivingSchool', [APIStudentController::class, 'alreadyRegisteredInDrivingSchool']);
// Route::middleware('auth:sanctum')->post('/course/createorder', [AvailCourseController::class, 'createOrder']);
// Route::middleware('auth:sanctum')->post('/availed/courses/student', [AvailCourseController::class, 'getStudentCourses']);
// Route::middleware('auth:sanctum')->post('/availed/courses/student/totalpaid', [AvailCourseController::class, 'totalPaidOfCourse']);
// Route::middleware('auth:sanctum')->post('/availed/courses/student/singleorder', [AvailCourseController::class, 'getStudentSinglerOder']);
// Route::middleware('auth:sanctum')->post('/availed/courses/student/singleorder/sessions', [AvailCourseController::class, 'getCourseSessions']);



//new lang
Route::middleware('auth:sanctum')->post('/student/createorder', [OrderController::class, 'createOrder']);
Route::middleware('auth:sanctum')->post('/student/getorders', [OrderController::class, 'getStudentOrder']);
Route::middleware('auth:sanctum')->post('/student/getcourses', [CoursesController::class, 'getCoursesController']);
Route::middleware('auth:sanctum')->post('/student/{id}/getcourse', [CoursesController::class, 'getSingleCourse']);
Route::middleware('auth:sanctum')->post('/student/course/review', [CoursesController::class, 'studentReviewCourse']);
Route::middleware('auth:sanctum')->post('/student/school/review', [SchoolController::class, 'studentReviewSchool']);

Route::middleware('auth:sanctum')->post('/student/getschedules', [SchedulesContoller::class, 'getStudentSchedules']);
Route::middleware('auth:sanctum')->post('/student/{id}/getschedules', [SchedulesContoller::class, 'getStudentSingleSchedule']);
Route::middleware('auth:sanctum')->post('/student/reviewinstructor', [SchedulesContoller::class, 'reviewInstructor']);


Route::middleware('auth:sanctum')->post('/student/{order_list_id}/mockexam', [StudentMockExamController::class, 'getStudentMockList']);
Route::middleware('auth:sanctum')->post('/student/{mock_id}/mock_questions', [StudentMockExamController::class, 'getStudentMockQuestions']);
Route::middleware('auth:sanctum')->post('/student/mock_questions/saveanswer', [StudentMockExamController::class, 'saveQuestionAnswer']);
Route::middleware('auth:sanctum')->post('/student/mock_questions/submit', [StudentMockExamController::class, 'submitAnswer']);
Route::middleware('auth:sanctum')->post('/student/report/instructor', [ReportController::class, 'create']);
Route::middleware('auth:sanctum')->post('/student/profile', [StudentProfileController::class, 'getInfo']);
Route::middleware('auth:sanctum')->post('/student/profile/changepassword', [StudentProfileController::class, 'updatePassword']);
Route::middleware('auth:sanctum')->post('/student/profile/updateinfo', [StudentProfileController::class, 'updateInfo']);
Route::middleware('auth:sanctum')->post('/student/profile/sendotp', [StudentProfileController::class, 'sendOtp']);
Route::middleware('auth:sanctum')->post('/student/profile/updatenumber', [StudentProfileController::class, 'updateNumber']);


//instructor
Route::middleware('auth:sanctum')->post('/instructor/{id}/getschedule', [InstructorSchedulesContoller::class, 'getInstructorSingleSchedule']);
Route::middleware('auth:sanctum')->post('/instructor/getschedules', [InstructorSchedulesContoller::class, 'getInstructorSchedules']);
Route::middleware('auth:sanctum')->post('/instructor/{id}/startschedule', [InstructorSchedulesContoller::class, 'startSchedule']);
Route::middleware('auth:sanctum')->post('/instructor/sendlocation', [InstructorSchedulesContoller::class, 'sendLocation']);
Route::middleware('auth:sanctum')->post('/instructor/report', [InstructorSchedulesContoller::class, 'scheduleReport']);

Route::middleware('auth:sanctum')->post('/instructor/endsession', [InstructorSchedulesContoller::class, 'endSession']);
Route::middleware('auth:sanctum')->post('/instructor/session/studentprogress', [InstructorSchedulesContoller::class, 'viewStudentProgress']);
Route::middleware('auth:sanctum')->post('/instructor/session/updateprogress', [InstructorSchedulesContoller::class, 'updateStudentProgress']);
Route::middleware('auth:sanctum')->post('/instructor/create/mockexam', [MockExamController::class, 'createMockExam']);
Route::middleware('auth:sanctum')->post('/instructor/profile', [InstructorProfileController::class, 'getInfo']);
Route::middleware('auth:sanctum')->post('/instructor/profile/save', [InstructorProfileController::class, 'updateInstructor']);

//guest
Route::get('/school/{school_id}/promos', [PromoController::class, 'getSchoolPromo']);