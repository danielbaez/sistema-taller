<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\StatusName;

class Brand extends Model
{
    use HasFactory, StatusName;

    protected $fillable = ['name', 'status'];

    public $timestamps = false;
}
