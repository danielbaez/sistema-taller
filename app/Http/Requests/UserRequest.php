<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
        if($this->method() == 'POST')
        {
            return [
                'name' => ['required', Rule::unique('users', 'name')->ignore($this->user)],
                'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($this->user)],
                'password' => 'required|min:6|max:12'
            ];
        }
        if($this->method() == 'PUT')
        {
            $rules = [
                'name' => ['required', Rule::unique('users', 'name')->ignore($this->user)],
                'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($this->user)],
            ];

            if(!empty($this->input('password')))
            {
                $rules['password'] = 'required|min:6|max:12';
            }

            return $rules;
        }

        
    }

    public function attributes()
    {
        return [
            'name' => 'Nombre',
            'email' => 'Email',
            'password' => 'Contraseña'
        ];
    }
}
