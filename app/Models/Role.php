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
        return $this->hasMany(User_account::class);
    }

    /*public function getStatusAttribute($value)
    {
        return config('system.status.'.$value);
    }*/

    public function getStatusNameAttribute()
    {
        return config('system.status.'.$this->status);
    }

    /*public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->status = 1;
        });
    }*/
}
