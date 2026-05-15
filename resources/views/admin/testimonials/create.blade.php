@extends('layouts.admin')
@section('content')

<div class="amtex-page">
    <div class="amtex-header">
        <div>
            <h2 class="amtex-title">Add Testimonial</h2>
            <p class="amtex-subtitle">Create a new testimonial for the website.</p>
        </div>
        <div class="amtex-actions">
            <a href="{{ route('admin.testimonials.index') }}" class="btn amtex-btn-outline">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <div class="amtex-card">
        <div class="amtex-card-body">
            <form method="POST" action="{{ route('admin.testimonials.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="amtex-label required">Name</label>
                        <input type="text" name="name" value="{{ old('name') }}"
                               class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" required>
                        @if($errors->has('name')) <div class="invalid-feedback">{{ $errors->first('name') }}</div> @endif
                    </div>

                    <div class="col-md-6">
                        <label class="amtex-label">Company / Designation</label>
                        <input type="text" name="company_designation" value="{{ old('company_designation') }}"
                               class="form-control {{ $errors->has('company_designation') ? 'is-invalid' : '' }}">
                        @if($errors->has('company_designation')) <div class="invalid-feedback">{{ $errors->first('company_designation') }}</div> @endif
                    </div>

                    <div class="col-md-6">
                        <label class="amtex-label">Photo (Optional)</label>
                        <div class="needsclick dropzone {{ $errors->has('photo') ? 'is-invalid' : '' }}" id="photo-dropzone"></div>
                        @if($errors->has('photo')) <div class="invalid-feedback">{{ $errors->first('photo') }}</div> @endif
                        <div class="small text-muted mt-1">Recommended: square image for best results.</div>
                    </div>

                    <div class="col-md-3">
                        <label class="amtex-label required">Status</label>
                        <select name="is_active" class="form-control {{ $errors->has('is_active') ? 'is-invalid' : '' }}" required>
                            @foreach(\App\Models\Testimonial::IS_ACTIVE_SELECT as $key => $label)
                                <option value="{{ $key }}" {{ old('is_active','yes') === (string)$key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('is_active')) <div class="invalid-feedback">{{ $errors->first('is_active') }}</div> @endif
                    </div>

                    <div class="col-md-3">
                        <label class="amtex-label">Sort Order</label>
                        <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}"
                               class="form-control {{ $errors->has('sort_order') ? 'is-invalid' : '' }}">
                        @if($errors->has('sort_order')) <div class="invalid-feedback">{{ $errors->first('sort_order') }}</div> @endif
                    </div>

                    <div class="col-12">
                        <label class="amtex-label required">Review</label>
                        <textarea name="review" rows="5"
                                  class="form-control {{ $errors->has('review') ? 'is-invalid' : '' }}"
                                  required>{{ old('review') }}</textarea>
                        @if($errors->has('review')) <div class="invalid-feedback">{{ $errors->first('review') }}</div> @endif
                    </div>

                    <div class="col-12 d-flex gap-2">
                        <button class="btn btn-danger" type="submit">
                            <i class="fas fa-save"></i> Save
                        </button>
                        <a href="{{ route('admin.testimonials.index') }}" class="btn btn-light">Cancel</a>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
Dropzone.options.photoDropzone = {
    url: '{{ route('admin.testimonials.storeMedia') }}',
    maxFilesize: 10,
    acceptedFiles: '.jpeg,.jpg,.png,.gif,.webp',
    maxFiles: 1,
    addRemoveLinks: true,
    headers: { 'X-CSRF-TOKEN': "{{ csrf_token() }}" },
    params: { size: 10, width: 4096, height: 4096 },
    success: function (file, response) {
        $('form').find('input[name="photo"]').remove()
        $('form').append('<input type="hidden" name="photo" value="' + response.name + '">')
    },
    removedfile: function (file) {
        file.previewElement.remove()
        if (file.status !== 'error') {
            $('form').find('input[name="photo"]').remove()
            this.options.maxFiles = this.options.maxFiles + 1
        }
    },
    init: function () {},
    error: function (file, response) {
        var message = $.type(response) === 'string' ? response : (response.errors?.file || 'Upload failed')
        file.previewElement.classList.add('dz-error')
        _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
        _results = []
        for (_i = 0, _len = _ref.length; _i < _len; _i++) {
            node = _ref[_i]
            _results.push(node.textContent = message)
        }
        return _results
    }
}
</script>
@endsection
