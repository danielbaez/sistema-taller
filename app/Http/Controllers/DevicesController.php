<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Model;
use App\Models\Device;
use App\Http\Requests\DeviceRequest;
use Illuminate\Support\Facades\DB;

class DevicesController extends Controller
{
    public $title = 'Equipos';
    public $titleForm = 'Equipo';
    public $titleMessageLog = 'el equipo';

    public function __construct()
    {
        userPermissions($this);
    }

    public function index(Request $request)
    {
        $resource = explode(".", $request->route()->getName())[0];

        if($request->ajax())
        {
            $data = Device::with('category')
            ->with('brand')
            ->with('model')
            ->orderBy('devices.id', 'desc')->get();

            return datatablesGeneric($data, $request, $resource);
        }

        $title = $this->title;
        $titleForm = $this->titleForm;

        $columns = [
            ['title' => '#', 'data' => 'id', 'export' => 'true', 'orderable' => 'true', 'searchable' => 'true'],
            ['title' => 'Categoría', 'data' => 'category.name', 'export' => 'true', 'orderable' => 'true', 'searchable' => 'true'],
            ['title' => 'Marca', 'data' => 'brand.name', 'export' => 'true', 'orderable' => 'true', 'searchable' => 'true'],
            ['title' => 'Modelo', 'data' => 'model.name', 'export' => 'true', 'orderable' => 'true', 'searchable' => 'true'],
            ['title' => 'Nro Serie', 'data' => 'serial_number', 'export' => 'true', 'orderable' => 'true', 'searchable' => 'true'],
            ['title' => 'Estado', 'data' => 'status_name', 'export' => 'true', 'orderable' => 'true', 'searchable' => 'true']
        ];

        $columns = array_filter(array_merge($columns, permissionsToShowActionButton($resource)));

        $categories = Category::all();
        $brands = Brand::all();
        $models = Model::all();

        return view($resource.'.index', compact('title', 'titleForm', 'columns', 'resource', 'categories', 'brands', 'models'));
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
    public function store(DeviceRequest $request)
    {
        try {
            DB::beginTransaction();

            $request->request->add(['status' => 1, 'user_id' => auth()->user()->id]);

            $device = Device::create($request->all());

            logsStore("store", "$this->titleMessageLog - id: $device->id", 1);

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
        return Device::findOrFail($id);
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
    public function update(DeviceRequest $request, Device $device)
    {
        try {
            DB::beginTransaction();

            $request->request->add(['user_id' => auth()->user()->id]);
            
            $device->update($request->all());

            logsStore("update", "$this->titleMessageLog - id: $device->id", 1);

            DB::commit();

            $success = true;
        } catch (\Exception $e) {
            DB::rollback();
            
            logsStore("update", "$this->titleMessageLog - id: $device->id", 0, $e);

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
    public function destroy(Request $request, Device $device)
    {
        return destroyGeneric($request, $device, $this->titleMessageLog.' '.$device->name);
    }
}
