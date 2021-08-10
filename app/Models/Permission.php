<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'status'];

    protected $appends = ['status_name'];

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function getStatusNameAttribute()
    {
        return config('system.status.'.$this->status);
    }

    /*public function syncRoles(...$roles)
    {
        $this->roles()->detach();

        $roles = collect($roles)
        ->flatten()
        ->map(function ($role) {
            if (empty($role)) {
                return false;
            }

            return $this->getStoredRole($role);
        })
        ->filter(function ($role) {
            return $role instanceof Role;
        })
        ->map->id
        ->all();

        $this->roles()->sync($roles, false);
    }*/

    public function syncRoles($roles)
    {
        $this->roles()->sync($roles);
    }

    protected function getStoredRole($role)
    {
        if (is_numeric($role)) {
            return static::where('id', $role)->first();
        }

        if (is_string($role)) {
            static::where('name', $role)->first();
        }

        return $role;
    }
}
