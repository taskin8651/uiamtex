<?php

namespace App\Http\Requests;

use App\Models\DealershipApplication;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreDealershipApplicationRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('dealership_application_create');
    }

    public function rules()
    {
        return [
            'full_name' => [
                'string',
                'nullable',
            ],
            'mobile' => [
                'string',
                'nullable',
            ],
            'city_state' => [
                'string',
                'nullable',
            ],
            'business_type' => [
                'string',
                'nullable',
            ],
            'sales_focus' => [
                'string',
                'nullable',
            ],
            'experience' => [
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
