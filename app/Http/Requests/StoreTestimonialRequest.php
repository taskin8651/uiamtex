<?php

namespace App\Http\Requests;

use App\Models\Testimonial;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreTestimonialRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('testimonial_create');
    }

    public function rules()
    {
        return [
            'name' => ['required','string','max:255'],
            'company_designation' => ['nullable','string','max:255'],
            'review' => ['required','string'],
            'sort_order' => ['nullable','integer'],
            'is_active' => ['required','in:yes,no'],
            'photo' => ['nullable','string'], // dropzone sends file name
        ];
    }
}
