<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseOrderRequest extends FormRequest
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
           /* 'supplier_id' => 'required',
            'branch_id' => 'required',
            'user_id' => 'required',
            'warehouse_id' => 'required',
            'product_descriptiopn' => 'required',
            'under' => 'required|exists:stock_group,id',
            'part_no' => 'required',
            'category_id' => 'required|exists:stock_categories,id',
            'unit_id' => 'bail|required|exists:inventory_units,id',
            'alternate_unit_id' => 'required|exists:inventory_units,id|not_in:' . $this->unit_id,
            'convertion_rate' => 'required|numeric',
            'shipper_pack' => 'required',
            'is_allow_mrp' => 'required|in:0,1',
            'is_allow_part_number' => 'required|in:0,1',
            'is_maintain_in_batches' => 'required|in:0,1',
            'track_manufacture_date' => 'required_if:is_maintain_in_batches,1|nullable|date',
            'use_expiry_dates' => 'required_if:is_maintain_in_batches,1|nullable|date',
            'is_gst_detail' => 'required|in:0,1',
            'taxability' => 'required_if:is_gst_detail,1',
            'is_reverse_charge' => 'required_if:taxability,taxable',
            'tax_type' => 'required_if:taxability,taxable',
            'rate' => 'required_if:taxability,taxable',
            'applicable_date' => 'required_if:taxability,taxable',
            'default_warehouse' => 'required',
            'supply_type' => 'required',
            'hsn_code' => 'required',
            'opening_stock' => 'required',
            'maintain_stock' => 'required',
            'product_code' => 'required',
            'cas_no' => 'required',
            'pack_code' => 'required',*/
        ];
    }
}
