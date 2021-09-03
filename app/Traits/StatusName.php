<?php

namespace App\traits;

trait StatusName
{
    public function getStatusNameAttribute()
    {
        return config('system.status.'.$this->status);
    }
}