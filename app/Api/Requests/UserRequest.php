<?php

namespace Api\Requests;

use App\Http\Requests\Request;

class UserRequest extends Request
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
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'phone' => 'required|max:15|unique:users',
            'postal_code' => 'digits:4',
            'birth_date' => 'date_format:d.m.Y',
            'password' => 'confirmed|min:8',
        ];
    }
}
