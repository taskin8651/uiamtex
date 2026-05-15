@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.orderItem.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.order-items.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.orderItem.fields.id') }}
                        </th>
                        <td>
                            {{ $orderItem->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.orderItem.fields.order') }}
                        </th>
                        <td>
                            {{ $orderItem->order->order_no ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.orderItem.fields.product') }}
                        </th>
                        <td>
                            {{ $orderItem->product->slug ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.orderItem.fields.variant') }}
                        </th>
                        <td>
                            {{ $orderItem->variant->finish_label ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.orderItem.fields.qty') }}
                        </th>
                        <td>
                            {{ $orderItem->qty }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.orderItem.fields.price') }}
                        </th>
                        <td>
                            {{ $orderItem->price }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.orderItem.fields.meta_snapshot') }}
                        </th>
                        <td>
                            {{ $orderItem->meta_snapshot }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.order-items.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection