<?php

namespace App\Http\Requests;

use App\Models\Download;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreDownloadRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('download_create');
    }

    public function rules()
    {
        return [
            'title' => [
                'string',
                'required',
            ],
            'file' => [
                'required',
            ],
            'description' => [
                'required',
            ],
        ];
    }
}
