<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as Eloquent;

class Device extends Eloquent
{
    use HasFactory;

    protected $fillable = ['user_id', 'category_id', 'brand_id', 'model_id', 'serial_number', 'status'];

    protected $appends = ['status_name'];

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

    public function getStatusNameAttribute()
    {
        return config('system.status.'.$this->status);
    }
}
