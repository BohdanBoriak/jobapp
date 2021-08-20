<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
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
            'email' => 'email|unique:App\Models\User,email|required',
            'password' => 'string|min:6|max:20|required',
            'first_name' => 'nullable|string|max:20',
            'second_name' => 'nullable|string|max:40',
            'country' => 'nullable|string|max:100',
            'city' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:30',
            'role' => [
                'required',
                Rule::in(['worker', 'employer']), //add 'admin' to array if you want to be able register and admin
            ],
        ];
    }
}
