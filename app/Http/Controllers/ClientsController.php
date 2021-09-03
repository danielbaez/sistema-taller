<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Document;
use App\Http\Requests\ClientRequest;
use Illuminate\Support\Facades\DB;

class ClientsController extends Controller
{
    public $title = 'Clientes';
    public $titleForm = 'Cliente';
    public $titleMessageLog = 'el cliente';

    public function __construct()
    {
        userPermissions($this);
    }

    public function index(Request $request)
    {
        $resource = explode(".", $request->route()->getName())[0];

        if($request->ajax())
        {
            $data = Client::with('document')->orderBy('id', 'desc')->get();

            return datatablesGeneric($data, $request, $resource);
        }

        $title = $this->title;
        $titleForm = $this->titleForm;

        $columns = [
            ['title' => '#', 'data' => 'id', 'export' => 'true', 'orderable' => 'true', 'searchable' => 'true'],
            ['title' => 'Nombre', 'data' => 'name', 'export' => 'true', 'orderable' => 'true', 'searchable' => 'true'],
            ['title' => 'Documento', 'data' => 'document.name', 'export' => 'true', 'orderable' => 'true', 'searchable' => 'true'],
            ['title' => 'Nro Documento', 'data' => 'document_number', 'export' => 'true', 'orderable' => 'true', 'searchable' => 'true'],
            ['title' => 'Razón Social', 'data' => 'company_name', 'export' => 'true', 'orderable' => 'true', 'searchable' => 'true'],
            ['title' => 'Dirección', 'data' => 'address', 'export' => 'true', 'orderable' => 'true', 'searchable' => 'true', 'visible' => 'false'],
            ['title' => 'Teléfono', 'data' => 'phone', 'export' => 'true', 'orderable' => 'true', 'searchable' => 'true', 'visible' => 'false'],
            ['title' => 'Email', 'data' => 'email', 'export' => 'true', 'orderable' => 'true', 'searchable' => 'true', 'visible' => 'false'],
            ['title' => 'Estado', 'data' => 'status_name', 'export' => 'true', 'orderable' => 'true', 'searchable' => 'true']
        ];

        $columns = array_filter(array_merge($columns, permissionsToShowActionButton($resource)));

        $documents = Document::where('operation', 'Persona')
        ->where('status', 1)
        ->get();

        return view($resource.'.index', compact('title', 'titleForm', 'columns', 'resource', 'documents'));
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
    public function store(ClientRequest $request)
    {
        try {
            DB::beginTransaction();

            $request->request->add(['status' => 1]);

            $client = Client::create($request->all());

            logsStore("store", "$this->titleMessageLog $client->name - id: $client->id", 1);

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
        return Client::findOrFail($id);
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
    public function update(ClientRequest $request, Client $client)
    {
        try {
            DB::beginTransaction();
            
            $client->update($request->all());

            logsStore("update", "$this->titleMessageLog $client->name - id: $client->id", 1);

            DB::commit();

            $success = true;
        } catch (\Exception $e) {
            DB::rollback();
            
            logsStore("update", "$this->titleMessageLog - id: $client->id", 0, $e);

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
    public function destroy(Request $request, Client $client)
    {
        return destroyGeneric($request, $client, $this->titleMessageLog.' '.$client->name);
    }
}
