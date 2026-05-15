<?php

namespace App\Http\Requests;

use App\Models\Faq;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateFaqRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('faq_edit');
    }

    public function rules()
    {
        return [
            'select_category_id' => [
                'required',
                'integer',
            ],
            'question' => [
                'required',
            ],
            'answer' => [
                'required',
            ],
            'sort_order' => [
                'string',
                'required',
            ],
        ];
    }
}
