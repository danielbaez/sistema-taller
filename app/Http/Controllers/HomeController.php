<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use DataTables;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function users(Request $request)
    {
        if($request->ajax())
        {
            //dd(request('aaa'));
            $data = User::latest();
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

        //$profiles = Profile::all();
      
        return view('profiles.index');
    }
}
