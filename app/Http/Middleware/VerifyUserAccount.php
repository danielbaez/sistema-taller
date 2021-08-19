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
            $role = Role::where('id', $roleId)->where('status', 1)->first();

            if($role)
            {
                $userAccount = UserAccount::where('user_id', auth()->user()->id)->where('role_id', $roleId)->where('status', 1)->first();

                if($userAccount)
                {
                    $permissions = $role->permissions->makeHidden(['pivot', 'description', 'status_name', 'created_at', 'updated_at'])->toArray();

                    $request->session()->put('roleName', $role->name);
                    $request->session()->put('permissions', $permissions);

                    $pass = true;                
                }          
            }
        }

        if(!$pass)
        {
            return redirect()->route('rolesList');
        }

        return $next($request);
    }
}
