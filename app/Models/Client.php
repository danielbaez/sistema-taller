<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\StatusName;

class Client extends Model
{
    use HasFactory, StatusName;

    protected $fillable = ['name', 'document_id', 'document_number', 'company_name', 'address', 'phone', 'email', 'status'];

    public function document()
    {
        return $this->belongsTo(Document::class);
    }
}
