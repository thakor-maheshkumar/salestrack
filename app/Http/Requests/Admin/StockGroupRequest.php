<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StockGroupRequest extends FormRequest
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
            'group_name' => 'required|unique:stock_group',
            'is_gst_detail' => 'required|in:0,1',
            'taxability' => 'required_if:is_gst_detail,1',
            'is_reverse_charge' => 'required_if:is_gst_detail,1',
            'gst_rate' => 'required_if:is_gst_detail,1',
            'gst_applicable_date' => 'required_if:is_gst_detail,1',
            'cess_rate' => 'required_if:is_gst_detail,1',
            'cess_applicable_date' => 'required_if:is_gst_detail,1',
        ];
    }
}
