<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class VacancyRequest extends FormRequest
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
//        dd(Auth::user()->companies);
        return [
            'name' => 'string|required|max:100',
            'amount' => 'integer|required',
            'salary' => 'integer|required',
            'company_id' => 'integer|min:1|' . Rule::in(Auth::user()->companies->map(function ($company) {
                        return $company->id;
                })->toArray())
        ];
    }
}
