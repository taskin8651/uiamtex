<?php

namespace App\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

class MassDestroyTestimonialRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('testimonial_delete');
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'integer',
        ];
    }
}
