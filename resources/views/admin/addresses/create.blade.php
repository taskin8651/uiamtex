@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.address.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.addresses.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="user_id">{{ trans('cruds.address.fields.user') }}</label>
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
                <span class="help-block">{{ trans('cruds.address.fields.user_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="label">{{ trans('cruds.address.fields.label') }}</label>
                <input class="form-control {{ $errors->has('label') ? 'is-invalid' : '' }}" type="text" name="label" id="label" value="{{ old('label', '') }}" required>
                @if($errors->has('label'))
                    <div class="invalid-feedback">
                        {{ $errors->first('label') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.address.fields.label_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="line_1">{{ trans('cruds.address.fields.line_1') }}</label>
                <input class="form-control {{ $errors->has('line_1') ? 'is-invalid' : '' }}" type="text" name="line_1" id="line_1" value="{{ old('line_1', '') }}">
                @if($errors->has('line_1'))
                    <div class="invalid-feedback">
                        {{ $errors->first('line_1') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.address.fields.line_1_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="line_2">{{ trans('cruds.address.fields.line_2') }}</label>
                <input class="form-control {{ $errors->has('line_2') ? 'is-invalid' : '' }}" type="text" name="line_2" id="line_2" value="{{ old('line_2', '') }}">
                @if($errors->has('line_2'))
                    <div class="invalid-feedback">
                        {{ $errors->first('line_2') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.address.fields.line_2_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="city">{{ trans('cruds.address.fields.city') }}</label>
                <input class="form-control {{ $errors->has('city') ? 'is-invalid' : '' }}" type="text" name="city" id="city" value="{{ old('city', '') }}">
                @if($errors->has('city'))
                    <div class="invalid-feedback">
                        {{ $errors->first('city') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.address.fields.city_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="state">{{ trans('cruds.address.fields.state') }}</label>
                <input class="form-control {{ $errors->has('state') ? 'is-invalid' : '' }}" type="text" name="state" id="state" value="{{ old('state', '') }}">
                @if($errors->has('state'))
                    <div class="invalid-feedback">
                        {{ $errors->first('state') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.address.fields.state_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="pincode">{{ trans('cruds.address.fields.pincode') }}</label>
                <input class="form-control {{ $errors->has('pincode') ? 'is-invalid' : '' }}" type="text" name="pincode" id="pincode" value="{{ old('pincode', '') }}">
                @if($errors->has('pincode'))
                    <div class="invalid-feedback">
                        {{ $errors->first('pincode') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.address.fields.pincode_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="country">{{ trans('cruds.address.fields.country') }}</label>
                <input class="form-control {{ $errors->has('country') ? 'is-invalid' : '' }}" type="text" name="country" id="country" value="{{ old('country', '') }}">
                @if($errors->has('country'))
                    <div class="invalid-feedback">
                        {{ $errors->first('country') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.address.fields.country_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.address.fields.is_default') }}</label>
                <select class="form-control {{ $errors->has('is_default') ? 'is-invalid' : '' }}" name="is_default" id="is_default">
                    <option value disabled {{ old('is_default', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Address::IS_DEFAULT_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('is_default', 'yes') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('is_default'))
                    <div class="invalid-feedback">
                        {{ $errors->first('is_default') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.address.fields.is_default_helper') }}</span>
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