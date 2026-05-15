<?php

namespace App\Http\Requests;

use App\Models\Wishlist;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyWishlistRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('wishlist_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:wishlists,id',
        ];
    }
}
