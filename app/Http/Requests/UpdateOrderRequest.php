<?php

namespace App\Http\Requests;

use App\Models\Order;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateOrderRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('order_edit');
    }

    public function rules()
    {
        return [
            'user_id' => [
                'required',
                'integer',
            ],
            'order_no' => [
                'string',
                'required',
            ],
            'subtotal' => [
                'string',
                'required',
            ],
            'shipping' => [
                'string',
                'required',
            ],
            'tax' => [
                'string',
                'required',
            ],
            'total' => [
                'string',
                'required',
            ],
            'payment_status' => [
                'string',
                'nullable',
            ],
            'payment_gateway' => [
                'string',
                'nullable',
            ],
            'txn' => [
                'string',
                'nullable',
            ],
            'address_snapshot' => [
                'string',
                'nullable',
            ],
        ];
    }
}
