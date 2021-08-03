<?php

namespace App;

use JeroenNoten\LaravelAdminLte\Menu\Filters\FilterInterface;
use Spatie\Permission\Models\Role;

class MyMenuFilter implements FilterInterface
{
    public function transform($item)
    {
        if(!empty($item['can']))
        {
            $role = Role::find(session('profile_id'));
        
            if(!$role->hasAnyDirectPermission($item['can']))
            {
                return false;
            }
        }
        
        return $item;
    }
}