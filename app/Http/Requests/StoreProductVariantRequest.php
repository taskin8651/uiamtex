<?php

namespace App\Http\Requests;

use App\Models\ProductVariant;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreProductVariantRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('product_variant_create');
    }

    public function rules()
    {
        return [
            'select_product_id' => [
                'required',
                'integer',
            ],
            'capacity_label' => [
                'string',
                'required',
            ],
            'finish_label' => [
                'string',
                'required',
            ],
            'sku' => [
                'string',
                'required',
            ],
            'price' => [
                'string',
                'required',
            ],
            'compare_price' => [
                'string',
                'required',
            ],
            'stock_qty' => [
                'string',
                'required',
            ],
            'is_default' => [
                'required',
            ],
        ];
    }
}
