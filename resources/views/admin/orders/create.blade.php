@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.order.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.orders.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="user_id">{{ trans('cruds.order.fields.user') }}</label>
                <select class="form-control select2 {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id" required>
                    @foreach($users as $id => $entry)
                        <option value="{{ $id }}" {{ old('user_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('user'))
                    <div class="invalid-feedback">
                        {{ $errors->first('user') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.order.fields.user_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="order_no">{{ trans('cruds.order.fields.order_no') }}</label>
                <input class="form-control {{ $errors->has('order_no') ? 'is-invalid' : '' }}" type="text" name="order_no" id="order_no" value="{{ old('order_no', '') }}" required>
                @if($errors->has('order_no'))
                    <div class="invalid-feedback">
                        {{ $errors->first('order_no') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.order.fields.order_no_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.order.fields.status') }}</label>
                <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="status">
                    <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Order::STATUS_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('status', 'processing') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('status'))
                    <div class="invalid-feedback">
                        {{ $errors->first('status') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.order.fields.status_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="subtotal">{{ trans('cruds.order.fields.subtotal') }}</label>
                <input class="form-control {{ $errors->has('subtotal') ? 'is-invalid' : '' }}" type="text" name="subtotal" id="subtotal" value="{{ old('subtotal', '') }}" required>
                @if($errors->has('subtotal'))
                    <div class="invalid-feedback">
                        {{ $errors->first('subtotal') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.order.fields.subtotal_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="shipping">{{ trans('cruds.order.fields.shipping') }}</label>
                <input class="form-control {{ $errors->has('shipping') ? 'is-invalid' : '' }}" type="text" name="shipping" id="shipping" value="{{ old('shipping', '') }}" required>
                @if($errors->has('shipping'))
                    <div class="invalid-feedback">
                        {{ $errors->first('shipping') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.order.fields.shipping_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="tax">{{ trans('cruds.order.fields.tax') }}</label>
                <input class="form-control {{ $errors->has('tax') ? 'is-invalid' : '' }}" type="text" name="tax" id="tax" value="{{ old('tax', '') }}" required>
                @if($errors->has('tax'))
                    <div class="invalid-feedback">
                        {{ $errors->first('tax') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.order.fields.tax_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="total">{{ trans('cruds.order.fields.total') }}</label>
                <input class="form-control {{ $errors->has('total') ? 'is-invalid' : '' }}" type="text" name="total" id="total" value="{{ old('total', '') }}" required>
                @if($errors->has('total'))
                    <div class="invalid-feedback">
                        {{ $errors->first('total') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.order.fields.total_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="payment_status">{{ trans('cruds.order.fields.payment_status') }}</label>
                <input class="form-control {{ $errors->has('payment_status') ? 'is-invalid' : '' }}" type="text" name="payment_status" id="payment_status" value="{{ old('payment_status', '') }}">
                @if($errors->has('payment_status'))
                    <div class="invalid-feedback">
                        {{ $errors->first('payment_status') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.order.fields.payment_status_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="payment_gateway">{{ trans('cruds.order.fields.payment_gateway') }}</label>
                <input class="form-control {{ $errors->has('payment_gateway') ? 'is-invalid' : '' }}" type="text" name="payment_gateway" id="payment_gateway" value="{{ old('payment_gateway', '') }}">
                @if($errors->has('payment_gateway'))
                    <div class="invalid-feedback">
                        {{ $errors->first('payment_gateway') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.order.fields.payment_gateway_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="txn">{{ trans('cruds.order.fields.txn') }}</label>
                <input class="form-control {{ $errors->has('txn') ? 'is-invalid' : '' }}" type="text" name="txn" id="txn" value="{{ old('txn', '') }}">
                @if($errors->has('txn'))
                    <div class="invalid-feedback">
                        {{ $errors->first('txn') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.order.fields.txn_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="address_snapshot">{{ trans('cruds.order.fields.address_snapshot') }}</label>
                <input class="form-control {{ $errors->has('address_snapshot') ? 'is-invalid' : '' }}" type="text" name="address_snapshot" id="address_snapshot" value="{{ old('address_snapshot', '') }}">
                @if($errors->has('address_snapshot'))
                    <div class="invalid-feedback">
                        {{ $errors->first('address_snapshot') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.order.fields.address_snapshot_helper') }}</span>
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