<?php

namespace App\Http\Requests;

use App\Models\BlogPost;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateBlogPostRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('blog_post_edit');
    }

    public function rules()
    {
        return [
            'select_category_id' => [
                'required',
                'integer',
            ],
            'title' => [
                'string',
                'required',
            ],
            'slug' => [
                'string',
                'required',
            ],
            'excerpt' => [
                'required',
            ],
            'content' => [
                'required',
            ],
            'featured_image' => [
                'required',
            ],
            'read_time' => [
                'string',
                'required',
            ],
            'published_at' => [
                'string',
                'nullable',
            ],
        ];
    }
}
