<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as Eloquent;
use App\Traits\StatusName;

class Model extends Eloquent
{
    use HasFactory, StatusName;

    protected $fillable = ['name', 'status'];

    public $timestamps = false;
}
