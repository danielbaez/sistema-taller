<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'status'];

    protected $appends = ['status_name'];

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
        $count = $this->permissions->whereIn('name', $permission)->count();

        return $count ? true : false;
    }

    public function hasAllPermissions($permission)
    {
        $count = $this->permissions;

        $permission_count = 0;

        if(is_array($permission))
        {
            $permission_count = count($permission);

            $count = $count->whereIn('name', $permission);
        }
        else
        {
            $permission_count = 1;
            
            $count = $count->where('name', $permission);
        }

        $count = $count->count();

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

    public function getStatusNameAttribute()
    {
        return config('system.status.'.$this->status);
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->status = 1;
        });
    }
}
