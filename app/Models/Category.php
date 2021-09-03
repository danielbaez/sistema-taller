<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\StatusName;

class Category extends Model
{
    use HasFactory, StatusName;

    protected $fillable = ['name', 'status'];

    protected $appends = ['status_name'];

    public $timestamps = false;
}
