<?php

namespace App\Http\Requests;

use App\Models\Wishlist;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreWishlistRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('wishlist_create');
    }

    public function rules()
    {
        return [];
    }
}
