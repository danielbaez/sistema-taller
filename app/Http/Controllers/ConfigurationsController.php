<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Configuration;
use App\Http\Requests\ConfigurationRequest;
use Illuminate\Support\Facades\DB;

class ConfigurationsController extends Controller
{
    public $title = 'Configuración';
    public $titleForm = 'Configuración';
    public $titleMessageLog = 'la configuración';

    public function __construct()
    {
        userPermissions($this);
    }

    public function index(Request $request)
    {
        $resource = explode(".", $request->route()->getName())[0];

        if($request->ajax())
        {
            $data = Configuration::orderBy('id', 'desc')->get();

            return datatablesGeneric($data, $request, $resource, [['name' => 'logo', 'view' => 'partials.image']]);
        }

        $title = $this->title;
        $titleForm = $this->titleForm;

        $columns = [
            ['title' => 'Empresa', 'data' => 'company', 'export' => 'true', 'orderable' => 'false', 'searchable' => 'true'],
            ['title' => 'RUC', 'data' => 'document_number', 'export' => 'true', 'orderable' => 'false', 'searchable' => 'true'],
            ['title' => 'Dirección', 'data' => 'address', 'export' => 'true', 'orderable' => 'false', 'searchable' => 'true'],
            ['title' => 'Teléfono', 'data' => 'phone', 'export' => 'true', 'orderable' => 'false', 'searchable' => 'true'],
            ['title' => 'Logo', 'data' => 'logo', 'export' => 'true', 'orderable' => 'false', 'searchable' => 'true']
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Configuration::findOrFail($id);
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
    public function update(ConfigurationRequest $request, Configuration $configuration)
    {
        try {
            DB::beginTransaction();

            if($request->file('logo'))
            {
                $imagePath = $request->file('logo');
                $imageName = $imagePath->getClientOriginalName();
                $fileExtension = $imagePath->getClientOriginalExtension();
                $fileName = time().$fileExtension;

                $path = $request->file('logo')->storeAs('uploads', $fileName, 'public');
            }
            else
            {
                $path = $configuration->logo;
            }

            $configuration->company = $request->company;
            $configuration->document_number = $request->document_number;
            $configuration->address = $request->address;
            $configuration->phone = $request->phone;
            $configuration->logo = $path;
            $configuration->save();

            logsStore("update", "$this->titleMessageLog", 1);

            DB::commit();

            $success = true;
        } catch (\Exception $e) {
            DB::rollback();
            
            logsStore("update", "$this->titleMessageLog", 0, $e);

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
    public function destroy($id)
    {
        //
    }
}
