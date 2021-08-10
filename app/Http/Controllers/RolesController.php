<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Facades\DB;

class RolesController extends Controller
{
    public function __construct()
    {
        userPermissions($this);
    }

    public function index(Request $request)
    {
        $resource = explode(".", $request->route()->getName())[0];

        if($request->ajax())
        {
            $data = Role::orderBy('id', 'desc')->get();
            return Datatables::of($data)
                //->addIndexColumn()
                ->filter(function ($query) use ($request) {
                    if($request->get('aaa')) {
                        $query->where('id', 'like', "%" . $request->get('aaa') . "%");
                    }
                }, true)
                ->addColumn('action', function($row) use ($resource) {
                    $btn = view('partials.options', compact('row', 'resource'))->render();
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $title = 'Roles';
        $title_form = 'Rol';

        $columns = [
            ['title' => '#', 'data' => 'id', 'export' => 'true', 'orderable' => 'true', 'searchable' => 'true'],
            ['title' => 'Rol', 'data' => 'name', 'export' => 'true', 'orderable' => 'true', 'searchable' => 'true'],
            ['title' => 'Estado', 'data' => 'status_name', 'export' => 'true', 'orderable' => 'true', 'searchable' => 'true']
        ];

        if(hasAnyPermission([$resource.'.edit', $resource.'.destroy', $resource.'.activate']))
        {
            $columns[] = ['title' => 'Acción', 'data' => 'action', 'export' => 'false', 'orderable' => 'false', 'searchable' => 'false'];
        }

        $permissions = Permission::all();

        return view($resource.'.index', compact('title', 'title_form', 'columns', 'resource', 'permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $role = Role::create($request->all());

            $role->syncPermissions($request->permissions);

            logsStore("Se ha creado el rol $role->name - id: $role->id", 1);

            //throw new \Exception("Hubo un error en la transacción");

            DB::commit();

            $success = true;
        } catch (\Exception $e) {
            DB::rollback();
            
            logsStore("Error al crear el rol", 0, $e);

            $success = false;
        }

        if($success)
        {
            $message = '¡Se ha registrado el rol correctamente!';
        }
        else
        {
            $message = '¡Error al registrar el rol!';
        }

        //$request->session()->flash('message', [$success, $message]);

        return response()->json(['success' => $success, 'message' => $message]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = Role::find($id);
        $role->permissions = $role->permissions;
        return $role;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        DB::beginTransaction();

        try {
            $role->name = $request->get('name');
            $role->save();

            $role->syncPermissions($request->permissions);

            logsStore("Se ha actualizado el rol $role->name - id: $role->id", 1);

            DB::commit();

            $success = true;
        } catch (\Exception $e) {
            DB::rollback();
            
            logsStore("Error al actualizar el rol - id: $role->id", 0, $e);

            $success = false;
        }

        if($success)
        {
            $message = '¡Se ha actualizado el rol correctamente!';
        }
        else
        {
            $message = '¡Error al actualizar el rol!';
        }

        //$request->session()->flash('message', [$success, $message]);

        return response()->json(['success' => $success, 'message' => $message]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Role $role)
    {
        $status = !empty($request->get('status')) ? $request->get('status') : 0;
        
        $status_success = $status == 1 ? 'activado' : 'desactivado';

        $status_error = $status == 1 ? 'activar' : 'desactivar';

        DB::beginTransaction();

        try {
            $role->status = !empty($request->get('status')) ? $request->get('status') : 0;
            $role->save();

            logsStore("Se ha $status_success el rol $role->name - id: $role->id", 1);

            DB::commit();

            $success = true;
        } catch (\Exception $e) {
            DB::rollback();
            
            logsStore("Error al $status_error el rol - id: $role->id", 0, $e);

            $success = false;
        }

        if($success)
        {
            $message = "¡Se ha $status_success el rol correctamente!";
        }
        else
        {
            $message = "¡Error al $status_error el rol!";
        }

        //$request->session()->flash('message', [$success, $message]);

        return response()->json(['success' => $success, 'message' => $message]);
    }
}
