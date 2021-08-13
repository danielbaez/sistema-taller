<?php

namespace App\Http\Controllers;

use App\Models\UserAccount;
use App\Models\User;
use App\Models\Role;
use App\Models\Branch;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\UserAccountRequest;
use Illuminate\Support\Facades\DB;

class UsersAccountsController extends Controller
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
            $data = UserAccount::with('user')->with('role')->with('branch')->orderBy('id', 'desc')->get();
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

        $title = 'Roles de Usuarios';
        $titleForm = 'Rol de Usuario';

        $columns = [
            ['title' => '#', 'data' => 'id', 'export' => 'true', 'orderable' => 'true', 'searchable' => 'true'],
            ['title' => 'Usuario', 'data' => 'user.name', 'export' => 'true', 'orderable' => 'true', 'searchable' => 'true'],
            ['title' => 'Rol', 'data' => 'role.name', 'export' => 'true', 'orderable' => 'true', 'searchable' => 'true'],
            ['title' => 'Sucursal', 'data' => 'branch.name', 'export' => 'true', 'orderable' => 'true', 'searchable' => 'true'],
            ['title' => 'Estado', 'data' => 'status_name', 'export' => 'true', 'orderable' => 'true', 'searchable' => 'true']
        ];

        if(hasAnyPermission([$resource.'.edit', $resource.'.destroy', $resource.'.activate']))
        {
            $columns[] = ['title' => 'Acción', 'data' => 'action', 'export' => 'false', 'orderable' => 'false', 'searchable' => 'false'];
        }

        $users = User::all();
        $roles = Role::all();
        $branches = Branch::all();

        return view($resource.'.index', compact('title', 'titleForm', 'columns', 'resource', 'users', 'roles', 'branches'));
    }

    public function store(UserAccountRequest $request)
    {
        DB::beginTransaction();

        try {
            $userAccount = UserAccount::create($request->all());

            logsStore("Se ha creado el rol de usuario - id: $userAccount->id", 1);

            //throw new \Exception("Hubo un error en la transacción");

            DB::commit();

            $success = true;
        } catch (\Exception $e) {
            DB::rollback();
            
            logsStore("Error al crear el rol de usuario", 0, $e);

            $success = false;
        }

        if($success)
        {
            $message = '¡Se ha registrado el rol de usuario correctamente!';
        }
        else
        {
            $message = '¡Error al registrar el rol de usuario!';
        }

        //$request->session()->flash('message', [$success, $message]);

        return response()->json(['success' => $success, 'message' => $message]);
    }

    public function show($id)
    {
        return UserAccount::with('user')
        ->with('role')
        ->with('branch')
        ->orderBy('id', 'desc')
        ->where('id', $id)
        ->first();
    }

    public function update(UserAccountRequest $request, UserAccount $userAccount)
    {
        DB::beginTransaction();

        try {
            $userAccount->update($request->all());

            logsStore("Se ha actualizado el rol de usuario - id: $userAccount->id", 1);

            DB::commit();

            $success = true;
        } catch (\Exception $e) {
            DB::rollback();
            
            logsStore("Error al actualizar el rol de usuario - id: $userAccount->id", 0, $e);

            $success = false;
        }

        if($success)
        {
            $message = '¡Se ha actualizado el rol de usuario correctamente!';
        }
        else
        {
            $message = '¡Error al actualizar el rol de usuario!';
        }

        //$request->session()->flash('message', [$success, $message]);

        return response()->json(['success' => $success, 'message' => $message]);
    }

    public function destroy(Request $request, UserAccount $userAccount)
    {
        return destroyGeneric($request, $userAccount, 'el rol de usuario');
    }

    public function rolesList(Request $request)
    {
        $usersAccounts = UserAccount::where('user_id', Auth::user()->id)
        ->with(['role', 'branch'])->get();

        $count = $usersAccounts->countBy(function ($item) {
            return $item->role->status == 1 && $item['status'] == 1 ? 1 : 0;
        })->toArray();

        $status = 1;

        if(array_key_exists($status, $count) && $count[$status] == 1)
        {
            foreach ($usersAccounts as $key => $value) {
                if($value->status == 1 && $value->role->status == 1)
                {
                    return redirect()->route('enterRole', ['userAccountId' => $value->id]);
                }
            }
        }

        //config(['adminlte.menu' => []]);
        //config(['adminlte.classes_sidebar' => 'd-none']);
        //config(['adminlte.classes_content_wrapper' => 'm-0']);

        return view('role_list', compact('usersAccounts'));
    }

    public function enterRole(Request $request, $userAccountId)
    {
    	$user_account = UserAccount::whereId($userAccountId)
        ->active()
    	->first();

    	if($user_account)
    	{
            $request->session()->put('userAccountId', $user_account->id);
    		$request->session()->put('roleId', $user_account->role_id);
            $request->session()->put('branchId', $user_account->branch_id);

            logsStore("Ingresa con el perfil", 1);

    		return redirect()->route('dashboard');
    	}

    	return redirect()->back();
    }

}
