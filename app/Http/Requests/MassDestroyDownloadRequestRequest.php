<?php

namespace App\Http\Requests;

use App\Models\DownloadRequest;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyDownloadRequestRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('download_request_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:download_requests,id',
        ];
    }
}
