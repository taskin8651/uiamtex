<?php

namespace App\Http\Requests;

use App\Models\Certification;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreCertificationRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('certification_create');
    }

    public function rules()
    {
        return [
            'title' => [
                'string',
                'required',
            ],
            'image' => [
                'required',
            ],
            'sort_order' => [
                'string',
                'required',
            ],
        ];
    }
}
