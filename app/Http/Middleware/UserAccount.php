<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Models\User_account;
use Illuminate\Support\Facades\Session;

class UserAccount
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $pass = false;

        $role_id = Session::has('role_id') ? Session::get('role_id') : false;

        if($role_id)
        {
            $role = Role::where('id', $role_id)->where('status', 1)->first();

            if($role)
            {
                $user_account = User_account::where('user_id', auth()->user()->id)->where('role_id', $role_id)->where('status', 1)->first();

                if($user_account)
                {
                    $pass = true;                
                }          
            }
        }

        if(!$pass)
        {
            return redirect()->route('rolesList');
        }

        return $next($request);
    }
}
