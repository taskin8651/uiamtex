<?php

namespace App\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

class StoreServiceEnquiryRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('service_enquiry_create');
    }

    public function rules()
    {
        return [
            'premises_type'    => ['nullable', 'string', 'max:255'],
            'service_required' => ['nullable', 'string', 'max:255'],

            'name'  => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'email' => ['nullable', 'email', 'max:255'],
            'city'  => ['nullable', 'string', 'max:255'],

            'message' => ['nullable', 'string'],

            'status' => ['nullable', 'in:new,contacted,closed'],
        ];
    }
}
