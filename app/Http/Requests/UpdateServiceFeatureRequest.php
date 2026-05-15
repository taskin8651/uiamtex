<?php

namespace App\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

class UpdateServiceFeatureRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('service_feature_edit');
    }

    public function rules()
    {
        return [
            'service_id'    => ['required', 'integer', 'exists:services,id'],
            'feature_text'  => ['required', 'string', 'max:255'],
            'sort_order'    => ['nullable', 'integer', 'min:0'],
        ];
    }
}
