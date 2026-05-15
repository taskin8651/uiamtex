@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.orderItem.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.order-items.update", [$orderItem->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="order_id">{{ trans('cruds.orderItem.fields.order') }}</label>
                <select class="form-control select2 {{ $errors->has('order') ? 'is-invalid' : '' }}" name="order_id" id="order_id" required>
                    @foreach($orders as $id => $entry)
                        <option value="{{ $id }}" {{ (old('order_id') ? old('order_id') : $orderItem->order->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('order'))
                    <div class="invalid-feedback">
                        {{ $errors->first('order') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.orderItem.fields.order_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="product_id">{{ trans('cruds.orderItem.fields.product') }}</label>
                <select class="form-control select2 {{ $errors->has('product') ? 'is-invalid' : '' }}" name="product_id" id="product_id" required>
                    @foreach($products as $id => $entry)
                        <option value="{{ $id }}" {{ (old('product_id') ? old('product_id') : $orderItem->product->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('product'))
                    <div class="invalid-feedback">
                        {{ $errors->first('product') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.orderItem.fields.product_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="variant_id">{{ trans('cruds.orderItem.fields.variant') }}</label>
                <select class="form-control select2 {{ $errors->has('variant') ? 'is-invalid' : '' }}" name="variant_id" id="variant_id" required>
                    @foreach($variants as $id => $entry)
                        <option value="{{ $id }}" {{ (old('variant_id') ? old('variant_id') : $orderItem->variant->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('variant'))
                    <div class="invalid-feedback">
                        {{ $errors->first('variant') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.orderItem.fields.variant_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="qty">{{ trans('cruds.orderItem.fields.qty') }}</label>
                <input class="form-control {{ $errors->has('qty') ? 'is-invalid' : '' }}" type="text" name="qty" id="qty" value="{{ old('qty', $orderItem->qty) }}" required>
                @if($errors->has('qty'))
                    <div class="invalid-feedback">
                        {{ $errors->first('qty') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.orderItem.fields.qty_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="price">{{ trans('cruds.orderItem.fields.price') }}</label>
                <input class="form-control {{ $errors->has('price') ? 'is-invalid' : '' }}" type="text" name="price" id="price" value="{{ old('price', $orderItem->price) }}" required>
                @if($errors->has('price'))
                    <div class="invalid-feedback">
                        {{ $errors->first('price') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.orderItem.fields.price_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="meta_snapshot">{{ trans('cruds.orderItem.fields.meta_snapshot') }}</label>
                <input class="form-control {{ $errors->has('meta_snapshot') ? 'is-invalid' : '' }}" type="text" name="meta_snapshot" id="meta_snapshot" value="{{ old('meta_snapshot', $orderItem->meta_snapshot) }}">
                @if($errors->has('meta_snapshot'))
                    <div class="invalid-feedback">
                        {{ $errors->first('meta_snapshot') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.orderItem.fields.meta_snapshot_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection