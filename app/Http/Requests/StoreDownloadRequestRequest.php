<?php

namespace App\Http\Requests;

use App\Models\DownloadRequest;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreDownloadRequestRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('download_request_create');
    }

    public function rules()
    {
        return [
            'download' => [
                'string',
                'nullable',
            ],
            'name' => [
                'string',
                'nullable',
            ],
            'phone' => [
                'string',
                'nullable',
            ],
            'company' => [
                'string',
                'nullable',
            ],
        ];
    }
}
