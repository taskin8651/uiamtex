@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <span>{{ trans('global.create') }} Service</span>
        <a class="btn btn-default btn-sm" href="{{ route('admin.services.index') }}">
            {{ trans('global.back_to_list') }}
        </a>
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('admin.services.store') }}">
            @csrf

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="required">Title</label>
                    <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}"
                           type="text" name="title" value="{{ old('title') }}" required>
                    @if($errors->has('title')) <div class="invalid-feedback">{{ $errors->first('title') }}</div> @endif
                </div>

                <div class="col-md-6">
                    <label>Category</label>
                    <input class="form-control {{ $errors->has('category') ? 'is-invalid' : '' }}"
                           type="text" name="category" value="{{ old('category') }}"
                           placeholder="e.g. Fire Extinguisher Services">
                    @if($errors->has('category')) <div class="invalid-feedback">{{ $errors->first('category') }}</div> @endif
                </div>

                <div class="col-md-12">
                    <label>Short Description</label>
                    <textarea class="form-control {{ $errors->has('short_description') ? 'is-invalid' : '' }}"
                              name="short_description" rows="3"
                              placeholder="Short summary shown on service card">{{ old('short_description') }}</textarea>
                    @if($errors->has('short_description')) <div class="invalid-feedback">{{ $errors->first('short_description') }}</div> @endif
                </div>

                <div class="col-md-4">
                    <label>CTA Label</label>
                    <input class="form-control {{ $errors->has('cta_label') ? 'is-invalid' : '' }}"
                           type="text" name="cta_label" value="{{ old('cta_label') }}"
                           placeholder="e.g. Get Quote">
                    @if($errors->has('cta_label')) <div class="invalid-feedback">{{ $errors->first('cta_label') }}</div> @endif
                </div>

                <div class="col-md-4">
                    <label class="required">Sort Order</label>
                    <input class="form-control {{ $errors->has('sort_order') ? 'is-invalid' : '' }}"
                           type="number" name="sort_order" value="{{ old('sort_order', 0) }}" required>
                    @if($errors->has('sort_order')) <div class="invalid-feedback">{{ $errors->first('sort_order') }}</div> @endif
                </div>

                <div class="col-md-4">
                    <label class="required">Status</label>
                    <select class="form-control {{ $errors->has('is_active') ? 'is-invalid' : '' }}" name="is_active" required>
                        @foreach($isActiveOptions as $key => $label)
                            <option value="{{ $key }}" {{ old('is_active','yes')===(string)$key?'selected':'' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('is_active')) <div class="invalid-feedback">{{ $errors->first('is_active') }}</div> @endif
                </div>
            </div>

            <hr class="my-4">

            <div class="d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Service Features</h5>
                <button type="button" class="btn btn-sm btn-outline-primary" id="addFeatureBtn">
                    <i class="fas fa-plus"></i> Add Feature
                </button>
            </div>
            <p class="text-muted small mb-2">These bullets will appear under the service on frontend.</p>

            <div id="featuresWrap" class="mt-2">
                {{-- initial 3 empty rows --}}
                @for($i=0; $i<3; $i++)
                    <div class="feature-row border rounded p-2 mb-2">
                        <div class="row g-2 align-items-center">
                            <div class="col-md-9">
                                <input type="text" name="features[{{ $i }}][feature_text]" class="form-control"
                                       placeholder="e.g. Annual maintenance & refilling support">
                            </div>
                            <div class="col-md-2">
                                <input type="number" name="features[{{ $i }}][sort_order]" class="form-control" value="{{ $i+1 }}">
                            </div>
                            <div class="col-md-1 text-end">
                                <button type="button" class="btn btn-sm btn-outline-danger removeFeatureBtn" title="Remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>

            <div class="mt-4 d-flex gap-2">
                <button class="btn btn-danger" type="submit">{{ trans('global.save') }}</button>
                <a class="btn btn-light" href="{{ route('admin.services.index') }}">Cancel</a>
            </div>

        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
(function () {
    const wrap = document.getElementById('featuresWrap');
    const addBtn = document.getElementById('addFeatureBtn');

    function reindex() {
        const rows = wrap.querySelectorAll('.feature-row');
        rows.forEach((row, idx) => {
            const text = row.querySelector('[data-role="feature_text"]');
            const sort = row.querySelector('[data-role="sort_order"]');

            text.name = `features[${idx}][feature_text]`;
            sort.name = `features[${idx}][sort_order]`;

            if (!sort.value) sort.value = (idx + 1);
        });
    }

    function rowTemplate() {
        const div = document.createElement('div');
        div.className = 'feature-row border rounded p-2 mb-2';
        div.innerHTML = `
            <div class="row g-2 align-items-center">
                <div class="col-md-9">
                    <input type="text" data-role="feature_text" class="form-control"
                           placeholder="e.g. Site survey & compliance guidance">
                </div>
                <div class="col-md-2">
                    <input type="number" data-role="sort_order" class="form-control" value="">
                </div>
                <div class="col-md-1 text-end">
                    <button type="button" class="btn btn-sm btn-outline-danger removeFeatureBtn" title="Remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        `;
        return div;
    }

    addBtn.addEventListener('click', function () {
        wrap.appendChild(rowTemplate());
        reindex();
    });

    wrap.addEventListener('click', function (e) {
        const btn = e.target.closest('.removeFeatureBtn');
        if (!btn) return;
        btn.closest('.feature-row').remove();
        reindex();
    });

    // convert initial rows inputs to data-role for reindex logic
    wrap.querySelectorAll('.feature-row').forEach((row) => {
        const inputs = row.querySelectorAll('input');
        inputs[0].setAttribute('data-role', 'feature_text');
        inputs[1].setAttribute('data-role', 'sort_order');
    });
    reindex();
})();
</script>
@endsection
