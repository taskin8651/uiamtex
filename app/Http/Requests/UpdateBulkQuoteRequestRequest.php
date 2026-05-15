<?php

namespace App\Http\Requests;

use App\Models\BulkQuoteRequest;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateBulkQuoteRequestRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('bulk_quote_request_edit');
    }

    public function rules()
    {
        return [
            'product' => [
                'string',
                'nullable',
            ],
            'variant' => [
                'string',
                'nullable',
            ],
            'qty' => [
                'string',
                'nullable',
            ],
            'company_name' => [
                'string',
                'nullable',
            ],
            'city' => [
                'string',
                'nullable',
            ],
            'phone' => [
                'string',
                'nullable',
            ],
            'status' => [
                'string',
                'nullable',
            ],
        ];
    }
}
