<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BranchRequest extends FormRequest
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
        return [
            'name' => ['required', Rule::unique('branches', 'name')->ignore($this->branch)],
            'document_number' => 'required|numeric',
            'address' => 'required',
            'phone' => 'required'
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Nombre',
            'document_number' => 'Nro Documento',
            'address' => 'Dirección',
            'phone' => 'Teléfono'
        ];
    }
}
