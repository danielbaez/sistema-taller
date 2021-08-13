<?php

namespace App\Models;

use App\Models\UserAccount;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Branch extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'document_type', 'document_number', 'address', 'phone', 'representative', 'status'];

    protected $appends = ['status_name'];

    public function user_accounts()
    {
        return $this->hasMany(UserAccount::class);
    }

    public function getStatusNameAttribute()
    {
        return config('system.status.'.$this->status);
    }
}
