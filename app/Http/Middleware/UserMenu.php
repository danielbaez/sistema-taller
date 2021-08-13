<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UserMenu
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
        if($request->route()->getName() == 'rolesList')
        {
            if(Session::has('role_id'))
            {
                logsStore("Sale del perfil", 1);
            }

            Session::forget('user_account_id');
            Session::forget('role_id');
            Session::forget('branch_id');
        }

        $menu = [];

        if(Session::has('role_id'))
        {
            $menu = [
                [
                    'text'        => 'Dashboard',
                    'url'         => route('dashboard'),
                    'icon'        => 'far fa-fw fa-file',
                    'label_color' => 'success',
                    'permission'  => 'dashboard'
                ],
                [
                    'text'        => 'Usuarios',
                    'url'         => route('users.index'),
                    'icon'        => 'far fa-fw fa-user',
                    'label_color' => 'success',
                    'permission'  => ['users.index', 'users.create'],
                    'submenu' => [
                        [
                            'text'        => 'Usuarios',
                            'url'         => route('users.index'),
                            'label_color' => 'success',
                            'permission'  => ['users.index', 'users.create']
                        ],
                        [
                            'text'        => 'Roles',
                            'url'         => route('userAccounts.index'),
                            'label_color' => 'success',
                            'permission'  => ['userAccounts.index', 'userAccounts.create']
                        ]
                    ]
                ],
                [
                    'text'        => 'Roles',
                    'url'         => route('roles.index'),
                    'icon'        => 'far fa-fw fa-user',
                    'label_color' => 'success',
                    'permission'  => ['roles.index', 'roles.create']
                ],
                [
                    'text'        => 'Sucursales',
                    'url'         => 'products',
                    'icon'        => 'far fa-fw fa-building',
                    'label_color' => 'success'
                ],
                [
                    'text'        => 'Empleados',
                    'url'         => 'products',
                    'icon'        => 'fas fa-fw fa-users',
                    'label_color' => 'success'
                ],
                [
                    'text'        => 'Categorías',
                    'url'         => 'products',
                    'icon'        => 'fab fa-fw fa-product-hunt',
                    'label_color' => 'success'
                ],
                [
                    'text'        => 'Marcas',
                    'url'         => 'products',
                    'icon'        => 'fab fa-fw fa-product-hunt',
                    'label_color' => 'success'
                ],
                [
                    'text'        => 'Presentaciones',
                    'url'         => 'products',
                    'icon'        => 'fab fa-fw fa-product-hunt',
                    'label_color' => 'success'
                ],
                [
                    'text'        => 'Productos',
                    'url'         => 'products',
                    'icon'        => 'fab fa-fw fa-product-hunt',
                    'label_color' => 'success'
                ],
            ];
        }

        config(['adminlte.menu' => $menu]);

        return $next($request);
    }
}
