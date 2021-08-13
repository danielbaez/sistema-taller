<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserAccountRequest extends FormRequest
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
            'user_id' => ['required', Rule::unique('user_accounts','user_id')->where('role_id',$this->role_id)->where('branch_id',$this->branch_id)->ignore($this->userAccount)
      		],
      		'role_id' => ['required', Rule::unique('user_accounts','role_id')->where('user_id',$this->user_id)->where('branch_id',$this->branch_id)->ignore($this->userAccount)
      		],
        ];

        if($this->role_id == 2)
        {
            $rules['branch_id'] = ['required', Rule::unique('user_accounts','branch_id')->where('user_id',$this->user_id)->where('role_id',$this->role_id)->ignore($this->userAccount)
      		];
        }

        return $rules;
    }

    public function attributes()
    {
        return [
            'user_id' => 'Usuario',
            'role_id' => 'Rol',
            'branch_id' => 'Sucursal',
        ];
    }
}
