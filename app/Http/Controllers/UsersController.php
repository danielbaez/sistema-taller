<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\RoleRequest;
use DataTables;
use Illuminate\Support\Facades\DB;
use App\Models\Role;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
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
            $data = User::orderBy('id', 'desc')->get();
            return Datatables::of($data)
                ->addColumn('action', function($row) use ($resource) {
                    $btn = view('partials.options', compact('row', 'resource'))->render();
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $title = 'Usuarios';
        $titleForm = 'Usuario';

        $columns = [
            ['title' => '#', 'data' => 'id', 'export' => 'true', 'orderable' => 'true', 'searchable' => 'true'],
            ['title' => 'Nombre', 'data' => 'name', 'export' => 'true', 'orderable' => 'true', 'searchable' => 'true'],
            ['title' => 'Estado', 'data' => 'status_name', 'export' => 'true', 'orderable' => 'true', 'searchable' => 'true']
        ];

        if(hasAnyPermission([$resource.'.edit', $resource.'.destroy', $resource.'.activate']))
        {
            $columns[] = ['title' => 'Acción', 'data' => 'action', 'export' => 'false', 'orderable' => 'false', 'searchable' => 'false'];
        }

        $roles = Role::all();

        return view($resource.'.index', compact('title', 'titleForm', 'columns', 'resource', 'roles'));
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
    public function store(UserRequest $request)
    {
        DB::beginTransaction();

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'status' => 1
            ]);

            //$user->roles()->sync($request->roles);

            logsStore("Se ha creado el usuario $user->name - id: $user->id", 1);

            //throw new \Exception("Hubo un error en la transacción");

            DB::commit();

            $success = true;
        } catch (\Exception $e) {
            DB::rollback();
            
            logsStore("Error al crear el usuario", 0, $e);

            $success = false;
        }

        if($success)
        {
            $message = '¡Se ha registrado el usuario correctamente!';
        }
        else
        {
            $message = '¡Error al registrar el usuario!';
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
        return User::findOrFail($id);
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
    public function update(UserRequest $request, User $user)
    {
        DB::beginTransaction();

        try {
            $user->name = $request->get('name');
            $user->email = $request->get('email');

            if(!empty($request->password))
            {
                $user->password = Hash::make($request->password);    
            }
            
            $user->save();

            logsStore("Se ha actualizado el usuario $user->name - id: $user->id", 1);

            DB::commit();

            $success = true;
        } catch (\Exception $e) {
            DB::rollback();
            
            logsStore("Error al actualizar el usuario - id: $user->id", 0, $e);

            $success = false;
        }

        if($success)
        {
            $message = '¡Se ha actualizado el usuario correctamente!';
        }
        else
        {
            $message = '¡Error al actualizar el usuario!';
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
    public function destroy(Request $request, User $user)
    {
        return destroyGeneric($request, $user, 'el usuario '.$user->name);
    }
}
