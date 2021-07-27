<?php

use App\Models\Profile;
use App\Models\User_account;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\LogsController;

if(!function_exists('current_user'))
{
    function current_user()
    {
        return auth()->user();
    }
}

if(!function_exists('current_profile'))
{
    function current_profile()
    {
    	if(Session::has('profile_id'))
    	{
    		return Profile::find(session('profile_id'));
    	}
        /*User_account::where('user_id', Auth::user()->id)
        ->with(['profile', 'branch'])->get()*/
    }
}

if(!function_exists('current_user_accounts'))
{
    function current_user_accounts()
    {
    	return User_account::whereHas('profile', function($q) {
            $q->where('profiles.status', 1);
        })->where('user_id', Auth::user()->id)
        ->active()
    	->get();
    }
}

if(!function_exists('logs_store'))
{
    function logs_store($description, $status, $e = '')
    {
        (new LogsController)->store($description, $status, $e);
    }
}