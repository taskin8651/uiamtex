<?php

namespace App\Http\Requests;

use App\Models\BulkQuoteRequest;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyBulkQuoteRequestRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('bulk_quote_request_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:bulk_quote_requests,id',
        ];
    }
}
