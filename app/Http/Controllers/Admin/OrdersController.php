<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyOrderRequest;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\EndUser;
use App\Models\Order;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class OrdersController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('order_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Order::with(['user'])->select(sprintf('%s.*', (new Order)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'order_show';
                $editGate      = 'order_edit';
                $deleteGate    = 'order_delete';
                $crudRoutePart = 'orders';

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
            $table->addColumn('user_name', function ($row) {
                return $row->user ? $row->user->name : '';
            });

            $table->editColumn('order_no', function ($row) {
                return $row->order_no ? $row->order_no : '';
            });
            $table->editColumn('status', function ($row) {
                return $row->status ? Order::STATUS_SELECT[$row->status] : '';
            });
            $table->editColumn('subtotal', function ($row) {
                return $row->subtotal ? $row->subtotal : '';
            });
            $table->editColumn('shipping', function ($row) {
                return $row->shipping ? $row->shipping : '';
            });
            $table->editColumn('tax', function ($row) {
                return $row->tax ? $row->tax : '';
            });
            $table->editColumn('total', function ($row) {
                return $row->total ? $row->total : '';
            });
            $table->editColumn('payment_status', function ($row) {
                return $row->payment_status ? $row->payment_status : '';
            });
            $table->editColumn('payment_gateway', function ($row) {
                return $row->payment_gateway ? $row->payment_gateway : '';
            });
            $table->editColumn('txn', function ($row) {
                return $row->txn ? $row->txn : '';
            });
            $table->editColumn('address_snapshot', function ($row) {
                return $row->address_snapshot ? $row->address_snapshot : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'user']);

            return $table->make(true);
        }

        return view('admin.orders.index');
    }

    public function create()
    {
        abort_if(Gate::denies('order_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = EndUser::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.orders.create', compact('users'));
    }

    public function store(StoreOrderRequest $request)
    {
        $order = Order::create($request->all());

        return redirect()->route('admin.orders.index');
    }

    public function edit(Order $order)
    {
        abort_if(Gate::denies('order_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = EndUser::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $order->load('user');

        return view('admin.orders.edit', compact('order', 'users'));
    }

    public function update(UpdateOrderRequest $request, Order $order)
    {
        $order->update($request->all());

        return redirect()->route('admin.orders.index');
    }

    public function show(Order $order)
    {
        abort_if(Gate::denies('order_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $order->load('user');

        return view('admin.orders.show', compact('order'));
    }

    public function destroy(Order $order)
    {
        abort_if(Gate::denies('order_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $order->delete();

        return back();
    }

    public function massDestroy(MassDestroyOrderRequest $request)
    {
        $orders = Order::find(request('ids'));

        foreach ($orders as $order) {
            $order->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
