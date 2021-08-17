<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConfigurationRequest extends FormRequest
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
            'company' => 'required',
            'document_number' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'logo' => !empty($this->file('logo')) ? 'required|image|mimes:jpeg,png,jpg|max:2048' : ''
        ];
    }

    public function attributes()
    {
        return [
            'company' => 'Perfil',
            'document_number' => 'RUC',
            'address' => 'Dirección',
            'phone' => 'Teléfono',
            'logo' => 'Logo'
        ];
    }
}
