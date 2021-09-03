<?php

namespace App\Models;

use App\Models\User;
use App\Models\Branch;
use App\Models\Role;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\StatusName;

class UserAccount extends Model
{
    use HasFactory, StatusName;

    protected $fillable = ['user_id', 'role_id', 'branch_id', 'status'];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function role()
    {
    	return $this->belongsTo(Role::class);
    }

    public function branch()
    {
        $attributes = [];

        $branch = new Branch();

        foreach($branch->getFillable() as $attribute)
        {
            $attributes[$attribute] = ''; 
        }

        return $this->belongsTo(Branch::class)->withDefault($attributes);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    /*public function getStatusAttribute($value)
    {
        return config('system.status.'.$value);
    }*/

    public function getIsActiveAttribute()
    {
        //return $this->status == config('system.status.1') ? 1 : 0;
        return $this->status == 1 ? 1 : 0;
    }
}
