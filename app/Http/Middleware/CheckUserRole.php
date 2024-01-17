<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $role)
    {
        
        if (auth()->user()->type == 4) {
            $staff = DB::table('staff')->where('staff_id', auth()->user()->id)->first();
            $abilities = explode(",", $staff->role);
            if (in_array(intval($role), $abilities)) {
                return $next($request);
            } else {
                return abort(403, 'Unauthorized');
            }
        }
        return $next($request);
    }
}