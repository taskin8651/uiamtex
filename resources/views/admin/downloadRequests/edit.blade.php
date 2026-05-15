@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.downloadRequest.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.download-requests.update", [$downloadRequest->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="download">{{ trans('cruds.downloadRequest.fields.download') }}</label>
                <input class="form-control {{ $errors->has('download') ? 'is-invalid' : '' }}" type="text" name="download" id="download" value="{{ old('download', $downloadRequest->download) }}">
                @if($errors->has('download'))
                    <div class="invalid-feedback">
                        {{ $errors->first('download') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.downloadRequest.fields.download_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="name">{{ trans('cruds.downloadRequest.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $downloadRequest->name) }}">
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.downloadRequest.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="phone">{{ trans('cruds.downloadRequest.fields.phone') }}</label>
                <input class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" type="text" name="phone" id="phone" value="{{ old('phone', $downloadRequest->phone) }}">
                @if($errors->has('phone'))
                    <div class="invalid-feedback">
                        {{ $errors->first('phone') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.downloadRequest.fields.phone_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="email">{{ trans('cruds.downloadRequest.fields.email') }}</label>
                <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="email" name="email" id="email" value="{{ old('email', $downloadRequest->email) }}">
                @if($errors->has('email'))
                    <div class="invalid-feedback">
                        {{ $errors->first('email') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.downloadRequest.fields.email_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="company">{{ trans('cruds.downloadRequest.fields.company') }}</label>
                <input class="form-control {{ $errors->has('company') ? 'is-invalid' : '' }}" type="text" name="company" id="company" value="{{ old('company', $downloadRequest->company) }}">
                @if($errors->has('company'))
                    <div class="invalid-feedback">
                        {{ $errors->first('company') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.downloadRequest.fields.company_helper') }}</span>
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