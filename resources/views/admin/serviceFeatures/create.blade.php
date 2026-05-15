@extends('layouts.admin')
@section('content')

<div class="amtex-page">

    <div class="amtex-header">
        <div>
            <h2 class="amtex-title">Create Service Feature</h2>
            <p class="amtex-subtitle">Add a bullet-point feature under a service.</p>
        </div>
        <div class="amtex-actions">
            <a class="btn btn-light" href="{{ route('admin.service-features.index') }}">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <div class="amtex-card">
        <div class="amtex-card-head">
            <h4 class="mb-0">Feature Details</h4>
        </div>
        <div class="amtex-card-body">
            <form method="POST" action="{{ route('admin.service-features.store') }}">
                @csrf

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="amtex-label required">Service</label>
                        <select name="service_id" class="form-control {{ $errors->has('service_id') ? 'is-invalid' : '' }}" required>
                            <option value="">Select service</option>
                            @foreach($services as $id => $title)
                                <option value="{{ $id }}" {{ old('service_id') == $id ? 'selected' : '' }}>
                                    {{ $title }}
                                </option>
                            @endforeach
                        </select>
                        @if($errors->has('service_id'))
                            <div class="invalid-feedback">{{ $errors->first('service_id') }}</div>
                        @endif
                    </div>

                    <div class="col-md-3">
                        <label class="amtex-label">Sort Order</label>
                        <input type="number" name="sort_order" min="0"
                               class="form-control {{ $errors->has('sort_order') ? 'is-invalid' : '' }}"
                               value="{{ old('sort_order', 0) }}">
                        @if($errors->has('sort_order'))
                            <div class="invalid-feedback">{{ $errors->first('sort_order') }}</div>
                        @endif
                    </div>

                    <div class="col-12">
                        <label class="amtex-label required">Feature Text</label>
                        <input type="text" name="feature_text"
                               class="form-control {{ $errors->has('feature_text') ? 'is-invalid' : '' }}"
                               value="{{ old('feature_text') }}"
                               placeholder="e.g. BIS/ISI compliant supply & installation"
                               required>
                        @if($errors->has('feature_text'))
                            <div class="invalid-feedback">{{ $errors->first('feature_text') }}</div>
                        @endif
                    </div>
                </div>

                <div class="mt-4 d-flex gap-2">
                    <button class="btn btn-danger" type="submit">
                        <i class="fas fa-save"></i> Save
                    </button>
                    <a class="btn btn-light" href="{{ route('admin.service-features.index') }}">Cancel</a>
                </div>
            </form>
        </div>
    </div>

</div>

@endsection
