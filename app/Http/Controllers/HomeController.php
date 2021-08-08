<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use DataTables;

class HomeController extends Controller
{
    public function __construct()
    {
        userPermissions($this, ['dashboard'], false);
    }

    public function index()
    {
        return redirect()->route('login');        
    }

    public function dashboard()
    {
        return view('dashboard');
    }

    public function users(Request $request)
    {
        if($request->ajax())
        {
            //dd(request('aaa'));
            //$data = User::get();
            $data = User::orderBy('id', 'desc')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->filter(function ($query) use ($request) {
                    // if (request()->has('name')) {
                    //     $query->where('name', 'like', "%" . request('name') . "%");
                    // }

                    // if (request()->has('email')) {
                    //     $query->where('email', 'like', "%" . request('email') . "%");
                    // }
                    if($request->get('aaa')) {
                        $query->where('id', 'like', "%" . $request->get('aaa') . "%");
                    }
                }, true)
                ->addColumn('action', function($row){
                    $resource = 'users';
                    $btn = view('partials.options', compact('row', 'resource'))->render();
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        //$roles = Role::all();
      
        return view('home');
    }
}
