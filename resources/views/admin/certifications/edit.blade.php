@extends('layouts.admin')
@section('content')

<div class="amtex-page">

    {{-- Header --}}
    <div class="amtex-header">
        <div>
            <h2 class="amtex-title">{{ trans('global.edit') }} {{ trans('cruds.certification.title_singular') }}</h2>
            <p class="amtex-subtitle">Update certification details, replace image, adjust sort order and status.</p>
        </div>

        <div class="amtex-actions d-flex gap-2 flex-wrap">
            @can('certification_show')
                <a class="btn amtex-btn-outline" href="{{ route('admin.certifications.show', $certification->id) }}">
                    <i class="fas fa-eye"></i> View
                </a>
            @endcan

            <a class="btn amtex-btn-outline" href="{{ route('admin.certifications.index') }}">
                <i class="fas fa-arrow-left"></i> Back to list
            </a>
        </div>
    </div>

    {{-- Form Card --}}
    <div class="amtex-card">
        <div class="amtex-card-head d-flex align-items-center justify-content-between">
            <h4 class="mb-0">Certification Details</h4>

            @if((string)$certification->is_active === '1')
                <span class="amtex-chip">Active</span>
            @else
                <span class="amtex-chip amtex-chip-warn">Inactive</span>
            @endif
        </div>

        <div class="amtex-card-body">
            <form method="POST"
                  action="{{ route('admin.certifications.update', [$certification->id]) }}"
                  enctype="multipart/form-data"
                  id="certEditForm">
                @method('PUT')
                @csrf

                <div class="row g-3">

                    {{-- Title --}}
                    <div class="col-12">
                        <label class="amtex-label required" for="title">
                            {{ trans('cruds.certification.fields.title') }}
                        </label>

                        <input
                            class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}"
                            type="text"
                            name="title"
                            id="title"
                            value="{{ old('title', $certification->title) }}"
                            required
                            placeholder="Example: ISO 9001:2015 Certificate"
                        >

                        @if($errors->has('title'))
                            <div class="invalid-feedback">{{ $errors->first('title') }}</div>
                        @endif

                        <div class="form-text">
                            Use a clear name to identify the certificate.
                        </div>
                    </div>

                    {{-- Image --}}
                    <div class="col-12">
                        <label class="amtex-label required" for="image-dropzone">
                            {{ trans('cruds.certification.fields.image') }}
                        </label>

                        <div class="needsclick dropzone {{ $errors->has('image') ? 'is-invalid' : '' }}" id="image-dropzone"></div>

                        @if($errors->has('image'))
                            <div class="invalid-feedback d-block">{{ $errors->first('image') }}</div>
                        @endif

                        <div class="form-text">
                            Upload a new image only if you want to replace the existing one.
                        </div>

                        {{-- Existing image preview (optional, useful) --}}
                        @if($certification->image)
                            <div class="mt-2 small text-muted">
                                Current image:
                                <a href="{{ $certification->image->url }}" target="_blank" rel="noopener">Open</a>
                            </div>
                        @endif
                    </div>

                    {{-- Sort Order --}}
                    <div class="col-md-6">
                        <label class="amtex-label required" for="sort_order">
                            {{ trans('cruds.certification.fields.sort_order') }}
                        </label>

                        <input
                            class="form-control {{ $errors->has('sort_order') ? 'is-invalid' : '' }}"
                            type="number"
                            name="sort_order"
                            id="sort_order"
                            value="{{ old('sort_order', $certification->sort_order ?? 0) }}"
                            required
                            min="0"
                            step="1"
                            placeholder="0"
                        >

                        @if($errors->has('sort_order'))
                            <div class="invalid-feedback">{{ $errors->first('sort_order') }}</div>
                        @endif

                        <div class="form-text">
                            Lower number shows first.
                        </div>
                    </div>

                    {{-- Status --}}
                    <div class="col-md-6">
                        <label class="amtex-label" for="is_active">
                            {{ trans('cruds.certification.fields.is_active') }}
                        </label>

                        <select
                            class="form-control {{ $errors->has('is_active') ? 'is-invalid' : '' }}"
                            name="is_active"
                            id="is_active"
                        >
                            <option value="1" {{ old('is_active', (string)$certification->is_active) === '1' ? 'selected' : '' }}>
                                YES (Active)
                            </option>
                            <option value="0" {{ old('is_active', (string)$certification->is_active) === '0' ? 'selected' : '' }}>
                                NO (Inactive)
                            </option>
                        </select>

                        @if($errors->has('is_active'))
                            <div class="invalid-feedback">{{ $errors->first('is_active') }}</div>
                        @endif

                        <div class="form-text">
                            Inactive items won’t appear on frontend.
                        </div>
                    </div>

                </div>

                {{-- Sticky Actions --}}
                <div class="page-actions mt-3">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <a href="{{ route('admin.certifications.index') }}" class="btn btn-light">
                            Cancel
                        </a>

                        <button class="btn btn-danger" type="submit">
                            <i class="fas fa-save"></i> Update Certification
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>

</div>

@endsection

@section('styles')
@parent
<style>
    .page-actions{
        position: sticky;
        bottom: 0;
        background: #fff;
        padding: 12px;
        border-top: 1px solid rgba(0,0,0,.08);
        z-index: 5;
        border-radius: 0 0 10px 10px;
    }
    .amtex-label{ font-weight: 600; margin-bottom: 6px; display:block; }
</style>
@endsection

@section('scripts')
@parent
<script>
    Dropzone.options.imageDropzone = {
        url: '{{ route('admin.certifications.storeMedia') }}',
        maxFilesize: 10, // MB
        acceptedFiles: '.jpeg,.jpg,.png,.gif',
        maxFiles: 1,
        addRemoveLinks: true,
        headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        params: {
            size: 10,
            width: 4096,
            height: 4096
        },
        success: function (file, response) {
            $('#certEditForm').find('input[name="image"]').remove()
            $('#certEditForm').append('<input type="hidden" name="image" value="' + response.name + '">')
        },
        removedfile: function (file) {
            file.previewElement.remove()
            if (file.status !== 'error') {
                $('#certEditForm').find('input[name="image"]').remove()
                this.options.maxFiles = this.options.maxFiles + 1
            }
        },
        init: function () {
            @if(isset($certification) && $certification->image)
                var file = {!! json_encode($certification->image) !!};

                this.options.addedfile.call(this, file);

                // QuickAdminPanel media usually provides "preview" or "preview_url"
                this.options.thumbnail.call(this, file, file.preview ?? file.preview_url ?? file.url);

                file.previewElement.classList.add('dz-complete');

                $('#certEditForm').append('<input type="hidden" name="image" value="' + file.file_name + '">');

                this.options.maxFiles = this.options.maxFiles - 1;
            @endif
        },
        error: function (file, response) {
            let message = '';
            if ($.type(response) === 'string') {
                message = response;
            } else {
                message = response.errors?.file || 'Upload failed';
            }
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
