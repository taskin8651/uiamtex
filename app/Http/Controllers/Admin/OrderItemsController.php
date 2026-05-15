<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyOrderItemRequest;
use App\Http\Requests\StoreOrderItemRequest;
use App\Http\Requests\UpdateOrderItemRequest;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductVariant;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class OrderItemsController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('order_item_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = OrderItem::with(['order', 'product', 'variant'])->select(sprintf('%s.*', (new OrderItem)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'order_item_show';
                $editGate      = 'order_item_edit';
                $deleteGate    = 'order_item_delete';
                $crudRoutePart = 'order-items';

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
            $table->addColumn('order_order_no', function ($row) {
                return $row->order ? $row->order->order_no : '';
            });

            $table->addColumn('product_slug', function ($row) {
                return $row->product ? $row->product->slug : '';
            });

            $table->addColumn('variant_finish_label', function ($row) {
                return $row->variant ? $row->variant->finish_label : '';
            });

            $table->editColumn('qty', function ($row) {
                return $row->qty ? $row->qty : '';
            });
            $table->editColumn('price', function ($row) {
                return $row->price ? $row->price : '';
            });
            $table->editColumn('meta_snapshot', function ($row) {
                return $row->meta_snapshot ? $row->meta_snapshot : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'order', 'product', 'variant']);

            return $table->make(true);
        }

        return view('admin.orderItems.index');
    }

    public function create()
    {
        abort_if(Gate::denies('order_item_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $orders = Order::pluck('order_no', 'id')->prepend(trans('global.pleaseSelect'), '');

        $products = Product::pluck('slug', 'id')->prepend(trans('global.pleaseSelect'), '');

        $variants = ProductVariant::pluck('finish_label', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.orderItems.create', compact('orders', 'products', 'variants'));
    }

    public function store(StoreOrderItemRequest $request)
    {
        $orderItem = OrderItem::create($request->all());

        return redirect()->route('admin.order-items.index');
    }

    public function edit(OrderItem $orderItem)
    {
        abort_if(Gate::denies('order_item_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $orders = Order::pluck('order_no', 'id')->prepend(trans('global.pleaseSelect'), '');

        $products = Product::pluck('slug', 'id')->prepend(trans('global.pleaseSelect'), '');

        $variants = ProductVariant::pluck('finish_label', 'id')->prepend(trans('global.pleaseSelect'), '');

        $orderItem->load('order', 'product', 'variant');

        return view('admin.orderItems.edit', compact('orderItem', 'orders', 'products', 'variants'));
    }

    public function update(UpdateOrderItemRequest $request, OrderItem $orderItem)
    {
        $orderItem->update($request->all());

        return redirect()->route('admin.order-items.index');
    }

    public function show(OrderItem $orderItem)
    {
        abort_if(Gate::denies('order_item_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $orderItem->load('order', 'product', 'variant');

        return view('admin.orderItems.show', compact('orderItem'));
    }

    public function destroy(OrderItem $orderItem)
    {
        abort_if(Gate::denies('order_item_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $orderItem->delete();

        return back();
    }

    public function massDestroy(MassDestroyOrderItemRequest $request)
    {
        $orderItems = OrderItem::find(request('ids'));

        foreach ($orderItems as $orderItem) {
            $orderItem->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
