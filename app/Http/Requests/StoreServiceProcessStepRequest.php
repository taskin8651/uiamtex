<?php

namespace App\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

class StoreServiceProcessStepRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('service_process_step_create');
    }

    public function rules()
    {
        return [
            'step_no'     => ['required', 'integer', 'min:1', 'max:99'],
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'sort_order'  => ['required', 'integer', 'min:0'],
            'is_active'   => ['required'],
        ];
    }
}
