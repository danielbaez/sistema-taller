<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\StatusName;

class Role extends Model
{
    use HasFactory, StatusName;

    protected $fillable = ['name', 'status'];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    /*public function syncPermissions(...$permissions)
    {
        $this->permissions()->detach();

        $permissions = collect($permissions)
        ->flatten()
        ->map(function ($permission) {
            if (empty($permission)) {
                return false;
            }

            return $this->getStoredPermission($permission);
        })
        ->filter(function ($permission) {
            return $permission instanceof Permission;
        })
        ->map->id
        ->all();

        $this->permissions()->sync($permissions, false);
    }*/

    public function syncPermissions($permissions)
    {
        $this->permissions()->sync($permissions);
    }

    protected function getStoredPermission($permission)
    {
        if (is_numeric($permission)) {
            return static::where('id', $permission)->first();
        }

        if (is_string($permission)) {
            static::where('name', $permission)->first();
        }

        return $permission;
    }

    public function hasAnyPermission($permission)
    {
        if(!is_array($permission))
        {
            $permission = [$permission];
        }

        if(session()->has('permissions'))
        {
            $perms = session()->get('permissions');

            $count = 0;

            foreach($permission as $per)
            {
                $count += is_numeric(array_search($per, array_column($perms, 'name'))) ? 1 : 0;
            }
        }
        else
        {
            $count = $this->permissions->whereIn('name', $permission)->count();
        }

        return $count ? true : false;
    }

    public function hasAllPermissions($permission)
    {
        $permission_count = 0;

        if(is_array($permission))
        {
            $permission_count = count($permission);

            if(session()->has('permissions'))
            {
                $perms = session()->get('permissions');

                $count = 0;

                foreach($permission as $per)
                {
                    $count += is_numeric(array_search($per, array_column($perms, 'name'))) ? 1 : 0;
                }
            }
            else
            {
                $count = $this->permissions->whereIn('name', $permission)->count();
            }
        }
        else
        {
            $permission_count = 1;

            if(session()->has('permissions'))
            {
                $perms = session()->get('permissions');

                $count = 0;

                $count += is_numeric(array_search($permission, array_column($perms, 'name'))) ? 1 : 0;
            }
            else
            {
                $count = $this->permissions->where('name', $permission)->count();
            }
        }

        return $count == $permission_count ? true : false;
    }

    public function user_accounts()
    {
        return $this->hasMany(UserAccount::class);
    }

    /*public function getStatusAttribute($value)
    {
        return config('system.status.'.$value);
    }*/
}
