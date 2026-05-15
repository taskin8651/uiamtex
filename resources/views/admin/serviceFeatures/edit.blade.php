@extends('layouts.admin')
@section('content')

<div class="amtex-page">

    <div class="amtex-header">
        <div>
            <h2 class="amtex-title">Edit Service Feature</h2>
            <p class="amtex-subtitle">Update feature content and ordering.</p>
        </div>
        <div class="amtex-actions">
            <a class="btn btn-light" href="{{ route('admin.service-features.index') }}">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <div class="amtex-card">
        <div class="amtex-card-head">
            <h4 class="mb-0">Edit Feature</h4>
        </div>
        <div class="amtex-card-body">
            <form method="POST" action="{{ route('admin.service-features.update', $serviceFeature->id) }}">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="amtex-label required">Service</label>
                        <select name="service_id" class="form-control {{ $errors->has('service_id') ? 'is-invalid' : '' }}" required>
                            <option value="">Select service</option>
                            @foreach($services as $id => $title)
                                <option value="{{ $id }}" {{ old('service_id', $serviceFeature->service_id) == $id ? 'selected' : '' }}>
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
                               value="{{ old('sort_order', $serviceFeature->sort_order ?? 0) }}">
                        @if($errors->has('sort_order'))
                            <div class="invalid-feedback">{{ $errors->first('sort_order') }}</div>
                        @endif
                    </div>

                    <div class="col-12">
                        <label class="amtex-label required">Feature Text</label>
                        <input type="text" name="feature_text"
                               class="form-control {{ $errors->has('feature_text') ? 'is-invalid' : '' }}"
                               value="{{ old('feature_text', $serviceFeature->feature_text) }}"
                               required>
                        @if($errors->has('feature_text'))
                            <div class="invalid-feedback">{{ $errors->first('feature_text') }}</div>
                        @endif
                    </div>
                </div>

                <div class="mt-4 d-flex gap-2">
                    <button class="btn btn-danger" type="submit">
                        <i class="fas fa-save"></i> Update
                    </button>
                    <a class="btn btn-light" href="{{ route('admin.service-features.index') }}">Cancel</a>
                </div>
            </form>
        </div>
    </div>

</div>

@endsection
