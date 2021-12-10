<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseReceiptRequest extends FormRequest
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
            'supplier_id' => 'required',
            'receipt_quantity'=>'numeric|min:0|not_in:0',
            'no_of_container'=>'numeric|min:0|not_in:0',
            /*'batch_id' => 'required',*/
            /*'user_id' => 'required',*/
            /*'warehouse_id' => 'required',*/
        ];
    }
}
