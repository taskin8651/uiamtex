<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreWishlistRequest;
use App\Http\Requests\UpdateWishlistRequest;
use App\Http\Resources\Admin\WishlistResource;
use App\Models\Wishlist;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class WishlistsApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('wishlist_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new WishlistResource(Wishlist::with(['user', 'product'])->get());
    }

    public function store(StoreWishlistRequest $request)
    {
        $wishlist = Wishlist::create($request->all());

        return (new WishlistResource($wishlist))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Wishlist $wishlist)
    {
        abort_if(Gate::denies('wishlist_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new WishlistResource($wishlist->load(['user', 'product']));
    }

    public function update(UpdateWishlistRequest $request, Wishlist $wishlist)
    {
        $wishlist->update($request->all());

        return (new WishlistResource($wishlist))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Wishlist $wishlist)
    {
        abort_if(Gate::denies('wishlist_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $wishlist->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
