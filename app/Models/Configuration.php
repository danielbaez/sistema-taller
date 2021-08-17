<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Configuration extends Model
{
    use HasFactory;

    protected $fillable = ['company', 'document_number', 'address', 'phone', 'logo'];

    public $timestamps = false;
}
