<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
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
