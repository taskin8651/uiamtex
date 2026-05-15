<?php

namespace App\Http\Requests;

use App\Models\AmcEnquiry;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyAmcEnquiryRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('amc_enquiry_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:amc_enquiries,id',
        ];
    }
}
