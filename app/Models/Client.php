<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'document_id', 'document_number', 'company_name', 'address', 'phone', 'email'];

    protected $appends = ['status_name'];

    public function document()
    {
        return $this->belongsTo(Document::class);
    }

    public function getStatusNameAttribute()
    {
        return config('system.status.'.$this->status);
    }
}
