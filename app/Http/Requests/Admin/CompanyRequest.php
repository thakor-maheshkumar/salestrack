<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
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
			'firm_type' => 'required',
			/*'reg_type' => 'required',*/
			'address' => 'required',
			'country_id' => 'required|exists:countries,id',
			'email' => 'required|email',
			'fssai' => 'required|digits:14',
			'cin' => 'required|alpha_num|size:21',
			'phone' => 'required|digits_between:10,12',
			'fax' => 'sometimes|nullable|numeric',
			'iec_code' => 'required|digits:10',
			'zipcode' => 'required|digits_between:1,9',
			'aadhar_no' => 'sometimes|nullable|digits:12',
			'pan_no' => 'sometimes|nullable|alpha_num|size:10',
			'gst_no' => 'sometimes|nullable|alpha_num|size:15',
			'company_id' => 'bail|required',
		];

		if (\Route::current()->getName() == 'companies.store')
        {
            $rules['name'] = 'required|unique:companies,name,' . $this->company_id;
        }
        else
        {
            $rules['name'] = 'required|unique:companies,name,"' . $this->getLastFragment() . '"';
        }

		return $rules;
	}

	public function getLastFragment()
    {
        $segment = explode('/', $this->url());
        return $id = end($segment);
    }
}
