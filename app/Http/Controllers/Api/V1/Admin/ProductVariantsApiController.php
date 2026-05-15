<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductVariantRequest;
use App\Http\Requests\UpdateProductVariantRequest;
use App\Http\Resources\Admin\ProductVariantResource;
use App\Models\ProductVariant;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductVariantsApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('product_variant_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ProductVariantResource(ProductVariant::with(['select_product'])->get());
    }

    public function store(StoreProductVariantRequest $request)
    {
        $productVariant = ProductVariant::create($request->all());

        return (new ProductVariantResource($productVariant))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(ProductVariant $productVariant)
    {
        abort_if(Gate::denies('product_variant_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ProductVariantResource($productVariant->load(['select_product']));
    }

    public function update(UpdateProductVariantRequest $request, ProductVariant $productVariant)
    {
        $productVariant->update($request->all());

        return (new ProductVariantResource($productVariant))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(ProductVariant $productVariant)
    {
        abort_if(Gate::denies('product_variant_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $productVariant->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
