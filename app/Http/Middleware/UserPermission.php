<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Role;

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
        $role = Role::find(session('roleId'));

        $p = explode('|', $permission);

        if(!$role->hasAnyPermission($p))
        {
            throw new \Illuminate\Auth\Access\AuthorizationException();
        }

        return $next($request);
    }
}
