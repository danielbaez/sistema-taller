<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Http\Request;

class LogsController extends Controller
{
    public function store($action, $description, $status, $e)
    {
        if($action)
        {
            if($action == 'store')
            {
                $desc = $status ? 'Se ha creado ' : 'Error al crear ';
            }
            if($action == 'update')
            {
                $desc = $status ? 'Se ha editado ' : 'Error al editar ';
            }
            if($action == 'destroy')
            {
                $desc = $status ? 'Se ha desactivado ' : 'Error al desactivar ';
            }
            if($action == 'activate')
            {
                $desc = $status ? 'Se ha activado ' : 'Error al activar ';
            }

            $desc = $desc.$description.($e != '' ? ' *-* '.$e : '');    
        }
        else
        {
            $desc = $description.($e != '' ? ' *-* '.$e : '');
        }
        
        if(auth()->check())
        {
            Log::create([
                'user_id' => auth()->user()->id,
                'role_id' => session()->get('roleId'),
                'branch_id' => session()->get('branchId'),
                'description' => $desc,
                'status' => $status,
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }
    }
}
