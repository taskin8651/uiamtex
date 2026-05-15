<?php

namespace App\Http\Requests;

use App\Models\Address;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateAddressRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('address_edit');
    }

    public function rules()
    {
        return [
            'user_id' => [
                'required',
                'integer',
            ],
            'label' => [
                'string',
                'required',
            ],
            'line_1' => [
                'string',
                'nullable',
            ],
            'line_2' => [
                'string',
                'nullable',
            ],
            'city' => [
                'string',
                'nullable',
            ],
            'state' => [
                'string',
                'nullable',
            ],
            'pincode' => [
                'string',
                'nullable',
            ],
            'country' => [
                'string',
                'nullable',
            ],
        ];
    }
}
