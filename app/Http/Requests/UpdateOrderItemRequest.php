<?php

namespace App\Http\Requests;

use App\Models\OrderItem;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateOrderItemRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('order_item_edit');
    }

    public function rules()
    {
        return [
            'order_id' => [
                'required',
                'integer',
            ],
            'product_id' => [
                'required',
                'integer',
            ],
            'variant_id' => [
                'required',
                'integer',
            ],
            'qty' => [
                'string',
                'required',
            ],
            'price' => [
                'string',
                'required',
            ],
            'meta_snapshot' => [
                'string',
                'nullable',
            ],
        ];
    }
}
