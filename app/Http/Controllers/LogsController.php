<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Http\Request;

class LogsController extends Controller
{
    public function store($description, $status, $e)
    {
        if(auth()->check())
        {
            Log::create([
                'user_id' => auth()->user()->id,
                'role_id' => session()->get('roleId'),
                'branch_id' => session()->get('branchId'),
                'description' => $description.($e != '' ? ' *-* '.$e : ''),
                'status' => $status,
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }
    }
}
