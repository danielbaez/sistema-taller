<?php

namespace App\Models;

use App\Models\UserAccount;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\StatusName;

class Branch extends Model
{
    use HasFactory, StatusName;

    protected $fillable = ['name', 'document_number', 'address', 'phone', 'status'];

    //protected $appends = ['status_name'];

    public function user_accounts()
    {
        return $this->hasMany(UserAccount::class);
    }
}
