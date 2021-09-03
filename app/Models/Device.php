<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as Eloquent;
use App\Traits\StatusName;

class Device extends Eloquent
{
    use HasFactory, StatusName;

    protected $fillable = ['user_id', 'category_id', 'brand_id', 'model_id', 'serial_number', 'status'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function model()
    {
        return $this->belongsTo(Model::class);
    }
}
