<?php

namespace App\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

class MassDestroyServiceFeatureRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('service_feature_delete');
    }

    public function rules()
    {
        return [
            'ids'   => ['required', 'array'],
            'ids.*' => ['integer'],
        ];
    }
}
