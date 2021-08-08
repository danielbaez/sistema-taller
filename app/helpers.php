<?php

use App\Models\Role;
use App\Models\User_account;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\LogsController;
use Illuminate\Support\Facades\Route;

if(!function_exists('currentUser'))
{
    function currentUser()
    {
        return auth()->user();
    }
}

if(!function_exists('currentRole'))
{
    function currentRole()
    {
    	if(Session::has('role_id'))
    	{
    		return Role::find(session('role_id'));
    	}
        /*User_account::where('user_id', Auth::user()->id)
        ->with(['role', 'branch'])->get()*/
    }
}

if(!function_exists('currentUserAccounts'))
{
    function currentUserAccounts()
    {
    	return User_account::whereHas('role', function($q) {
            $q->where('roles.status', 1);
        })->where('user_id', Auth::user()->id)
        ->active()
    	->get();

        //return auth()->user()->roles;
    }
}

if(!function_exists('logsStore'))
{
    function logsStore($description, $status, $e = '')
    {
        (new LogsController)->store($description, $status, $e);
    }
}

if(!function_exists('userPermissions'))
{
    function userPermissions($instance, $permissions = [], $default_permissions = true, $resource = '')
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

if(!function_exists('hasAllPermissions'))
{
    function hasAllPermissions($permission)
    {
        $role = Role::find(session('role_id'));
        
        if(!$role->hasAllPermissions($permission))
        {
            return false;
        }

        return true;
    }
}

if(!function_exists('hasAnyPermission'))
{
    function hasAnyPermission($permission)
    {
        $role = Role::find(session('role_id'));
        
        if(!$role->hasAnyPermission($permission))
        {
            return false;
        }

        return true;
    }
}