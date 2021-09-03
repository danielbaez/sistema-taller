<?php

namespace App\traits;

trait StatusName
{
    //protected $appends = ['status_name'];

    protected function getArrayableAppends()
    {
        $this->appends = array_unique(array_merge($this->appends, ['status_name']));
        
        return parent::getArrayableAppends();
    }

    public function getStatusNameAttribute()
    {
        return config('system.status.'.$this->status);
    }
}