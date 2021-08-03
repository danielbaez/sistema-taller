<?php

namespace App\Http\Controllers;

use App\Models\User_account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Spatie\Permission\Models\Role;

class UserAccountsController extends Controller
{
    /*public function profilesList(Request $request)
    {
        $user_accounts = User_account::where('user_id', Auth::user()->id)
        ->with(['profile', 'branch'])->get();

        $count = $user_accounts->countBy(function ($item) {
            return $item->profile->status == 1 && $item['status'] == 1 ? 1 : 0;
        })->toArray();

        $status = 1;

        if(array_key_exists($status, $count) && $count[$status] == 1)
        {
            foreach ($user_accounts as $key => $value) {
                if($value->status == 1 && $value->profile->status == 1)
                {
                    return redirect()->route('enterProfile', ['user_account_id' => $value->id]);
                }
            }
        }

        //config(['adminlte.menu' => []]);
        //config(['adminlte.classes_sidebar' => 'd-none']);
        //config(['adminlte.classes_content_wrapper' => 'm-0']);

        return view('profile_list', compact('user_accounts'));
    }*/

    public function rolesList(Request $request)
    {
        $roles = auth()->user()->getRoleNames()->toArray();
        $user_accounts = Role::whereIn('name', $roles)->get();

        return view('roles_list', compact('user_accounts'));
    }

    /*public function enterProfile(Request $request, $user_account_id)
    {
    	$user_account = User_account::whereId($user_account_id)
        ->active()
    	->first();

    	if($user_account)
    	{
            $request->session()->put('user_account_id', $user_account->id);
    		$request->session()->put('profile_id', $user_account->profile_id);
            $request->session()->put('branch_id', $user_account->branch_id);

            logs_store("Ingresa con el perfil", 1);

    		return redirect()->route('dashboard');
    	}

    	return redirect()->back();
    }*/

    public function enterRol(Request $request, $user_account_id)
    {
        $user_account = Role::whereId($user_account_id)
        ->first();

        if($user_account)
        {
            $request->session()->put('user_account_id', 1);
            $request->session()->put('profile_id', $user_account_id);
            $request->session()->put('branch_id', 1);

            logs_store("Ingresa con el perfil", 1);

            return redirect()->route('dashboard');
        }

        return redirect()->back();
    }
}
