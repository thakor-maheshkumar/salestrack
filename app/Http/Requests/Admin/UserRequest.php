<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

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
        $rules = [
            'roles' => 'required|array|min:1',
            'role.*' => 'required|exists:roles,id',
            /*'company_id' => 'required',*/
            'suffix' => 'required',
            'first_name' => 'required',
            'middle_name' => 'required',
            'last_name' => 'required',
            'date_of_birth' => 'sometimes|required|date_format:d/m/Y|before:tomorrow',
            'country_id' => 'required|exists:countries,id',
            'photo' => 'sometimes|nullable|image|mimes:jpg,jpeg,png,gif,svg',
            'pan_no' => 'sometimes|nullable|alpha_num|size:10',
            'pan_photo' => 'sometimes|nullable|image|mimes:jpg,jpeg,png,gif,svg',
            'aadhar_no' => 'sometimes|nullable|digits:12',
            'aadhar_photo' => 'sometimes|nullable|image|mimes:jpg,jpeg,png,gif,svg',
            'employee_code' => 'required',
            'departments' => 'required|array|min:1',
            'departments.*.department' => 'required|exists:departments,id',
            'departments.*.start_date' => 'sometimes|required',
            'departments.*.end_date' => 'sometimes|required',
        ];

        if (\Route::current()->getName() == 'users.store')
        {
            $rules['email'] = 'required|email|unique:users,email';
            $rules['password'] = 'required|min:8';
        }
        else
        {
            $rules['email'] = 'required|email|unique:users,email,"' . $this->getLastFragment() . '"';
            $rules['password'] = 'sometimes|nullable|min:8';
        }

        return $rules;
    }

    public function getLastFragment()
    {
        $segment = explode('/', $this->url());
        return $id = end($segment);
    }

    public function messages()
    {
        return [
            'departments.*.start_date' => 'Department start date field is required',
            'departments.*.end_date' => 'Department end date field is required',
        ];
    }
}
