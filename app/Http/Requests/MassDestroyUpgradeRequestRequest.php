<?php

namespace App\Http\Requests;

use App\Models\UpgradeRequest;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyUpgradeRequestRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('upgrade_request_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:upgrade_requests,id',
        ];
    }
}
