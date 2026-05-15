<?php

namespace App\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateWorkGalleryRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('work_gallery_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'title'      => ['required', 'string', 'max:255'],
            'image'      => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active'  => ['required', 'in:yes,no'],
        ];
    }
}