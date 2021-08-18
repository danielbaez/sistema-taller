<?php

namespace App\Models;

use App\Models\Branch;
use App\Models\Role;
use App\Models\UserAccount;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'status'
    ];

    protected $appends = ['status_name'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function adminlte_image()
    {
        return 'https://picsum.photos/300/300';
    }

    public function adminlte_desc()
    {
        return Role::find(session('roleId'))->name ?? '';
    }

    public function adminlte_profile_url()
    {
        return '';
    }

    public function user_accounts()
    {
        return $this->hasMany(UserAccount::class);
    }

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
