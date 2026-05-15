@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.bulkQuoteRequest.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.bulk-quote-requests.update", [$bulkQuoteRequest->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="product">{{ trans('cruds.bulkQuoteRequest.fields.product') }}</label>
                <input class="form-control {{ $errors->has('product') ? 'is-invalid' : '' }}" type="text" name="product" id="product" value="{{ old('product', $bulkQuoteRequest->product) }}">
                @if($errors->has('product'))
                    <div class="invalid-feedback">
                        {{ $errors->first('product') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.bulkQuoteRequest.fields.product_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="variant">{{ trans('cruds.bulkQuoteRequest.fields.variant') }}</label>
                <input class="form-control {{ $errors->has('variant') ? 'is-invalid' : '' }}" type="text" name="variant" id="variant" value="{{ old('variant', $bulkQuoteRequest->variant) }}">
                @if($errors->has('variant'))
                    <div class="invalid-feedback">
                        {{ $errors->first('variant') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.bulkQuoteRequest.fields.variant_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="qty">{{ trans('cruds.bulkQuoteRequest.fields.qty') }}</label>
                <input class="form-control {{ $errors->has('qty') ? 'is-invalid' : '' }}" type="text" name="qty" id="qty" value="{{ old('qty', $bulkQuoteRequest->qty) }}">
                @if($errors->has('qty'))
                    <div class="invalid-feedback">
                        {{ $errors->first('qty') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.bulkQuoteRequest.fields.qty_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="company_name">{{ trans('cruds.bulkQuoteRequest.fields.company_name') }}</label>
                <input class="form-control {{ $errors->has('company_name') ? 'is-invalid' : '' }}" type="text" name="company_name" id="company_name" value="{{ old('company_name', $bulkQuoteRequest->company_name) }}">
                @if($errors->has('company_name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('company_name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.bulkQuoteRequest.fields.company_name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="city">{{ trans('cruds.bulkQuoteRequest.fields.city') }}</label>
                <input class="form-control {{ $errors->has('city') ? 'is-invalid' : '' }}" type="text" name="city" id="city" value="{{ old('city', $bulkQuoteRequest->city) }}">
                @if($errors->has('city'))
                    <div class="invalid-feedback">
                        {{ $errors->first('city') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.bulkQuoteRequest.fields.city_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="phone">{{ trans('cruds.bulkQuoteRequest.fields.phone') }}</label>
                <input class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" type="text" name="phone" id="phone" value="{{ old('phone', $bulkQuoteRequest->phone) }}">
                @if($errors->has('phone'))
                    <div class="invalid-feedback">
                        {{ $errors->first('phone') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.bulkQuoteRequest.fields.phone_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="email">{{ trans('cruds.bulkQuoteRequest.fields.email') }}</label>
                <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="email" name="email" id="email" value="{{ old('email', $bulkQuoteRequest->email) }}">
                @if($errors->has('email'))
                    <div class="invalid-feedback">
                        {{ $errors->first('email') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.bulkQuoteRequest.fields.email_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="notes">{{ trans('cruds.bulkQuoteRequest.fields.notes') }}</label>
                <textarea class="form-control {{ $errors->has('notes') ? 'is-invalid' : '' }}" name="notes" id="notes">{{ old('notes', $bulkQuoteRequest->notes) }}</textarea>
                @if($errors->has('notes'))
                    <div class="invalid-feedback">
                        {{ $errors->first('notes') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.bulkQuoteRequest.fields.notes_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="status">{{ trans('cruds.bulkQuoteRequest.fields.status') }}</label>
                <input class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" type="text" name="status" id="status" value="{{ old('status', $bulkQuoteRequest->status) }}">
                @if($errors->has('status'))
                    <div class="invalid-feedback">
                        {{ $errors->first('status') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.bulkQuoteRequest.fields.status_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="admin_notes">{{ trans('cruds.bulkQuoteRequest.fields.admin_notes') }}</label>
                <textarea class="form-control {{ $errors->has('admin_notes') ? 'is-invalid' : '' }}" name="admin_notes" id="admin_notes">{{ old('admin_notes', $bulkQuoteRequest->admin_notes) }}</textarea>
                @if($errors->has('admin_notes'))
                    <div class="invalid-feedback">
                        {{ $errors->first('admin_notes') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.bulkQuoteRequest.fields.admin_notes_helper') }}</span>
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