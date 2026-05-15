<?php

namespace App\Http\Requests;

use App\Models\EndUser;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyEndUserRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('end_user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:end_users,id',
        ];
    }
}
