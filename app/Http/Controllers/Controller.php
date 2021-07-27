<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\App;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /*public function logs_store($description, $status, $e = '')
    {
        //$controller = App::make('\App\Http\Controllers\LogsController');
        //$controller->callAction('store', $parameters);
        
        (new LogsController)->store($description, $status, $e);
    }*/
}
