<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Gate;

class MassDestroyWorkGalleryRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('work_gallery_delete');
    }

    public function rules()
    {
        return [
            'ids'   => ['required', 'array'],
            'ids.*' => ['integer'],
        ];
    }
}
