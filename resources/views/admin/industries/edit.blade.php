@extends('layouts.admin')
@section('content')

<div class="amtex-page">

    <div class="amtex-header">
        <div>
            <h2 class="amtex-title">{{ trans('global.edit') }} {{ trans('cruds.industry.title_singular') ?? 'Industry' }}</h2>
            <p class="amtex-subtitle">Update industry details and visibility.</p>
        </div>

        <div class="amtex-actions">
            <a class="btn btn-light" href="{{ route('admin.industries.index') }}">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <div class="amtex-card">
        <div class="amtex-card-head">
            <h4 class="mb-0">Edit Industry</h4>
        </div>

        <div class="amtex-card-body">
            <form method="POST" action="{{ route('admin.industries.update', $industry->id) }}">
                @csrf
                @method('PUT')

                <div class="row g-3">

                    {{-- Title --}}
                    <div class="col-md-6">
                        <label class="amtex-label required" for="title">Title</label>
                        <input
                            class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}"
                            type="text"
                            name="title"
                            id="title"
                            value="{{ old('title', $industry->title) }}"
                            placeholder="e.g. Apartments & Homes"
                            required
                        >
                        @if($errors->has('title'))
                            <div class="invalid-feedback">{{ $errors->first('title') }}</div>
                        @endif
                    </div>

                    {{-- Icon --}}
                    <div class="col-md-6">
                        <label class="amtex-label" for="icon">Web Icon (Bootstrap icon class)</label>
                        <input
                            class="form-control {{ $errors->has('icon') ? 'is-invalid' : '' }}"
                            type="text"
                            name="icon"
                            id="icon"
                            value="{{ old('icon', $industry->icon ?? '') }}"
                            placeholder="e.g. bi bi-house-door"
                        >
                        @if($errors->has('icon'))
                            <div class="invalid-feedback">{{ $errors->first('icon') }}</div>
                        @endif

                        <small class="text-muted d-block mt-1">
                            Example: <code>bi bi-house-door</code>, <code>bi bi-building</code>, <code>bi bi-bag</code>
                        </small>

                        {{-- Live preview (optional) --}}
                        <div class="mt-2 d-flex align-items-center gap-2">
                            <span class="text-muted small">Preview:</span>
                            <span id="iconPreview" class="d-inline-flex align-items-center justify-content-center" style="width:34px;height:34px;border:1px solid #e5e7eb;border-radius:10px;">
                                <i class="{{ old('icon', $industry->icon ?? 'bi bi-grid') }}"></i>
                            </span>
                            <span class="small text-muted" id="iconPreviewText">{{ old('icon', $industry->icon ?? 'bi bi-grid') }}</span>
                        </div>
                    </div>

                    {{-- Sort Order --}}
                    <div class="col-md-3">
                        <label class="amtex-label required" for="sort_order">Sort Order</label>
                        <input
                            class="form-control {{ $errors->has('sort_order') ? 'is-invalid' : '' }}"
                            type="number"
                            name="sort_order"
                            id="sort_order"
                            value="{{ old('sort_order', $industry->sort_order ?? 0) }}"
                            min="0"
                            required
                        >
                        @if($errors->has('sort_order'))
                            <div class="invalid-feedback">{{ $errors->first('sort_order') }}</div>
                        @endif
                    </div>

                    {{-- Status --}}
                    <div class="col-md-3">
                        <label class="amtex-label" for="is_active">Status</label>
                        <select class="form-control {{ $errors->has('is_active') ? 'is-invalid' : '' }}" name="is_active" id="is_active">
                            @foreach(\App\Models\Industry::IS_ACTIVE_SELECT ?? ['yes' => 'YES', 'no' => 'NO'] as $key => $label)
                                <option value="{{ $key }}" {{ old('is_active', $industry->is_active) === (string)$key ? 'selected' : '' }}>
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
                        <i class="fas fa-save"></i> Update
                    </button>
                    <a class="btn btn-light" href="{{ route('admin.industries.index') }}">Cancel</a>
                </div>

            </form>
        </div>
    </div>

</div>

{{-- Small inline script for icon preview --}}
<script>
    (function () {
        const iconInput = document.getElementById('icon');
        const iconPreview = document.getElementById('iconPreview');
        const iconPreviewText = document.getElementById('iconPreviewText');

        if (!iconInput || !iconPreview) return;

        const updatePreview = () => {
            const val = (iconInput.value || '').trim() || 'bi bi-grid';
            iconPreview.innerHTML = `<i class="${val}"></i>`;
            if (iconPreviewText) iconPreviewText.textContent = val;
        };

        iconInput.addEventListener('input', updatePreview);
        updatePreview();
    })();
</script>

@endsection
