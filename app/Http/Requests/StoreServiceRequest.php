<?php

namespace App\Http\Requests;

use App\Models\Service;
use Gate;
use Illuminate\Foundation\Http\FormRequest;

class StoreServiceRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('service_create');
    }

    public function rules()
    {
        return [
            'category'           => ['nullable', 'string', 'max:255'],
            'title'              => ['required', 'string', 'max:255'],
            'short_description'  => ['nullable', 'string', 'max:1000'],
            'cta_label'          => ['nullable', 'string', 'max:255'],
            'sort_order'         => ['required', 'integer', 'min:0'],
            'is_active'          => ['required'],
            'features'           => ['array'],
            'features.*.feature_text' => ['nullable', 'string', 'max:255'],
            'features.*.sort_order'   => ['nullable', 'integer', 'min:0'],
        ];
    }
}
