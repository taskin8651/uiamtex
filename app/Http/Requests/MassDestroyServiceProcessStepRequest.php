<?php

namespace App\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

class MassDestroyServiceProcessStepRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('service_process_step_delete');
    }

    public function rules()
    {
        return [
            'ids'   => ['required', 'array'],
            'ids.*' => ['integer'],
        ];
    }
}
