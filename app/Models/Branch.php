<?php

namespace App\Models;

use App\Models\User_account;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Branch extends Model
{
    use HasFactory;

    public function user_accounts()
    {
        return $this->hasMany(User_account::class);
    }
}
