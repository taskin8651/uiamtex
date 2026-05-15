@extends('layouts.admin')
@section('content')

<div class="amtex-page">

    <div class="amtex-header">
        <div>
            <h2 class="amtex-title">{{ trans('global.create') }} {{ trans('cruds.industry.title_singular') ?? 'Industry' }}</h2>
            <p class="amtex-subtitle">Create an industry item for the Services page.</p>
        </div>

        <div class="amtex-actions">
            <a class="btn btn-light" href="{{ route('admin.industries.index') }}">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <div class="amtex-card">
        <div class="amtex-card-head">
            <h4 class="mb-0">Industry Details</h4>
        </div>

        <div class="amtex-card-body">
            <form method="POST" action="{{ route('admin.industries.store') }}">
                @csrf

                <div class="row g-3">

                    {{-- Title --}}
                    <div class="col-md-5">
                        <label class="amtex-label required" for="title">Title</label>
                        <input
                            class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}"
                            type="text"
                            name="title"
                            id="title"
                            value="{{ old('title') }}"
                            placeholder="e.g. Apartments, Offices, Retail"
                            required
                        >
                        @if($errors->has('title'))
                            <div class="invalid-feedback">{{ $errors->first('title') }}</div>
                        @endif
                    </div>

                    {{-- Icon --}}
                    <div class="col-md-3">
                        <label class="amtex-label" for="icon">
                            Web Icon (Bootstrap / FontAwesome)
                        </label>
                        <input
                            class="form-control {{ $errors->has('icon') ? 'is-invalid' : '' }}"
                            type="text"
                            name="icon"
                            id="icon"
                            value="{{ old('icon') }}"
                            placeholder="e.g. bi bi-building"
                        >
                        @if($errors->has('icon'))
                            <div class="invalid-feedback">{{ $errors->first('icon') }}</div>
                        @endif
                        <small class="text-muted">
                            Example: <code>bi bi-house-door</code>, <code>fas fa-industry</code>
                        </small>
                    </div>

                    {{-- Sort Order --}}
                    <div class="col-md-2">
                        <label class="amtex-label required" for="sort_order">Sort Order</label>
                        <input
                            class="form-control {{ $errors->has('sort_order') ? 'is-invalid' : '' }}"
                            type="number"
                            name="sort_order"
                            id="sort_order"
                            value="{{ old('sort_order', 0) }}"
                            min="0"
                            required
                        >
                        @if($errors->has('sort_order'))
                            <div class="invalid-feedback">{{ $errors->first('sort_order') }}</div>
                        @endif
                    </div>

                    {{-- Status --}}
                    <div class="col-md-2">
                        <label class="amtex-label" for="is_active">Status</label>
                        <select
                            class="form-control {{ $errors->has('is_active') ? 'is-invalid' : '' }}"
                            name="is_active"
                            id="is_active"
                        >
                            @foreach(\App\Models\Industry::IS_ACTIVE_SELECT as $key => $label)
                                <option value="{{ $key }}" {{ old('is_active', 'yes') === (string)$key ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @if($errors->has('is_active'))
                            <div class="invalid-feedback">{{ $errors->first('is_active') }}</div>
                        @endif
                    </div>

                </div>

                <div class="mt-4 d-flex gap-2">
                    <button class="btn btn-danger" type="submit">
                        <i class="fas fa-save"></i> Save
                    </button>
                    <a class="btn btn-light" href="{{ route('admin.industries.index') }}">Cancel</a>
                </div>

            </form>
        </div>
    </div>

</div>

@endsection
