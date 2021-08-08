<?php

namespace App\Http\Controllers;

use App\Models\User_account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Role;

class UserAccountsController extends Controller
{
    public function rolesList(Request $request)
    {
        $user_accounts = User_account::where('user_id', Auth::user()->id)
        ->with(['role', 'branch'])->get();

        $count = $user_accounts->countBy(function ($item) {
            return $item->role->status == 1 && $item['status'] == 1 ? 1 : 0;
        })->toArray();

        $status = 1;

        if(array_key_exists($status, $count) && $count[$status] == 1)
        {
            foreach ($user_accounts as $key => $value) {
                if($value->status == 1 && $value->role->status == 1)
                {
                    return redirect()->route('enterRole', ['user_account_id' => $value->id]);
                }
            }
        }

        //config(['adminlte.menu' => []]);
        //config(['adminlte.classes_sidebar' => 'd-none']);
        //config(['adminlte.classes_content_wrapper' => 'm-0']);

        return view('role_list', compact('user_accounts'));
    }

    public function enterRole(Request $request, $user_account_id)
    {
    	$user_account = User_account::whereId($user_account_id)
        ->active()
    	->first();

    	if($user_account)
    	{
            $request->session()->put('user_account_id', $user_account->id);
    		$request->session()->put('role_id', $user_account->role_id);
            $request->session()->put('branch_id', $user_account->branch_id);

            logsStore("Ingresa con el perfil", 1);

    		return redirect()->route('dashboard');
    	}

    	return redirect()->back();
    }

}
