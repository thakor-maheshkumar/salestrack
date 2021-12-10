<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class BatchRequest extends FormRequest
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
        //pred($this->all());
        return [
            'warehouse_id' => 'required|exists:warehouse,id',
            'stock_item_id'=> 'required|exists:stock_items,id'
        ];
    }
}
