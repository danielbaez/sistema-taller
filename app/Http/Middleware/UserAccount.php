<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Profile;
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
        /*if(!Session::has('profile_id'))
        {
            return redirect()->route('profilesList');
        }*/

        $pass = false;

        $profile_id = Session::has('profile_id') ? Session::get('profile_id') : false;

        if($profile_id)
        {
            $profile = Profile::where('id', $profile_id)->where('status', 1)->first();

            if($profile)
            {
                $user_account = User_account::where('user_id', auth()->user()->id)->where('profile_id', $profile_id)->where('status', 1)->first();

                if($user_account)
                {
                    $pass = true;                
                }          
            }
        }

        /*if(!Session::has('profile_id') || auth()->user()->user_accounts()->where('profile_id', Session::get('profile_id'))->where('status', 1)->first() == null)
        {
            return redirect()->route('profilesList');
        }*/

        if(!$pass)
        {
            return redirect()->route('profilesList');
        }

        return $next($request);
    }
}