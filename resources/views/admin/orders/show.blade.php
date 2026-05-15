@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.order.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.orders.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.order.fields.id') }}
                        </th>
                        <td>
                            {{ $order->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.order.fields.user') }}
                        </th>
                        <td>
                            {{ $order->user->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.order.fields.order_no') }}
                        </th>
                        <td>
                            {{ $order->order_no }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.order.fields.status') }}
                        </th>
                        <td>
                            {{ App\Models\Order::STATUS_SELECT[$order->status] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.order.fields.subtotal') }}
                        </th>
                        <td>
                            {{ $order->subtotal }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.order.fields.shipping') }}
                        </th>
                        <td>
                            {{ $order->shipping }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.order.fields.tax') }}
                        </th>
                        <td>
                            {{ $order->tax }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.order.fields.total') }}
                        </th>
                        <td>
                            {{ $order->total }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.order.fields.payment_status') }}
                        </th>
                        <td>
                            {{ $order->payment_status }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.order.fields.payment_gateway') }}
                        </th>
                        <td>
                            {{ $order->payment_gateway }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.order.fields.txn') }}
                        </th>
                        <td>
                            {{ $order->txn }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.order.fields.address_snapshot') }}
                        </th>
                        <td>
                            {{ $order->address_snapshot }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.orders.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection