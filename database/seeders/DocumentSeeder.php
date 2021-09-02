<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Document;

class DocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Document::create(['id' => '-', 'name' => 'OTROS', 'operation' => 'Persona', 'status' => 1]);
        Document::create(['id' => '0', 'name' => 'NO DOMICILIADO, SIN RUC', 'operation' => 'Persona', 'status' => 1]);
        Document::create(['id' => '01', 'name' => 'FACTURA', 'operation' => 'Comprobante', 'status' => 1]);
        Document::create(['id' => '03', 'name' => 'BOLETA', 'operation' => 'Comprobante', 'status' => 1]);
        Document::create(['id' => '07', 'name' => 'NOTA DE CRÉDITO FACTURA', 'operation' => 'Nota', 'status' => 1]);
        Document::create(['id' => '077', 'name' => 'NOTA DE CRÉDITO BOLETA', 'operation' => 'Nota', 'status' => 1]);
        Document::create(['id' => '08', 'name' => 'NOTA DE DÉBITO FACTURA', 'operation' => 'Nota', 'status' => 1]);
        Document::create(['id' => '088', 'name' => 'NOTA DE DÉBITO BOLETA', 'operation' => 'Nota', 'status' => 1]);
        Document::create(['id' => '1', 'name' => 'DNI', 'operation' => 'Persona', 'status' => 1]);
        Document::create(['id' => '10', 'name' => 'PROFORMA', 'operation' => 'Proforma', 'status' => 1]);
        Document::create(['id' => '11', 'name' => 'GUÍA DE REMISIÓN', 'operation' => 'Guía de Remisión', 'status' => 1]);
        Document::create(['id' => '4', 'name' => 'CARNET DE EXTRANJERIA', 'operation' => 'Persona', 'status' => 1]);
        Document::create(['id' => '5', 'name' => 'GUIA', 'operation' => 'Comprobante', 'status' => 1]);
        Document::create(['id' => '6', 'name' => 'RUC', 'operation' => 'Persona', 'status' => 1]);
        Document::create(['id' => '7', 'name' => 'PASAPORTE', 'operation' => 'Persona', 'status' => 1]);
    }
}
