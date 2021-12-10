<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StockRequest extends FormRequest
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
            'stock_transfer_type' => 'required',
            'date' => 'required',
            'source_items' => 'required|array|min:1',
            //'source_items.*.item_code' => 'required',
            //'source_items.*.item_name' => 'required',
            'source_items.*.uom' => 'required',
            'source_items.*.rate' => 'required',
            'source_items.*.quantity' => 'required',
        ];
    }
}
