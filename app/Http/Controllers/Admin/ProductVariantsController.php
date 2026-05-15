<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyProductVariantRequest;
use App\Http\Requests\StoreProductVariantRequest;
use App\Http\Requests\UpdateProductVariantRequest;
use App\Models\Product;
use App\Models\ProductVariant;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class ProductVariantsController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('product_variant_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = ProductVariant::with(['select_product'])
                ->select(sprintf('%s.*', (new ProductVariant)->table));

            // ✅ Server-side filters (optional)
            // product filter
            if ($request->filled('amtex_product_id')) {
                $query->where('select_product_id', $request->amtex_product_id);
            }

            // default filter (yes/no)
            if ($request->filled('amtex_default')) {
                $val = strtolower((string) $request->amtex_default);
                if ($val === 'yes' || $val === '1') $query->where('is_default', '1');
                if ($val === 'no'  || $val === '0') $query->where('is_default', '0');
            }

            // stock filter (in/out/low)
            if ($request->filled('amtex_stock')) {
                $stock = strtolower((string) $request->amtex_stock);

                if ($stock === 'in') {
                    $query->where('stock_qty', '>', 0);
                } elseif ($stock === 'out') {
                    $query->where(function($q){
                        $q->whereNull('stock_qty')->orWhere('stock_qty', '<=', 0);
                    });
                } elseif ($stock === 'low') {
                    // low stock threshold (default 10)
                    $threshold = (int) ($request->amtex_low_threshold ?? 10);
                    $query->where('stock_qty', '>', 0)->where('stock_qty', '<=', $threshold);
                }
            }

            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'product_variant_show';
                $editGate      = 'product_variant_edit';
                $deleteGate    = 'product_variant_delete';
                $crudRoutePart = 'product-variants';

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

            $table->editColumn('capacity_label', function ($row) {
                return $row->capacity_label ? $row->capacity_label : '';
            });

            $table->editColumn('finish_label', function ($row) {
                return $row->finish_label ? $row->finish_label : '';
            });

            $table->editColumn('sku', function ($row) {
                return $row->sku ? $row->sku : '';
            });

            $table->editColumn('price', function ($row) {
                return $row->price ? $row->price : '';
            });

            $table->editColumn('compare_price', function ($row) {
                return $row->compare_price ? $row->compare_price : '';
            });

            $table->editColumn('stock_qty', function ($row) {
                return $row->stock_qty !== null ? $row->stock_qty : '';
            });

            $table->editColumn('is_default', function ($row) {
                return $row->is_default ? ProductVariant::IS_DEFAULT_SELECT[$row->is_default] : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'select_product']);

            return $table->make(true);
        }

        // ✅ For filters dropdown
        $select_products = Product::orderBy('name')->pluck('name', 'id')->prepend('All Products', '');

        return view('admin.productVariants.index', compact('select_products'));
    }

    public function create()
    {
        abort_if(Gate::denies('product_variant_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $select_products = Product::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.productVariants.create', compact('select_products'));
    }

    public function store(StoreProductVariantRequest $request)
    {
        $productVariant = ProductVariant::create($request->all());

        return redirect()->route('admin.product-variants.index');
    }

    public function edit(ProductVariant $productVariant)
    {
        abort_if(Gate::denies('product_variant_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $select_products = Product::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $productVariant->load('select_product');

        return view('admin.productVariants.edit', compact('productVariant', 'select_products'));
    }

    public function update(UpdateProductVariantRequest $request, ProductVariant $productVariant)
    {
        $productVariant->update($request->all());

        return redirect()->route('admin.product-variants.index');
    }

    public function show(ProductVariant $productVariant)
    {
        abort_if(Gate::denies('product_variant_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $productVariant->load('select_product');

        return view('admin.productVariants.show', compact('productVariant'));
    }

    public function destroy(ProductVariant $productVariant)
    {
        abort_if(Gate::denies('product_variant_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $productVariant->delete();

        return back();
    }

    public function massDestroy(MassDestroyProductVariantRequest $request)
    {
        $productVariants = ProductVariant::find(request('ids'));

        foreach ($productVariants as $productVariant) {
            $productVariant->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
