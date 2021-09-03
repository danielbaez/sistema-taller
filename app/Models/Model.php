<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as Eloquent;

class Model extends Eloquent
{
    use HasFactory;

    protected $fillable = ['name', 'status'];

    protected $appends = ['status_name'];

    public $timestamps = false;

    public function getStatusNameAttribute()
    {
        return config('system.status.'.$this->status);
    }
}
