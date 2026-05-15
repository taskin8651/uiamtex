@extends('layouts.admin')
@section('content')

<div class="amtex-page">

    {{-- Header --}}
    <div class="amtex-header">
        <div>
            <h2 class="amtex-title">{{ trans('global.create') }} {{ trans('cruds.client.title_singular') }}</h2>
            <p class="amtex-subtitle">Add a new client logo for the frontend Clients section.</p>
        </div>

        <div class="amtex-actions">
            <a class="btn btn-light" href="{{ route('admin.clients.index') }}">
                {{ trans('global.back_to_list') ?? 'Back to list' }}
            </a>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.clients.store') }}" enctype="multipart/form-data" id="clientCreateForm">
        @csrf

        <div class="row g-3">
            {{-- Left: Main --}}
            <div class="col-12 col-lg-8">
                <div class="amtex-card">
                    <div class="amtex-card-head">
                        <h4 class="mb-0">Client Details</h4>
                    </div>

                    <div class="amtex-card-body">

                        {{-- Name --}}
                        <div class="form-group">
                            <label class="required" for="name">{{ trans('cruds.client.fields.name') }}</label>
                            <input
                                class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                type="text"
                                name="name"
                                id="name"
                                value="{{ old('name', '') }}"
                                required
                                placeholder="Example: ABC Industries"
                            >
                            @if($errors->has('name'))
                                <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                            @endif
                            <span class="help-block">{{ trans('cruds.client.fields.name_helper') }}</span>
                        </div>

                        {{-- Logo --}}
                        <div class="form-group">
                            <label class="required" for="logo">{{ trans('cruds.client.fields.logo') }}</label>

                            <div class="amtex-uploader {{ $errors->has('logo') ? 'is-invalid' : '' }}">
                                <div class="needsclick dropzone" id="logo-dropzone"></div>
                                <div class="amtex-uploader-hint">
                                    <div class="small text-muted">
                                        Recommended: transparent PNG logo • Max 10MB • 4096×4096
                                    </div>
                                </div>
                            </div>

                            @if($errors->has('logo'))
                                <div class="invalid-feedback d-block">{{ $errors->first('logo') }}</div>
                            @endif
                            <span class="help-block">{{ trans('cruds.client.fields.logo_helper') }}</span>
                        </div>

                        {{-- Sort Order --}}
                        <div class="form-group">
                            <label class="required" for="sort_order">{{ trans('cruds.client.fields.sort_order') }}</label>
                            <input
                                class="form-control {{ $errors->has('sort_order') ? 'is-invalid' : '' }}"
                                type="number"
                                name="sort_order"
                                id="sort_order"
                                value="{{ old('sort_order', 0) }}"
                                required
                                min="0"
                                step="1"
                                placeholder="0"
                            >
                            @if($errors->has('sort_order'))
                                <div class="invalid-feedback">{{ $errors->first('sort_order') }}</div>
                            @endif
                            <span class="help-block">{{ trans('cruds.client.fields.sort_order_helper') }}</span>
                        </div>

                    </div>
                </div>
            </div>

            {{-- Right: Status --}}
            <div class="col-12 col-lg-4">
                <div class="amtex-card">
                    <div class="amtex-card-head">
                        <h4 class="mb-0">Status</h4>
                    </div>

                    <div class="amtex-card-body">

                        <div class="form-group mb-0">
                            <label for="is_active">{{ trans('cruds.client.fields.is_active') }}</label>
                            <select
                                class="form-control {{ $errors->has('is_active') ? 'is-invalid' : '' }}"
                                name="is_active"
                                id="is_active"
                            >
                                <option value disabled {{ old('is_active', null) === null ? 'selected' : '' }}>
                                    {{ trans('global.pleaseSelect') }}
                                </option>
                                @foreach(App\Models\Client::IS_ACTIVE_SELECT as $key => $label)
                                    <option value="{{ $key }}" {{ old('is_active', 'yes') === (string) $key ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>

                            @if($errors->has('is_active'))
                                <div class="invalid-feedback">{{ $errors->first('is_active') }}</div>
                            @endif
                            <span class="help-block">{{ trans('cruds.client.fields.is_active_helper') }}</span>
                        </div>

                    </div>
                </div>

                <div class="amtex-card mt-3">
                    <div class="amtex-card-body">
                        <div class="small text-muted">
                            Tip: Use <strong>Sort Order</strong> to control logo sequence on the frontend.
                            Lower number appears first.
                        </div>
                    </div>
                </div>

            </div>
        </div>

        {{-- Sticky Actions --}}
        <div class="page-actions">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <a href="{{ route('admin.clients.index') }}" class="btn btn-light">
                    Cancel
                </a>

                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </div>

    </form>

</div>

@endsection

@section('styles')
@parent
<style>
    /* keep consistent with your other premium pages */
    .page-actions{
        position: sticky;
        bottom: 0;
        background: #fff;
        padding: 12px;
        border-top: 1px solid rgba(0,0,0,.08);
        margin-top: 14px;
        z-index: 5;
        border-radius: 12px;
    }

    /* premium dropzone wrapper */
    .amtex-uploader{
        border: 1px solid rgba(0,0,0,.08);
        border-radius: 14px;
        padding: 12px;
        background: #fff;
    }
    .amtex-uploader .dropzone{
        border: 2px dashed rgba(0,0,0,.15);
        border-radius: 14px;
        background: rgba(0,0,0,.02);
        min-height: 180px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .amtex-uploader .dz-message{
        margin: 0;
        font-weight: 600;
        color: rgba(0,0,0,.65);
    }
    .amtex-uploader-hint{
        margin-top: 10px;
    }
</style>
@endsection

@section('scripts')
@parent
<script>
    Dropzone.options.logoDropzone = {
        url: '{{ route('admin.clients.storeMedia') }}',
        maxFilesize: 10, // MB
        acceptedFiles: '.jpeg,.jpg,.png,.gif',
        maxFiles: 1,
        addRemoveLinks: true,
        timeout: 0,
        headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        params: {
            size: 10,
            width: 4096,
            height: 4096
        },
        success: function (file, response) {
            $('#clientCreateForm').find('input[name="logo"]').remove();
            $('#clientCreateForm').append('<input type="hidden" name="logo" value="' + response.name + '">');
        },
        removedfile: function (file) {
            file.previewElement.remove();
            if (file.status !== 'error') {
                $('#clientCreateForm').find('input[name="logo"]').remove();
                this.options.maxFiles = this.options.maxFiles + 1;
            }
        },
        init: function () {
            // Create page: no prefill needed
        },
        error: function (file, response) {
            let message = '';
            if ($.type(response) === 'string') {
                message = response;
            } else if (response && response.errors && response.errors.file) {
                message = response.errors.file;
            } else {
                message = 'Upload failed. Please try again.';
            }

            file.previewElement.classList.add('dz-error');
            let _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]');
            for (let i = 0; i < _ref.length; i++) {
                _ref[i].textContent = message;
            }
        }
    }
</script>
@endsection
