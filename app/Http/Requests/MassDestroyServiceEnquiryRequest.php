<?php

namespace App\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

class MassDestroyServiceEnquiryRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('service_enquiry_delete');
    }

    public function rules()
    {
        return [
            'ids'   => ['required', 'array'],
            'ids.*' => ['integer'],
        ];
    }
}
