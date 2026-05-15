<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyProductImageRequest;
use App\Http\Requests\StoreProductImageRequest;
use App\Http\Requests\UpdateProductImageRequest;
use App\Models\Product;
use App\Models\ProductImage;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class ProductImagesController extends Controller
{
    use MediaUploadingTrait, CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('product_image_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = ProductImage::with(['select_product'])->select(sprintf('%s.*', (new ProductImage)->table));

            // ✅ Optional filter by product (sent from UI)
            if ($request->filled('amtex_product')) {
                $query->where('select_product_id', $request->amtex_product);
            }

            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'product_image_show';
                $editGate      = 'product_image_edit';
                $deleteGate    = 'product_image_delete';
                $crudRoutePart = 'product-images';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });

            $table->addColumn('select_product_name', function ($row) {
                return $row->select_product ? $row->select_product->name : '';
            });

            $table->editColumn('image', function ($row) {
                if (! $row->image) {
                    return '';
                }
                $links = [];
                foreach ($row->image as $media) {
                    $links[] = '<a href="' . $media->getUrl() . '" target="_blank"><img src="' . $media->getUrl('thumb') . '" width="50px" height="50px"></a>';
                }
                return implode(' ', $links);
            });

            $table->rawColumns(['actions', 'placeholder', 'select_product', 'image']);

            return $table->make(true);
        }

        // ✅ Needed for dropdown filter in premium UI
        $select_products = Product::orderBy('name')->pluck('name', 'id')->prepend('All Products', '');

        return view('admin.productImages.index', compact('select_products'));
    }

    public function create()
    {
        abort_if(Gate::denies('product_image_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $select_products = Product::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.productImages.create', compact('select_products'));
    }

    public function store(StoreProductImageRequest $request)
    {
        $productImage = ProductImage::create($request->all());

        foreach ($request->input('image', []) as $file) {
            $productImage->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $productImage->id]);
        }

        return redirect()->route('admin.product-images.index');
    }

    public function edit(ProductImage $productImage)
    {
        abort_if(Gate::denies('product_image_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $select_products = Product::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $productImage->load('select_product');

        return view('admin.productImages.edit', compact('productImage', 'select_products'));
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

        return redirect()->route('admin.product-images.index');
    }

    public function show(ProductImage $productImage)
    {
        abort_if(Gate::denies('product_image_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $productImage->load('select_product');

        return view('admin.productImages.show', compact('productImage'));
    }

    public function destroy(ProductImage $productImage)
    {
        abort_if(Gate::denies('product_image_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $productImage->delete();

        return back();
    }

    public function massDestroy(MassDestroyProductImageRequest $request)
    {
        $productImages = ProductImage::find(request('ids'));

        foreach ($productImages as $productImage) {
            $productImage->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('product_image_create') && Gate::denies('product_image_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new ProductImage();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
