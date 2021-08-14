<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Branch;
use App\Http\Requests\BranchRequest;
use Illuminate\Support\Facades\DB;

class BranchesController extends Controller
{
    public $title = 'Sucursales';
    public $titleForm = 'Sucursal';
    public $titleMessageLog = 'la sucursal';

    public function __construct()
    {
        userPermissions($this);
    }

    public function index(Request $request)
    {
        $resource = explode(".", $request->route()->getName())[0];

        if($request->ajax())
        {
            $data = Branch::orderBy('id', 'desc')->get();

            return datatablesGeneric($data, $request, $resource);
        }

        $title = $this->title;
        $titleForm = $this->titleForm;

        $columns = [
            ['title' => '#', 'data' => 'id', 'export' => 'true', 'orderable' => 'true', 'searchable' => 'true'],
            ['title' => 'Nombre', 'data' => 'name', 'export' => 'true', 'orderable' => 'true', 'searchable' => 'true'],
            ['title' => 'Documento', 'data' => 'document_number', 'export' => 'true', 'orderable' => 'true', 'searchable' => 'true'],
            ['title' => 'Dirección', 'data' => 'address', 'export' => 'true', 'orderable' => 'true', 'searchable' => 'true'],
            ['title' => 'Teléfono', 'data' => 'phone', 'export' => 'true', 'orderable' => 'true', 'searchable' => 'true'],
            ['title' => 'Estado', 'data' => 'status_name', 'export' => 'true', 'orderable' => 'true', 'searchable' => 'true']
        ];

        $columns = array_filter(array_merge($columns, permissionsToShowActionButton($resource)));

        return view($resource.'.index', compact('title', 'titleForm', 'columns', 'resource'));
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
    public function store(BranchRequest $request)
    {
        try {
            DB::beginTransaction();

            $branch = Branch::create($request->all());

            logsStore("store", "$this->titleMessageLog $branch->name - id: $branch->id", 1);

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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Branch::findOrFail($id);
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
    public function update(BranchRequest $request, Branch $branch)
    {
        try {
            DB::beginTransaction();
            
            $branch->update($request->all());

            logsStore("update", "$this->titleMessageLog $branch->name - id: $branch->id", 1);

            DB::commit();

            $success = true;
        } catch (\Exception $e) {
            DB::rollback();
            
            logsStore("update", "$this->titleMessageLog - id: $branch->id", 0, $e);

            $success = false;
        }

        $message = actionMessage('update', $success, $this->titleMessageLog);

        return response()->json(['success' => $success, 'message' => $message]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Branch $branch)
    {
        return destroyGeneric($request, $branch, $this->titleMessageLog.' '.$branch->name);
    }
}
