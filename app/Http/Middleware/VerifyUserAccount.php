<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Models\UserAccount;
use Illuminate\Support\Facades\Session;

class VerifyUserAccount
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $pass = false;

        $roleId = Session::has('roleId') ? Session::get('roleId') : false;

        if($roleId)
        {
            //$role = Role::where('id', $roleId)->where('status', 1)->first();

            $userAccount = Role::join('user_accounts', 'roles.id', '=', 'user_accounts.role_id')
            ->where('roles.status', 1)
            ->where('user_accounts.user_id', auth()->user()->id)
            ->where('user_accounts.role_id', $roleId)
            ->where('user_accounts.status', 1)
            ->first();

            if($userAccount)
            {
                $permissions = $userAccount->permissions->makeHidden(['pivot', 'description', 'status_name', 'created_at', 'updated_at'])->toArray();

                $request->session()->put('roleName', $userAccount->name);
                $request->session()->put('permissions', $permissions);

                $pass = true;                
            }          
        }

        if(!$pass)
        {
            return redirect()->route('rolesList');
        }

        return $next($request);
    }
}
