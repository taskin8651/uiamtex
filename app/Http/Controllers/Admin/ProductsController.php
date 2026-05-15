<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyProductRequest;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class ProductsController extends Controller
{
    use MediaUploadingTrait, CsvImportTrait;

    /**
     * Normalize PDP builder inputs from the create/edit form and
     * convert repeater arrays into JSON strings (DB friendly).
     *
     * IMPORTANT:
     * - StoreProductRequest / UpdateProductRequest should decode JSON strings
     *   into arrays BEFORE validation (prepareForValidation), because rules
     *   often require array.
     * - This controller assumes that after validation passes, these fields
     *   will be arrays (not JSON strings):
     *     pdp_recommended_for_left, pdp_recommended_for_right, pdp_tech_table
     *
     * NOTE: This assumes your `products` table has these columns:
     * - pdp_tags (text/json)
     * - pdp_pointers (text/json)
     * - pdp_key_highlights (text/json)
     * - pdp_works_on (text/json)
     * - pdp_recommended_for_left (text/json)
     * - pdp_recommended_for_right (text/json)
     * - pdp_tech_table (text/json)
     * - pdp_available_sizes (string/text)
     * - pdp_available_variants (string/text)
     */
    protected function preparePdpPayload(Request $request): array
    {
        $data = $request->all();

        // -----------------------------
        // Tags (array -> json)
        // -----------------------------
        if ($request->has('pdp_tags')) {
            $tags = Arr::wrap($request->input('pdp_tags', []));
            $tags = array_values(array_filter(array_map(fn ($t) => trim((string) $t), $tags)));
            $data['pdp_tags'] = $tags ? json_encode($tags, JSON_UNESCAPED_UNICODE) : null;
        }

        // -----------------------------
        // Pointers (array -> json)
        // -----------------------------
        if ($request->has('pdp_pointers')) {
            $pointers = Arr::wrap($request->input('pdp_pointers', []));
            $pointers = array_values(array_filter(array_map(fn ($t) => trim((string) $t), $pointers)));
            $data['pdp_pointers'] = $pointers ? json_encode($pointers, JSON_UNESCAPED_UNICODE) : null;
        }

        // -----------------------------
        // Key highlights (array of rows -> json)
        // -----------------------------
        if ($request->has('pdp_key_highlights')) {
            $rows = Arr::wrap($request->input('pdp_key_highlights', []));
            $rows = array_values(array_filter(array_map(function ($r) {
                $icon  = trim((string) data_get($r, 'icon', ''));
                $title = trim((string) data_get($r, 'title', ''));
                $text  = trim((string) data_get($r, 'text', ''));

                // drop empty row
                if ($icon === '' && $title === '' && $text === '') {
                    return null;
                }

                return [
                    'icon'  => $icon,
                    'title' => $title,
                    'text'  => $text,
                ];
            }, $rows)));
            $rows = array_values(array_filter($rows));
            $data['pdp_key_highlights'] = $rows ? json_encode($rows, JSON_UNESCAPED_UNICODE) : null;
        }

        // -----------------------------
        // Works on (array of rows -> json)
        // -----------------------------
        if ($request->has('pdp_works_on')) {
            $rows = Arr::wrap($request->input('pdp_works_on', []));
            $rows = array_values(array_filter(array_map(function ($r) {
                $icon  = trim((string) data_get($r, 'icon', ''));
                $title = trim((string) data_get($r, 'title', ''));
                $text  = trim((string) data_get($r, 'text', ''));

                if ($icon === '' && $title === '' && $text === '') {
                    return null;
                }

                return [
                    'icon'  => $icon,
                    'title' => $title,
                    'text'  => $text,
                ];
            }, $rows)));
            $rows = array_values(array_filter($rows));
            $data['pdp_works_on'] = $rows ? json_encode($rows, JSON_UNESCAPED_UNICODE) : null;
        }

        // -----------------------------
        // Recommended for (array -> json)
        // (After FormRequest prepareForValidation, these should be arrays)
        // -----------------------------
        if ($request->has('pdp_recommended_for_left')) {
            $left = Arr::wrap($request->input('pdp_recommended_for_left', []));
            $left = array_values(array_filter(array_map(fn ($t) => trim((string) $t), $left)));
            $data['pdp_recommended_for_left'] = $left ? json_encode($left, JSON_UNESCAPED_UNICODE) : null;
        }

        if ($request->has('pdp_recommended_for_right')) {
            $right = Arr::wrap($request->input('pdp_recommended_for_right', []));
            $right = array_values(array_filter(array_map(fn ($t) => trim((string) $t), $right)));
            $data['pdp_recommended_for_right'] = $right ? json_encode($right, JSON_UNESCAPED_UNICODE) : null;
        }

        // -----------------------------
        // Tech table (array/object -> json)
        // -----------------------------
        if ($request->has('pdp_tech_table')) {
            $tech = $request->input('pdp_tech_table', []);
            $data['pdp_tech_table'] = !empty($tech) ? json_encode($tech, JSON_UNESCAPED_UNICODE) : null;
        }

        // Cleanup raw helper textarea fields (not meant for DB)
        unset($data['amtex_reco_left_raw'], $data['amtex_reco_right_raw']);

        return $data;
    }

    public function index(Request $request)
    {
        abort_if(Gate::denies('product_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Product::with(['select_category'])
                ->select(sprintf('%s.*', (new Product)->table));

            /**
             * ✅ Server-side filters
             * amtex_active: yes/no
             * amtex_featured: yes/no
             */
            if ($request->filled('amtex_active')) {
                if ($request->amtex_active === 'yes') {
                    $query->where('is_active', 1);
                } elseif ($request->amtex_active === 'no') {
                    $query->where('is_active', 0);
                }
            }

            if ($request->filled('amtex_featured')) {
                if ($request->amtex_featured === 'yes') {
                    $query->where('is_featured', 1);
                } elseif ($request->amtex_featured === 'no') {
                    $query->where('is_featured', 0);
                }
            }

            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'product_show';
                $editGate      = 'product_edit';
                $deleteGate    = 'product_delete';
                $crudRoutePart = 'products';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', fn ($row) => $row->id ?? '');

            $table->addColumn('select_category_name', function ($row) {
                return $row->select_category ? $row->select_category->name : '';
            });

            $table->editColumn('name', fn ($row) => $row->name ?? '');
            $table->editColumn('slug', fn ($row) => $row->slug ?? '');
            $table->editColumn('base_price', fn ($row) => $row->base_price ?? '');
            $table->editColumn('compare_price', fn ($row) => $row->compare_price ?? '');
            $table->editColumn('badge', fn ($row) => $row->badge ? Product::BADGE_SELECT[$row->badge] : '');
            $table->editColumn('dispatch_text', fn ($row) => $row->dispatch_text ?? '');
            $table->editColumn('rating_avg', fn ($row) => $row->rating_avg ?? '');
            $table->editColumn('rating_count', fn ($row) => $row->rating_count ?? '');
            $table->editColumn('sku', fn ($row) => $row->sku ?? '');
            $table->editColumn('is_featured', fn ($row) => $row->is_featured ? Product::IS_FEATURED_SELECT[$row->is_featured] : '');
            $table->editColumn('is_active', fn ($row) => $row->is_active ? Product::IS_ACTIVE_SELECT[$row->is_active] : '');

            $table->editColumn('main_image', function ($row) {
                if ($photo = $row->main_image) {
                    return sprintf(
                        '<a href="%s" target="_blank"><img src="%s" width="50px" height="50px"></a>',
                        $photo->url,
                        $photo->thumbnail
                    );
                }
                return '';
            });

            $table->editColumn('brochure_pdf', function ($row) {
                return $row->brochure_pdf
                    ? '<a href="' . $row->brochure_pdf->getUrl() . '" target="_blank">' . trans('global.downloadFile') . '</a>'
                    : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'main_image', 'brochure_pdf']);

            return $table->make(true);
        }

        return view('admin.products.index');
    }

    public function create()
    {
        abort_if(Gate::denies('product_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $select_categories = Category::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.products.create', compact('select_categories'));
    }

    public function store(StoreProductRequest $request)
    {
        // Merge PDP builder payload (JSON conversions etc.)
        $payload = $this->preparePdpPayload($request);

        $product = Product::create($payload);

        if ($request->input('main_image', false)) {
            $product->addMedia(storage_path('tmp/uploads/' . basename($request->input('main_image'))))
                ->toMediaCollection('main_image');
        }

        if ($request->input('brochure_pdf', false)) {
            $product->addMedia(storage_path('tmp/uploads/' . basename($request->input('brochure_pdf'))))
                ->toMediaCollection('brochure_pdf');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $product->id]);
        }

        return redirect()->route('admin.products.index');
    }

    public function edit(Product $product)
    {
        abort_if(Gate::denies('product_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $select_categories = Category::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $product->load('select_category');

        return view('admin.products.edit', compact('product', 'select_categories'));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        // Merge PDP builder payload (JSON conversions etc.)
        $payload = $this->preparePdpPayload($request);

        $product->update($payload);

        if ($request->input('main_image', false)) {
            if (! $product->main_image || $request->input('main_image') !== $product->main_image->file_name) {
                if ($product->main_image) {
                    $product->main_image->delete();
                }
                $product->addMedia(storage_path('tmp/uploads/' . basename($request->input('main_image'))))
                    ->toMediaCollection('main_image');
            }
        } elseif ($product->main_image) {
            $product->main_image->delete();
        }

        if ($request->input('brochure_pdf', false)) {
            if (! $product->brochure_pdf || $request->input('brochure_pdf') !== $product->brochure_pdf->file_name) {
                if ($product->brochure_pdf) {
                    $product->brochure_pdf->delete();
                }
                $product->addMedia(storage_path('tmp/uploads/' . basename($request->input('brochure_pdf'))))
                    ->toMediaCollection('brochure_pdf');
            }
        } elseif ($product->brochure_pdf) {
            $product->brochure_pdf->delete();
        }

        return redirect()->route('admin.products.index');
    }

    public function show(Product $product)
    {
        abort_if(Gate::denies('product_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $product->load('select_category');

        return view('admin.products.show', compact('product'));
    }

    public function destroy(Product $product)
    {
        abort_if(Gate::denies('product_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $product->delete();

        return back();
    }

    public function massDestroy(MassDestroyProductRequest $request)
    {
        $products = Product::find(request('ids'));

        foreach ($products as $product) {
            $product->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('product_create') && Gate::denies('product_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Product();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;

        $media = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}