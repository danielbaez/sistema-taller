<?php

namespace App\Http\Controllers;

use App\Models\UserAccount;
use App\Models\User;
use App\Models\Role;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\UserAccountRequest;
use Illuminate\Support\Facades\DB;
use App\Providers\RouteServiceProvider;

class UsersAccountsController extends Controller
{
    public $title = 'Roles de Usuarios';
    public $titleForm = 'Rol de Usuario';
    public $titleMessageLog = 'el rol de usuario';

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

            return datatablesGeneric($data, $request, $resource);
        }

        $title = $this->title;
        $titleForm = $this->titleForm;

        $columns = [
            ['title' => '#', 'data' => 'id', 'export' => 'true', 'orderable' => 'true', 'searchable' => 'true'],
            ['title' => 'Usuario', 'data' => 'user.name', 'export' => 'true', 'orderable' => 'true', 'searchable' => 'true'],
            ['title' => 'Rol', 'data' => 'role.name', 'export' => 'true', 'orderable' => 'true', 'searchable' => 'true'],
            ['title' => 'Sucursal', 'data' => 'branch.name', 'export' => 'true', 'orderable' => 'true', 'searchable' => 'true'],
            ['title' => 'Estado', 'data' => 'status_name', 'export' => 'true', 'orderable' => 'true', 'searchable' => 'true']
        ];

        $columns = array_filter(array_merge($columns, permissionsToShowActionButton($resource)));

        $users = User::all();
        $roles = Role::all();
        $branches = Branch::all();

        return view($resource.'.index', compact('title', 'titleForm', 'columns', 'resource', 'users', 'roles', 'branches'));
    }

    public function store(UserAccountRequest $request)
    {
        try {
            DB::beginTransaction();

            $request->request->add(['status' => 1]);

            $userAccount = UserAccount::create($request->all());

            logsStore("store", "$this->titleMessageLog - id: $userAccount->id", 1);

            DB::commit();

            $success = true;
        } catch (\Exception $e) {
            DB::rollback();
            
            logsStore("store", $this->titleMessageLog, 0, $e);

            $success = false;
        }

        $message = actionMessage('store', $success, $this->titleMessageLog);

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
        try {
            DB::beginTransaction();
            
            $userAccount->update($request->all());

            logsStore("update", "$this->titleMessageLog - id: $userAccount->id", 1);

            DB::commit();

            $success = true;
        } catch (\Exception $e) {
            DB::rollback();
            
            logsStore("update", "$this->titleMessageLog - id: $userAccount->id", 0, $e);

            $success = false;
        }

        $message = actionMessage('update', $success, $this->titleMessageLog);

        return response()->json(['success' => $success, 'message' => $message]);
    }

    public function destroy(Request $request, UserAccount $userAccount)
    {
        return destroyGeneric($request, $userAccount, $this->titleMessageLog);
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

            logsStore(false, "Ingresa con el rol de usuario id: $user_account->id", 1);

    		return redirect(RouteServiceProvider::HOME);
    	}

    	return redirect()->back();
    }

}
