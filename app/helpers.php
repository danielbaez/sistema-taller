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
    function logsStore($action, $description, $status, $e = '')
    {
        (new LogsController)->store($action, $description, $status, $e);
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
        //$role = Role::find(session('roleId'));

        $role = new Role();
        $role->id = session('roleId');
        
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
        //$role = Role::find(session('roleId'));

        $role = new Role();
        $role->id = session('roleId');
        
        if(!$role->hasAnyPermission($permission))
        {
            return false;
        }

        return true;
    }
}

if(!function_exists('actionMessage'))
{
    function actionMessage($action, $status, $description)
    {
        $push = $status ? ' correctamente' : '';

        if($action)
        {
            if($action == 'store')
            {
                $desc = $status ? 'Se ha creado ' : 'Error al crear ';
            }
            if($action == 'update')
            {
                $desc = $status ? 'Se ha editado ' : 'Error al editar ';
            }
            if($action == 'destroy')
            {
                $desc = $status ? 'Se ha desactivado ' : 'Error al desactivar ';
            }
            if($action == 'activate')
            {
                $desc = $status ? 'Se ha activado ' : 'Error al activar ';
            }

            $desc = '??'.$desc.$description.$push.'!';    
        }
        else
        {
            $desc = '??'.$description.$push.'!';
        }

        return $desc;
    }
}

if(!function_exists('destroyGeneric'))
{
    function destroyGeneric($request, $model, $title)
    {
        $status = !empty($request->get('status')) ? $request->get('status') : 0;
        
        $statusSuccess = $status == 1 ? 'activado' : 'desactivado';
        $action = $status == 1 ? 'activate' : 'destroy';

        $statusError = $status == 1 ? 'activar' : 'desactivar';

        try {
            DB::beginTransaction();
            
            $model->status = !empty($request->get('status')) ? $request->get('status') : 0;
            $model->save();

            logsStore($action, "$title - id: $model->id", 1);

            DB::commit();

            $success = true;
        } catch (\Exception $e) {
            DB::rollback();
            
            logsStore($action, "$title - id: $model->id", 0, $e);

            $success = false;
        }

        $message = actionMessage($action, $success, $title);

        return response()->json(['success' => $success, 'message' => $message]);
    }
}

if(!function_exists('datatablesGeneric'))
{
    function datatablesGeneric($data, $request, $resource, $addColumns = [])
    {
        $rawColumns = ['action'];

        $table = datatables()->of($data)
        //->addIndexColumn()
        ->filter(function ($query) use ($request) {
            if($request->get('aaa')) {
                $query->where('id', 'like', "%" . $request->get('aaa') . "%");
            }
        }, true)
        ->addColumn('action', function($row) use ($resource) {
            $btn = view('partials.options', compact('row', 'resource'))->render();
            return $btn;
        });

        if(count($addColumns))
        {
            foreach($addColumns as $column)
            {
                $table = $table->addColumn($column['name'], function($row) use ($resource, $column) {
                    $btn = view($column['view'], compact('row', 'resource'))->render();
                    return $btn;
                });

                $rawColumns[] = $column['name'];
            }
        }

        $table = $table->rawColumns($rawColumns)
        ->make(true);

        return $table;
    }
}

if(!function_exists('permissionsToShowActionButton'))
{
    function permissionsToShowActionButton($resource)
    {
        $columns = [];

        if(hasAnyPermission([$resource.'.edit', $resource.'.destroy', $resource.'.activate']))
        {
            $columns[] = ['title' => 'Acci??n', 'data' => 'action', 'export' => 'false', 'orderable' => 'false', 'searchable' => 'false'];
        }

        return $columns;
    }
}