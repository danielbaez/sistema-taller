<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ClientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'name' => ['required', Rule::unique('clients', 'name')->ignore($this->client)],
            //'document_number' => 'required_with:document_id',
            //'document_id' => 'required_with:document_number',
            'document_id' => 'required',
            //'document_number' => 'required_unless:document_id,-',
            //'document_number' => 'exclude_if:document_id,-|required',
            'email' => 'nullable|regex:/(.+)@(.+)\.(.+)/i',
            //'company_name' => 'requiredIf:document_id,6',
            'company_name' => ['exclude_unless:document_id,6', 'required', Rule::unique('clients', 'company_name')->ignore($this->client)]
        ];

        if($this->document_id != '' && $this->document_id != '-')
        {
            $rules['document_number'] = ['required', Rule::unique('clients', 'document_number')->ignore($this->client)];
        }

        return $rules;
    }

    public function attributes()
    {
        return [
            'name' => 'Nombre',
            'document_id' => 'Documento',
            'document_number' => 'Nro Documento',
            'email' => 'Email',
            'company_name' => 'Razón Social'
        ];
    }

    public function messages()
    {
        return [
            //'company_name.required_if'  => 'El campo :attribute es obligatorio cuando el campo :other es RUC',
        ];
    }
}
