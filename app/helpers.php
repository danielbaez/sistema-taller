<?php

use App\Models\Profile;
use App\Models\User_account;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\LogsController;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;

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
    	/*return User_account::whereHas('profile', function($q) {
            $q->where('profiles.status', 1);
        })->where('user_id', Auth::user()->id)
        ->active()
    	->get();*/

        return auth()->user()->roles;
    }
}

if(!function_exists('logs_store'))
{
    function logs_store($description, $status, $e = '')
    {
        (new LogsController)->store($description, $status, $e);
    }
}

if(!function_exists('user_permissions'))
{
    function user_permissions($instance, $permissions = [], $default_permissions = true, $resource = '')
    {
        if(!$resource)
        {
            $resource = explode(".", Route::currentRouteName())[0];
        }

        if($default_permissions)
        {
            /*$instance->middleware(function ($request, $next) use ($resource) {
                $action_method = $request->route()->getActionMethod();

                if($action_method == 'index' && !(auth()->user()->hasAnyPermission([$resource.'.index', $resource.'.create'])))
                {
                    //abort(403, 'This action is unauthorized.');
                    throw new \Illuminate\Auth\Access\AuthorizationException();
                }

                return $next($request);
            });*/

            $instance->middleware('user.permission:'.$resource.'.index|'.$resource.'.create')->only(['index']);
            $instance->middleware('user.permission:'.$resource.'.create')->only(['create', 'store']);
            $instance->middleware('user.permission:'.$resource.'.edit')->only(['edit', 'update']);
            $instance->middleware('user.permission:'.$resource.'.destroy')->only('destroy');
            $instance->middleware('user.permission:'.$resource.'.activate')->only('destroy');

            //$instance->middleware('can:'.$resource.'.create')->only(['create', 'store']);
            //$instance->middleware('can:'.$resource.'.edit')->only(['edit', 'update']);
            //$instance->middleware('can:'.$resource.'.destroy')->only('destroy');
            //$instance->middleware('can:'.$resource.'.activate')->only('destroy');
        }

        if(count($permissions))
        {
            foreach ($permissions as $can => $method)
            {
                if(is_numeric($can))
                {
                    //$instance->middleware('can:'.$method)->only($method);
                    $instance->middleware('user.permission:'.$method)->only($method);    
                }
                else
                {
                    //$instance->middleware('can:'.$can)->only($method);
                    $instance->middleware('user.permission:'.$can)->only($method);
                }
            }
        }
    }
}

if(!function_exists('rol_permission'))
{
    function rol_permission($permission)
    {
        $role = Role::find(session('profile_id'));
        
        if(!$role->hasAllDirectPermissions($permission))
        {
            return false;
        }

        return true;
    }
}

if(!function_exists('rol_permission_any'))
{
    function rol_permission_any($permission)
    {
        $role = Role::find(session('profile_id'));
        
        if(!$role->hasAnyDirectPermission($permission))
        {
            return false;
        }

        return true;
    }
}