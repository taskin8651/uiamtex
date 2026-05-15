<?php

namespace App\Http\Requests;

use App\Models\Page;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StorePageRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('page_create');
    }

    public function rules()
    {
        return [
            'title' => [
                'string',
                'required',
            ],
            'slug' => [
                'string',
                'required',
            ],
            'content' => [
                'required',
            ],
            'seo_title' => [
                'string',
                'required',
            ],
            'is_active' => [
                'required',
            ],
            'show_in_navbar' => ['nullable', 'boolean'],
            'show_in_footer' => ['nullable', 'boolean'],
            'show_in_footer_bottom' => ['nullable', 'boolean'],

        ];
    }
}
