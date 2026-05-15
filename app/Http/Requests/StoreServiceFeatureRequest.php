<?php

namespace App\Http\Requests;

use App\Models\ServiceFeature;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreServiceFeatureRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('service_feature_create');
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
