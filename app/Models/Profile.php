<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'status'];

    protected $appends = ['status_name'];

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
}
