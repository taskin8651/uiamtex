@extends('layouts.admin')
@section('content')

<div class="amtex-page">

    {{-- Header --}}
    <div class="amtex-header">
        <div>
            <h2 class="amtex-title">{{ trans('global.edit') }} {{ trans('cruds.download.title_singular') }}</h2>
            <p class="amtex-subtitle">Update download details, replace file, and control visibility.</p>
        </div>

        <div class="amtex-actions d-flex flex-wrap gap-2">
            <a class="btn amtex-btn-outline" href="{{ route('admin.downloads.index') }}">
                <i class="fas fa-arrow-left"></i> Back to List
            </a>

            @can('download_show')
                <a class="btn amtex-btn-outline" href="{{ route('admin.downloads.show', $download->id) }}">
                    <i class="fas fa-eye"></i> View
                </a>
            @endcan
        </div>
    </div>

    {{-- Form Card --}}
    <div class="amtex-card">
        <div class="amtex-card-head d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Edit Download</h4>

            @if((string)($download->is_active ?? '') === 'yes')
                <span class="amtex-chip">Active</span>
            @else
                <span class="amtex-chip amtex-chip-warn">Inactive</span>
            @endif
        </div>

        <div class="amtex-card-body">

            <form method="POST" action="{{ route('admin.downloads.update', [$download->id]) }}" enctype="multipart/form-data">
                @method('PUT')
                @csrf

                <div class="row g-3">

                    {{-- Title --}}
                    <div class="col-lg-6">
                        <label class="amtex-label required" for="title">
                            {{ trans('cruds.download.fields.title') }}
                        </label>

                        <input
                            class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}"
                            type="text"
                            name="title"
                            id="title"
                            value="{{ old('title', $download->title) }}"
                            placeholder="e.g. Product Brochure (PDF)"
                            required
                        >

                        @if($errors->has('title'))
                            <div class="invalid-feedback">{{ $errors->first('title') }}</div>
                        @endif

                        <div class="amtex-help">
                            {{ trans('cruds.download.fields.title_helper') }}
                        </div>
                    </div>

                    {{-- Status --}}
                    <div class="col-lg-6">
                        <label class="amtex-label" for="is_active">
                            {{ trans('cruds.download.fields.is_active') }}
                        </label>

                        <select class="form-control {{ $errors->has('is_active') ? 'is-invalid' : '' }}" name="is_active" id="is_active">
                            <option value disabled {{ old('is_active', null) === null ? 'selected' : '' }}>
                                {{ trans('global.pleaseSelect') }}
                            </option>
                            @foreach(App\Models\Download::IS_ACTIVE_SELECT as $key => $label)
                                <option value="{{ $key }}" {{ old('is_active', $download->is_active) === (string) $key ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>

                        @if($errors->has('is_active'))
                            <div class="invalid-feedback">{{ $errors->first('is_active') }}</div>
                        @endif

                        <div class="amtex-help">
                            {{ trans('cruds.download.fields.is_active_helper') }}
                        </div>
                    </div>

                    {{-- File Upload --}}
                    <div class="col-12">
                        <label class="amtex-label required" for="file">
                            {{ trans('cruds.download.fields.file') }}
                        </label>

                        @if($download->file)
                            <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                                <span class="amtex-chip">
                                    <i class="fas fa-paperclip me-1"></i> Current File Attached
                                </span>
                                <a href="{{ $download->file->getUrl() }}" target="_blank" class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-external-link-alt"></i> Open File
                                </a>
                            </div>
                        @endif

                        <div class="amtex-upload-wrap">
                            <div class="needsclick dropzone {{ $errors->has('file') ? 'is-invalid' : '' }}" id="file-dropzone"></div>

                            <div class="amtex-upload-hint mt-2">
                                <div class="small text-muted">
                                    Upload a new file only if you want to replace the existing one. Max size 10MB.
                                </div>
                            </div>
                        </div>

                        @if($errors->has('file'))
                            <div class="invalid-feedback d-block">{{ $errors->first('file') }}</div>
                        @endif

                        <div class="amtex-help">
                            {{ trans('cruds.download.fields.file_helper') }}
                        </div>
                    </div>

                    {{-- Description --}}
                    <div class="col-12">
                        <label class="amtex-label" for="description">
                            {{ trans('cruds.download.fields.description') }}
                        </label>

                        <textarea
                            class="form-control ckeditor {{ $errors->has('description') ? 'is-invalid' : '' }}"
                            name="description"
                            id="description"
                        >{!! old('description', $download->description) !!}</textarea>

                        @if($errors->has('description'))
                            <div class="invalid-feedback">{{ $errors->first('description') }}</div>
                        @endif

                        <div class="amtex-help">
                            {{ trans('cruds.download.fields.description_helper') }}
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="col-12 d-flex flex-wrap gap-2 justify-content-end mt-2">
                        <a class="btn btn-light" href="{{ route('admin.downloads.index') }}">
                            Cancel
                        </a>

                        <button class="btn amtex-btn" type="submit">
                            <i class="fas fa-save"></i> Update Download
                        </button>
                    </div>

                </div>
            </form>

        </div>
    </div>

</div>

@endsection

@section('scripts')
@parent
<script>
Dropzone.options.fileDropzone = {
    url: '{{ route('admin.downloads.storeMedia') }}',
    maxFilesize: 10, // MB
    maxFiles: 1,
    addRemoveLinks: true,
    timeout: 0,
    headers: {
        'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
        size: 10
    },
    success: function (file, response) {
        $('form').find('input[name="file"]').remove()
        $('form').append('<input type="hidden" name="file" value="' + response.name + '">')
    },
    removedfile: function (file) {
        file.previewElement.remove()
        if (file.status !== 'error') {
            $('form').find('input[name="file"]').remove()
            this.options.maxFiles = this.options.maxFiles + 1
        }
    },
    init: function () {
@if(isset($download) && $download->file)
        var file = {!! json_encode($download->file) !!}
        this.options.addedfile.call(this, file)
        file.previewElement.classList.add('dz-complete')
        $('form').append('<input type="hidden" name="file" value="' + file.file_name + '">')
        this.options.maxFiles = this.options.maxFiles - 1
@endif
    },
    error: function (file, response) {
        if ($.type(response) === 'string') {
            var message = response
        } else {
            var message = response.errors.file
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

<script>
$(document).ready(function () {
    function SimpleUploadAdapter(editor) {
        editor.plugins.get('FileRepository').createUploadAdapter = function(loader) {
            return {
                upload: function() {
                    return loader.file.then(function (file) {
                        return new Promise(function(resolve, reject) {
                            var xhr = new XMLHttpRequest();
                            xhr.open('POST', '{{ route('admin.downloads.storeCKEditorImages') }}', true);
                            xhr.setRequestHeader('x-csrf-token', window._token);
                            xhr.setRequestHeader('Accept', 'application/json');
                            xhr.responseType = 'json';

                            var genericErrorText = `Couldn't upload file: ${ file.name }.`;
                            xhr.addEventListener('error', function() { reject(genericErrorText) });
                            xhr.addEventListener('abort', function() { reject() });
                            xhr.addEventListener('load', function() {
                                var response = xhr.response;

                                if (!response || xhr.status !== 201) {
                                    return reject(response && response.message
                                        ? `${genericErrorText}\n${xhr.status} ${response.message}`
                                        : `${genericErrorText}\n ${xhr.status} ${xhr.statusText}`);
                                }

                                $('form').append('<input type="hidden" name="ck-media[]" value="' + response.id + '">');
                                resolve({ default: response.url });
                            });

                            if (xhr.upload) {
                                xhr.upload.addEventListener('progress', function(e) {
                                    if (e.lengthComputable) {
                                        loader.uploadTotal = e.total;
                                        loader.uploaded = e.loaded;
                                    }
                                });
                            }

                            var data = new FormData();
                            data.append('upload', file);
                            data.append('crud_id', '{{ $download->id ?? 0 }}');
                            xhr.send(data);
                        });
                    })
                }
            };
        }
    }

    var allEditors = document.querySelectorAll('.ckeditor');
    for (var i = 0; i < allEditors.length; ++i) {
        ClassicEditor.create(allEditors[i], {
            extraPlugins: [SimpleUploadAdapter]
        });
    }
});
</script>
@endsection
