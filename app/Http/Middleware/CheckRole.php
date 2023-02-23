<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Session;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Session::has('loginid'))
        {
            $action = $request->route()->getPrefix();  // get the prefix of the route
            $userId=Session::get('loginid'); // get the user id from session
            $userData=(object)ApiController::User($userId); // get the user data from the api
            $role=$userData->roleName; // get the user role from the api

            $request_role=str_replace("/","",$action);

            if (str_replace(' ','_',strtolower($role)) === $request_role )
            {
                return $next($request);

            } else {
                 return redirect($action);
            }
        }
        return $next($request);
    }
}

