<?php

namespace App\Http\Requests;

use App\Models\EndUser;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateEndUserRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('end_user_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
            ],
            'phone' => [
                'string',
                'required',
            ],
            'email' => [
                'required',
            ],
        ];
    }
}
