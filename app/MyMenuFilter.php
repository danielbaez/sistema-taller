<?php

namespace App;

use JeroenNoten\LaravelAdminLte\Menu\Filters\FilterInterface;
use App\Models\Role;

class MyMenuFilter implements FilterInterface
{
    public function transform($item)
    {
        if(!empty($item['permission']))
        {
            $role = Role::find(session('roleId'));
        
            if(!$role->hasAnyPermission($item['permission']))
            {
                return false;
            }
        }
        
        return $item;
    }
}