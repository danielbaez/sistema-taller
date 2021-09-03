<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use App\Http\Requests\BrandRequest;
use Illuminate\Support\Facades\DB;

class BrandsController extends Controller
{
    public $title = 'Marcas';
    public $titleForm = 'Marca';
    public $titleMessageLog = 'la marca';

    public function __construct()
    {
        userPermissions($this);
    }

    public function index(Request $request)
    {
        $resource = explode(".", $request->route()->getName())[0];

        if($request->ajax())
        {
            $data = Brand::orderBy('id', 'desc')->get();

            return datatablesGeneric($data, $request, $resource);
        }

        $title = $this->title;
        $titleForm = $this->titleForm;

        $columns = [
            ['title' => '#', 'data' => 'id', 'export' => 'true', 'orderable' => 'true', 'searchable' => 'true'],
            ['title' => 'Nombre', 'data' => 'name', 'export' => 'true', 'orderable' => 'true', 'searchable' => 'true'],
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
    public function store(BrandRequest $request)
    {
        try {
            DB::beginTransaction();

            $request->request->add(['status' => 1]);

            $brand = Brand::create($request->all());

            logsStore("store", "$this->titleMessageLog $brand->name - id: $brand->id", 1);

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
        return Brand::findOrFail($id);
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
    public function update(BrandRequest $request, Brand $brand)
    {
        try {
            DB::beginTransaction();
            
            $brand->update($request->all());

            logsStore("update", "$this->titleMessageLog $brand->name - id: $brand->id", 1);

            DB::commit();

            $success = true;
        } catch (\Exception $e) {
            DB::rollback();
            
            logsStore("update", "$this->titleMessageLog - id: $brand->id", 0, $e);

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
    public function destroy(Request $request, Brand $brand)
    {
        return destroyGeneric($request, $brand, $this->titleMessageLog.' '.$brand->name);
    }
}
