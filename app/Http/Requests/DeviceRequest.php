<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DeviceRequest extends FormRequest
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
            'category_id' => 'required',
            'brand_id' => 'required',
            'model_id' => 'required',
            'serial_number' => ['required', Rule::unique('devices', 'serial_number')->ignore($this->device)]
        ];
    }

    public function attributes()
    {
        return [
            'category_id' => 'Categoría',
            'brand_id' => 'Marca',
            'model_id' => 'Modelo',
            'serial_number' => 'Nro Serie'
        ];
    }
}
