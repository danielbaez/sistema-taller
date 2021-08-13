<?php

use App\Models\Role;
use App\Models\UserAccount;
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
    	if(Session::has('roleId'))
    	{
    		return Role::find(session('roleId'));
    	}
        /*UserAccount::where('user_id', Auth::user()->id)
        ->with(['role', 'branch'])->get()*/
    }
}

if(!function_exists('currentUsersAccounts'))
{
    function currentUsersAccounts()
    {
    	return UserAccount::whereHas('role', function($q) {
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
    function userPermissions($instance, $permissions = [], $defaultPermissions = true, $resource = '')
    {
        if(!$resource)
        {
            $resource = explode(".", Route::currentRouteName())[0];
        }

        if($defaultPermissions)
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
        $role = Role::find(session('roleId'));
        
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
        $role = Role::find(session('roleId'));
        
        if(!$role->hasAnyPermission($permission))
        {
            return false;
        }

        return true;
    }
}

if(!function_exists('destroyGeneric'))
{
    function destroyGeneric($request, $model, $title)
    {
        $status = !empty($request->get('status')) ? $request->get('status') : 0;
        
        $statusSuccess = $status == 1 ? 'activado' : 'desactivado';

        $statusError = $status == 1 ? 'activar' : 'desactivar';

        DB::beginTransaction();

        try {
            $model->status = !empty($request->get('status')) ? $request->get('status') : 0;
            $model->save();

            logsStore("Se ha $statusSuccess $title - id: $model->id", 1);

            DB::commit();

            $success = true;
        } catch (\Exception $e) {
            DB::rollback();
            
            logsStore("Error al $statusError $title - id: $model->id", 0, $e);

            $success = false;
        }

        if($success)
        {
            $message = "¡Se ha $statusSuccess $title correctamente!";
        }
        else
        {
            $message = "¡Error al $statusError $title!";
        }

        //$request->session()->flash('message', [$success, $message]);

        return response()->json(['success' => $success, 'message' => $message]);
    }
}