<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\Admin\ProductResource;
use App\Models\Product;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductsApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('product_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ProductResource(Product::with(['select_category'])->get());
    }

    public function store(StoreProductRequest $request)
    {
        $product = Product::create($request->all());

        if ($request->input('main_image', false)) {
            $product->addMedia(storage_path('tmp/uploads/' . basename($request->input('main_image'))))->toMediaCollection('main_image');
        }

        if ($request->input('brochure_pdf', false)) {
            $product->addMedia(storage_path('tmp/uploads/' . basename($request->input('brochure_pdf'))))->toMediaCollection('brochure_pdf');
        }

        return (new ProductResource($product))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Product $product)
    {
        abort_if(Gate::denies('product_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ProductResource($product->load(['select_category']));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->update($request->all());

        if ($request->input('main_image', false)) {
            if (! $product->main_image || $request->input('main_image') !== $product->main_image->file_name) {
                if ($product->main_image) {
                    $product->main_image->delete();
                }
                $product->addMedia(storage_path('tmp/uploads/' . basename($request->input('main_image'))))->toMediaCollection('main_image');
            }
        } elseif ($product->main_image) {
            $product->main_image->delete();
        }

        if ($request->input('brochure_pdf', false)) {
            if (! $product->brochure_pdf || $request->input('brochure_pdf') !== $product->brochure_pdf->file_name) {
                if ($product->brochure_pdf) {
                    $product->brochure_pdf->delete();
                }
                $product->addMedia(storage_path('tmp/uploads/' . basename($request->input('brochure_pdf'))))->toMediaCollection('brochure_pdf');
            }
        } elseif ($product->brochure_pdf) {
            $product->brochure_pdf->delete();
        }

        return (new ProductResource($product))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Product $product)
    {
        abort_if(Gate::denies('product_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $product->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
