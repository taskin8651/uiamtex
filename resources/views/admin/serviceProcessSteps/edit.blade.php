@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <span>{{ trans('global.edit') }} Process Step</span>
        <a class="btn btn-default btn-sm" href="{{ route('admin.service-process-steps.index') }}">
            {{ trans('global.back_to_list') }}
        </a>
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('admin.service-process-steps.update', $serviceProcessStep->id) }}">
            @csrf
            @method('PUT')

            <div class="row g-3">
                <div class="col-md-3">
                    <label class="required">Step No</label>
                    <input type="number" name="step_no" class="form-control {{ $errors->has('step_no') ? 'is-invalid' : '' }}"
                           value="{{ old('step_no', $serviceProcessStep->step_no) }}" required>
                    @if($errors->has('step_no')) <div class="invalid-feedback">{{ $errors->first('step_no') }}</div> @endif
                </div>

                <div class="col-md-6">
                    <label class="required">Title</label>
                    <input type="text" name="title" class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}"
                           value="{{ old('title', $serviceProcessStep->title) }}" required>
                    @if($errors->has('title')) <div class="invalid-feedback">{{ $errors->first('title') }}</div> @endif
                </div>

                <div class="col-md-3">
                    <label class="required">Sort Order</label>
                    <input type="number" name="sort_order" class="form-control {{ $errors->has('sort_order') ? 'is-invalid' : '' }}"
                           value="{{ old('sort_order', $serviceProcessStep->sort_order) }}" required>
                    @if($errors->has('sort_order')) <div class="invalid-feedback">{{ $errors->first('sort_order') }}</div> @endif
                </div>

                <div class="col-md-12">
                    <label>Description</label>
                    <textarea name="description" rows="4" class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}">{{ old('description', $serviceProcessStep->description) }}</textarea>
                    @if($errors->has('description')) <div class="invalid-feedback">{{ $errors->first('description') }}</div> @endif
                </div>

                <div class="col-md-4">
                    <label class="required">Status</label>
                    <select name="is_active" class="form-control {{ $errors->has('is_active') ? 'is-invalid' : '' }}" required>
                        @foreach($isActiveOptions as $key => $label)
                            <option value="{{ $key }}" {{ old('is_active', $serviceProcessStep->is_active) === (string)$key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('is_active')) <div class="invalid-feedback">{{ $errors->first('is_active') }}</div> @endif
                </div>
            </div>

            <div class="mt-4 d-flex gap-2">
                <button class="btn btn-danger" type="submit">{{ trans('global.save') }}</button>
                <a class="btn btn-light" href="{{ route('admin.service-process-steps.index') }}">Cancel</a>
            </div>

        </form>
    </div>
</div>

@endsection
