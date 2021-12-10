<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
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
            'payment_type' => 'required',
            'party_type' => 'required',
            'party' => 'required',
            /*'against' => 'required',
            'voucher_no' => 'required',*/
            //'amount' => 'required',
            'payment_mode' => 'required',
            'cheque_no' => 'required_if:payment_mode,bank',
            'cheque_date' => 'required_if:payment_mode,bank',
            'contact' => 'required',
            'remarks' => 'required',
            'items' => 'sometimes|nullable|required|array',
            // 'items.*.party_type' => 'required_with:items',
            // 'items.*.party' => 'required_with:items',
            //'items.*.against' => 'required_with:items',
            //'items.*.voucher_no' => 'required_with:items',
           // 'items.*.amount' => 'required_with:items'
        ];
    }
}
