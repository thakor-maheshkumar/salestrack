<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StockItemRequest extends FormRequest
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
            'name' => 'required',
            //'product_descriptiopn' => 'required',
            //'under' => 'required|exists:stock_group,id',
            //'part_no' => 'required',
            'category_id' => 'required|exists:stock_categories,id',
            'unit_id' => 'bail|required|exists:inventory_units,id',
            //'alternate_unit_id' => 'required|exists:inventory_units,id|not_in:' . $this->unit_id,
            'convertion_rate' => 'required_unless:alternate_unit_id,0',
            'shipper_pack' => 'required',
            'is_allow_mrp' => 'required|in:0,1',
            'is_maintain_in_batches' => 'required|in:0,1',
            'track_manufacture_date' => 'required|in:0,1',
            'use_expiry_dates' => 'required|in:0,1',
            'is_gst_detail' => 'required|in:0,1',
            'taxability' => 'required_if:is_gst_detail,1',
            'is_reverse_charge' => 'required_if:taxability,taxable',
            'rate' => 'required_if:taxability,taxable',
            'applicable_date' => 'required_if:taxability,taxable',
            'default_warehouse' => 'required',
            'supply_type' => 'required',
            'hsn_code' => 'nullable|digits_between:1,8',

            'opening_stock' => 'required_if:maintain_stock,==,1',
            /*'maintain_stock' => 'required',*/
           // 'product_code' => 'required',
            'cas_no' => [
                'nullable',
                'regex:/^[\d]{2,7}-[\d]{2}-[\d]{1}$/'
            ],
            //'pack_code' => 'required',
        ];
    }
    public function messages()
    {
        return [
        'convertion_rate.required_unless' => 'The convertion rate field is required when alternate unit is selected',
        //'body.required' => 'A message is required',
    ];
    }
}
