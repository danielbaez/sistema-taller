<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileRequest extends FormRequest
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
            //'name' => 'required|unique:profiles|max:20',
            'name' => [
                'required',
                Rule::unique('profiles', 'name')->ignore($this->profile),
            ],
            //'status' => 'required|in:0,1'
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Perfil',
            //'status' => 'Estado'
        ];
    }
}
