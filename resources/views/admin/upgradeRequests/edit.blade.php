@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.upgradeRequest.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.upgrade-requests.update", [$upgradeRequest->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="user">{{ trans('cruds.upgradeRequest.fields.user') }}</label>
                <input class="form-control {{ $errors->has('user') ? 'is-invalid' : '' }}" type="text" name="user" id="user" value="{{ old('user', $upgradeRequest->user) }}">
                @if($errors->has('user'))
                    <div class="invalid-feedback">
                        {{ $errors->first('user') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.upgradeRequest.fields.user_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="current_extinguisher_type">{{ trans('cruds.upgradeRequest.fields.current_extinguisher_type') }}</label>
                <input class="form-control {{ $errors->has('current_extinguisher_type') ? 'is-invalid' : '' }}" type="text" name="current_extinguisher_type" id="current_extinguisher_type" value="{{ old('current_extinguisher_type', $upgradeRequest->current_extinguisher_type) }}">
                @if($errors->has('current_extinguisher_type'))
                    <div class="invalid-feedback">
                        {{ $errors->first('current_extinguisher_type') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.upgradeRequest.fields.current_extinguisher_type_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="qty">{{ trans('cruds.upgradeRequest.fields.qty') }}</label>
                <input class="form-control {{ $errors->has('qty') ? 'is-invalid' : '' }}" type="text" name="qty" id="qty" value="{{ old('qty', $upgradeRequest->qty) }}">
                @if($errors->has('qty'))
                    <div class="invalid-feedback">
                        {{ $errors->first('qty') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.upgradeRequest.fields.qty_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="city">{{ trans('cruds.upgradeRequest.fields.city') }}</label>
                <input class="form-control {{ $errors->has('city') ? 'is-invalid' : '' }}" type="text" name="city" id="city" value="{{ old('city', $upgradeRequest->city) }}">
                @if($errors->has('city'))
                    <div class="invalid-feedback">
                        {{ $errors->first('city') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.upgradeRequest.fields.city_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="phone">{{ trans('cruds.upgradeRequest.fields.phone') }}</label>
                <input class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" type="text" name="phone" id="phone" value="{{ old('phone', $upgradeRequest->phone) }}">
                @if($errors->has('phone'))
                    <div class="invalid-feedback">
                        {{ $errors->first('phone') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.upgradeRequest.fields.phone_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="email">{{ trans('cruds.upgradeRequest.fields.email') }}</label>
                <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="text" name="email" id="email" value="{{ old('email', $upgradeRequest->email) }}">
                @if($errors->has('email'))
                    <div class="invalid-feedback">
                        {{ $errors->first('email') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.upgradeRequest.fields.email_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="message">{{ trans('cruds.upgradeRequest.fields.message') }}</label>
                <textarea class="form-control {{ $errors->has('message') ? 'is-invalid' : '' }}" name="message" id="message">{{ old('message', $upgradeRequest->message) }}</textarea>
                @if($errors->has('message'))
                    <div class="invalid-feedback">
                        {{ $errors->first('message') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.upgradeRequest.fields.message_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="status">{{ trans('cruds.upgradeRequest.fields.status') }}</label>
                <input class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" type="text" name="status" id="status" value="{{ old('status', $upgradeRequest->status) }}">
                @if($errors->has('status'))
                    <div class="invalid-feedback">
                        {{ $errors->first('status') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.upgradeRequest.fields.status_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="admin_notes">{{ trans('cruds.upgradeRequest.fields.admin_notes') }}</label>
                <textarea class="form-control {{ $errors->has('admin_notes') ? 'is-invalid' : '' }}" name="admin_notes" id="admin_notes">{{ old('admin_notes', $upgradeRequest->admin_notes) }}</textarea>
                @if($errors->has('admin_notes'))
                    <div class="invalid-feedback">
                        {{ $errors->first('admin_notes') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.upgradeRequest.fields.admin_notes_helper') }}</span>
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