<?php

namespace App\Http\Requests;

use App\Models\Certification;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyCertificationRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('certification_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:certifications,id',
        ];
    }
}
