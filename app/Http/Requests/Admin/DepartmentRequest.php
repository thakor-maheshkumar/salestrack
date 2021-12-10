<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class DepartmentRequest extends FormRequest
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
            /*'parent_unit' => 'required',*/
            'name' => 'required',
            'address' => 'required',
            'country_id' => 'required|exists:countries,id',
            'email' => 'required|email',
            'phone' => 'required|digits_between:10,12'
        ];
    }
}
