<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreProductImageRequest;
use App\Http\Requests\UpdateProductImageRequest;
use App\Http\Resources\Admin\ProductImageResource;
use App\Models\ProductImage;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductImagesApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('product_image_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ProductImageResource(ProductImage::with(['select_product'])->get());
    }

    public function store(StoreProductImageRequest $request)
    {
        $productImage = ProductImage::create($request->all());

        foreach ($request->input('image', []) as $file) {
            $productImage->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
        }

        return (new ProductImageResource($productImage))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(ProductImage $productImage)
    {
        abort_if(Gate::denies('product_image_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ProductImageResource($productImage->load(['select_product']));
    }

    public function update(UpdateProductImageRequest $request, ProductImage $productImage)
    {
        $productImage->update($request->all());

        if (count($productImage->image) > 0) {
            foreach ($productImage->image as $media) {
                if (! in_array($media->file_name, $request->input('image', []))) {
                    $media->delete();
                }
            }
        }
        $media = $productImage->image->pluck('file_name')->toArray();
        foreach ($request->input('image', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $productImage->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
            }
        }

        return (new ProductImageResource($productImage))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(ProductImage $productImage)
    {
        abort_if(Gate::denies('product_image_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $productImage->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
