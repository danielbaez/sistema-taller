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
            if(Session::has('roleId'))
            {
                logsStore(false, "Sale del rol de usuario id: ".session('userAccountId'), 1);
            }

            Session::forget('userAccountId');
            Session::forget('roleId');
            Session::forget('branchId');
            Session::forget('roleName');
            Session::forget('permissions');
        }

        $menu = [];

        if(Session::has('roleId'))
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
                    'icon'        => 'fas fa-fw fa-users',
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
                            'url'         => route('usersAccounts.index'),
                            'label_color' => 'success',
                            'permission'  => ['usersAccounts.index', 'usersAccounts.create']
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
                    'url'         => route('branches.index'),
                    'icon'        => 'far fa-fw fa-building',
                    'label_color' => 'success',
                    'permission'  => ['branches.index', 'branches.create']
                ],
                [
                    'text'        => 'Categorías',
                    'url'         => route('categories.index'),
                    'icon'        => 'fab fa-fw fa-product-hunt',
                    'label_color' => 'success',
                    'permission'  => ['categories.index', 'categories.create']
                ],
                [
                    'text'        => 'Marcas',
                    'url'         => route('brands.index'),
                    'icon'        => 'fab fa-fw fa-product-hunt',
                    'label_color' => 'success',
                    'permission'  => ['brands.index', 'brands.create']
                ],
                [
                    'text'        => 'Modelos',
                    'url'         => route('models.index'),
                    'icon'        => 'fab fa-fw fa-product-hunt',
                    'label_color' => 'success',
                    'permission'  => ['models.index', 'models.create']
                ],
                [
                    'text'        => 'Equipos',
                    'url'         => route('devices.index'),
                    'icon'        => 'fab fa-fw fa-product-hunt',
                    'label_color' => 'success',
                    'permission'  => ['devices.index', 'devices.create']
                ],
                [
                    'text'        => 'Configuración',
                    'url'         => route('configurations.index'),
                    'icon'        => 'fas fa-fw fa-cog',
                    'label_color' => 'success',
                    'permission'  => ['configurations.index']
                ]
            ];
        }

        config(['adminlte.menu' => $menu]);

        return $next($request);
    }
}
