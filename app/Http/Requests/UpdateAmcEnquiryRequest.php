<?php

namespace App\Http\Requests;

use App\Models\AmcEnquiry;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateAmcEnquiryRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('amc_enquiry_edit');
    }

    public function rules()
    {
        return [
            'user' => [
                'string',
                'nullable',
            ],
            'plan_type' => [
                'string',
                'nullable',
            ],
            'city' => [
                'string',
                'nullable',
            ],
            'site_type' => [
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
