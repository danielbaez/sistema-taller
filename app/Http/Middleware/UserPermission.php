<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Role;
use Illuminate\Support\Facades\Session;

class UserPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $permission)
    {
        //$role = Role::find(session('roleId'));

        $role = new Role();
        $role->id = session('roleId');

        if($request->isMethod('delete'))
        {
            //por si se esta activando pero no tiene permiso de eliminar (ambos tanto eliminar como activar se ejecutan en el mismo método destroy por lo tanto ambos middleware seran llamados pero fallará en el metodo eliminar, ignoro por si no tiene permiso de eliminar pero si tiene permiso de activar y justamemte esta intentando activar)
            if($request->get('status') == 1 && strpos($permission, 'destroy') !== false)
            {
                return $next($request);
            }
        }

        $p = explode('|', $permission);

        if(!$role->hasAnyPermission($p))
        {            
            Session::flash('message', [0, '¡No está autorizado para realizar esta acción!']);
            throw new \Illuminate\Auth\Access\AuthorizationException();
        }

        return $next($request);
    }
}
