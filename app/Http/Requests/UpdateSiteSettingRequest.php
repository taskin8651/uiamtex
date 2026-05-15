<?php

namespace App\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSiteSettingRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('site_setting_edit');
    }

    public function rules()
    {
        return [
            'site_name'     => ['required', 'string', 'max:255'],
            'phone'         => ['required', 'string', 'max:50'],
            'email'         => ['required', 'email', 'max:255'],
            'address'       => ['required', 'string'],
            'whatsapp'      => ['nullable', 'string', 'max:50'],
            'footer_about'  => ['required', 'string'],

            // Optional fields (if present in your form)
            'map_embed'     => ['nullable', 'string'],
            'facebook_url'  => ['nullable', 'string', 'max:500'],
            'instagram_url' => ['nullable', 'string', 'max:500'],
            'linkedin'      => ['nullable', 'string', 'max:500'],
            'youtube'       => ['nullable', 'string', 'max:500'],

            // ✅ NEW: Logo & Favicon (optional on update)
            'logo'          => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,svg', 'max:2048'], // 2MB
            'favicon'       => ['nullable', 'mimes:ico,png,svg', 'max:512'], // 512KB
        ];
    }

    public function messages()
    {
        return [
            'email.email'     => 'Please enter a valid email address.',

            'logo.image'      => 'Logo must be an image file.',
            'logo.mimes'      => 'Logo must be a JPG, JPEG, PNG, WEBP, or SVG file.',
            'logo.max'        => 'Logo size must be less than 2MB.',

            'favicon.mimes'   => 'Favicon must be an ICO, PNG, or SVG file.',
            'favicon.max'     => 'Favicon size must be less than 512KB.',
        ];
    }
}
