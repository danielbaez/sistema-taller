<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Http\Requests\RoleRequest;
use DataTables;
use Illuminate\Support\Facades\DB;

class ProfilesController extends Controller
{
    public function __construct()
    {
        user_permissions($this);
    }
    
    public function index(Request $request)
    {
        $resource = explode(".", $request->route()->getName())[0];

        if($request->ajax())
        {
            $data = Profile::orderBy('id', 'desc')->get();
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

        $title = 'Perfiles';
        $title_form = 'Perfil';

        $columns = [
            ['title' => '#', 'data' => 'id', 'export' => 'true', 'orderable' => 'true', 'searchable' => 'true'],
            ['title' => 'Perfil', 'data' => 'name', 'export' => 'true', 'orderable' => 'true', 'searchable' => 'true'],
            ['title' => 'Estado', 'data' => 'status_name', 'export' => 'true', 'orderable' => 'true', 'searchable' => 'true']
        ];

        if(rol_permission_any([$resource.'.edit', $resource.'.destroy', $resource.'.activate']))
        {
            $columns[] = ['title' => 'Acción', 'data' => 'action', 'export' => 'false', 'orderable' => 'false', 'searchable' => 'false'];
        }

        return view($resource.'.index', compact('title', 'title_form', 'columns', 'resource'));
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
    public function store(RoleRequest $request)
    {
        DB::beginTransaction();

        try {
            $profile = Profile::create($request->all());

            logs_store("Se ha creado el perfil $profile->name - id: $profile->id", 1);

            //throw new \Exception("Hubo un error en la transacción");

            DB::commit();

            $success = true;
        } catch (\Exception $e) {
            DB::rollback();
            
            logs_store("Error al crear el perfil", 0, $e);

            $success = false;
        }

        if($success)
        {
            $message = '¡Se ha registrado el perfil correctamente!';
        }
        else
        {
            $message = '¡Error al registrar el perfil!';
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
        return Profile::findOrFail($id);
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
    public function update(RoleRequest $request, Profile $profile)
    {
        DB::beginTransaction();

        try {
            $profile->name = $request->get('name');
            $profile->save();

            logs_store("Se ha actualizado el perfil $profile->name - id: $profile->id", 1);

            DB::commit();

            $success = true;
        } catch (\Exception $e) {
            DB::rollback();
            
            logs_store("Error al actualizar el perfil - id: $profile->id", 0, $e);

            $success = false;
        }

        if($success)
        {
            $message = '¡Se ha actualizado el perfil correctamente!';
        }
        else
        {
            $message = '¡Error al actualizar el perfil!';
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
    public function destroy(Request $request, Profile $profile)
    {
        $status = !empty($request->get('status')) ? $request->get('status') : 0;
        
        $status_success = $status == 1 ? 'activado' : 'desactivado';

        $status_error = $status == 1 ? 'activar' : 'desactivar';

        DB::beginTransaction();

        try {
            $profile->status = !empty($request->get('status')) ? $request->get('status') : 0;
            $profile->save();

            logs_store("Se ha $status_success el perfil $profile->name - id: $profile->id", 1);

            DB::commit();

            $success = true;
        } catch (\Exception $e) {
            DB::rollback();
            
            logs_store("Error al $status_error el perfil - id: $profile->id", 0, $e);

            $success = false;
        }

        if($success)
        {
            $message = "¡Se ha $status_success el perfil correctamente!";
        }
        else
        {
            $message = "¡Error al $status_error el perfil!";
        }

        //$request->session()->flash('message', [$success, $message]);

        return response()->json(['success' => $success, 'message' => $message]);
    }
}
