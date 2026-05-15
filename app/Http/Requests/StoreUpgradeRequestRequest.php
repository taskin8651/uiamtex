<?php

namespace App\Http\Requests;

use App\Models\UpgradeRequest;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreUpgradeRequestRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('upgrade_request_create');
    }

    public function rules()
    {
        return [
            'user' => [
                'string',
                'nullable',
            ],
            'current_extinguisher_type' => [
                'string',
                'nullable',
            ],
            'qty' => [
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
            'email' => [
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
