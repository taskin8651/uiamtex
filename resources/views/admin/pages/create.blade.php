@extends('layouts.admin')
@section('content')

<div class="card page-create-card">
    <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
        <div>
            <strong>{{ trans('global.create') }} {{ trans('cruds.page.title_singular') }}</strong>
            <div class="text-muted small mt-1">Create a new page with content and SEO metadata.</div>
        </div>
        <a class="btn btn-light" href="{{ route('admin.pages.index') }}">
            {{ trans('global.back_to_list') ?? 'Back to list' }}
        </a>
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('admin.pages.store') }}" enctype="multipart/form-data" id="pageCreateForm">
            @csrf

            <div class="row">
                {{-- LEFT: Main Content --}}
                <div class="col-12 col-lg-8">
                    <div class="card inner-card mb-3">
                        <div class="card-header">
                            <strong>Page Details</strong>
                        </div>
                        <div class="card-body">

                            {{-- Title --}}
                            <div class="form-group">
                                <label class="required" for="title">{{ trans('cruds.page.fields.title') }}</label>
                                <input
                                    class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}"
                                    type="text"
                                    name="title"
                                    id="title"
                                    value="{{ old('title', '') }}"
                                    required
                                    placeholder="Example: About Us"
                                >
                                @if($errors->has('title'))
                                    <div class="invalid-feedback">{{ $errors->first('title') }}</div>
                                @endif
                                <span class="help-block">{{ trans('cruds.page.fields.title_helper') }}</span>
                            </div>

                            {{-- Slug --}}
                            <div class="form-group">
                                <label class="required d-flex align-items-center justify-content-between" for="slug">
                                    <span>{{ trans('cruds.page.fields.slug') }}</span>
                                    <small class="text-muted">Auto-generated from title (editable)</small>
                                </label>
                                <input
                                    class="form-control {{ $errors->has('slug') ? 'is-invalid' : '' }}"
                                    type="text"
                                    name="slug"
                                    id="slug"
                                    value="{{ old('slug', '') }}"
                                    required
                                    placeholder="example: about-us"
                                >
                                @if($errors->has('slug'))
                                    <div class="invalid-feedback">{{ $errors->first('slug') }}</div>
                                @endif
                                <span class="help-block">{{ trans('cruds.page.fields.slug_helper') }}</span>
                            </div>

                            {{-- Content --}}
                            <div class="form-group">
                                <label for="content">{{ trans('cruds.page.fields.content') }}</label>
                                <textarea
                                    class="form-control ckeditor {{ $errors->has('content') ? 'is-invalid' : '' }}"
                                    name="content"
                                    id="content"
                                >{!! old('content') !!}</textarea>

                                @if($errors->has('content'))
                                    <div class="invalid-feedback">{{ $errors->first('content') }}</div>
                                @endif
                                <span class="help-block">{{ trans('cruds.page.fields.content_helper') }}</span>
                            </div>

                        </div>
                    </div>
                </div>

                {{-- RIGHT: SEO + Status + Placement --}}
                <div class="col-12 col-lg-4">
                    <div class="card inner-card mb-3">
                        <div class="card-header">
                            <strong>SEO</strong>
                        </div>
                        <div class="card-body">

                            {{-- SEO Title --}}
                            <div class="form-group">
                                <label class="required d-flex align-items-center justify-content-between" for="seo_title">
                                    <span>{{ trans('cruds.page.fields.seo_title') }}</span>
                                    <small class="text-muted"><span id="seoTitleCount">0</span>/60</small>
                                </label>
                                <input
                                    class="form-control {{ $errors->has('seo_title') ? 'is-invalid' : '' }}"
                                    type="text"
                                    name="seo_title"
                                    id="seo_title"
                                    value="{{ old('seo_title', '') }}"
                                    required
                                    placeholder="Recommended: up to 60 characters"
                                >
                                @if($errors->has('seo_title'))
                                    <div class="invalid-feedback">{{ $errors->first('seo_title') }}</div>
                                @endif
                                <span class="help-block">{{ trans('cruds.page.fields.seo_title_helper') }}</span>
                            </div>

                            {{-- SEO Description --}}
                            <div class="form-group">
                                <label class="d-flex align-items-center justify-content-between" for="seo_description">
                                    <span>{{ trans('cruds.page.fields.seo_description') }}</span>
                                    <small class="text-muted"><span id="seoDescCount">0</span>/160</small>
                                </label>
                                <textarea
                                    class="form-control {{ $errors->has('seo_description') ? 'is-invalid' : '' }}"
                                    name="seo_description"
                                    id="seo_description"
                                    rows="5"
                                    placeholder="Recommended: up to 160 characters"
                                >{!! old('seo_description') !!}</textarea>
                                @if($errors->has('seo_description'))
                                    <div class="invalid-feedback">{{ $errors->first('seo_description') }}</div>
                                @endif
                                <span class="help-block">{{ trans('cruds.page.fields.seo_description_helper') }}</span>
                            </div>

                        </div>
                    </div>

                    <div class="card inner-card mb-3">
                        <div class="card-header">
                            <strong>Status</strong>
                        </div>
                        <div class="card-body">

                            {{-- Is Active --}}
                            <div class="form-group mb-0">
                                <label class="required" for="is_active">{{ trans('cruds.page.fields.is_active') }}</label>
                                <select
                                    class="form-control {{ $errors->has('is_active') ? 'is-invalid' : '' }}"
                                    name="is_active"
                                    id="is_active"
                                    required
                                >
                                    <option value disabled {{ old('is_active', null) === null ? 'selected' : '' }}>
                                        {{ trans('global.pleaseSelect') }}
                                    </option>
                                    @foreach(App\Models\Page::IS_ACTIVE_SELECT as $key => $label)
                                        <option value="{{ $key }}" {{ old('is_active', '0') === (string) $key ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                @if($errors->has('is_active'))
                                    <div class="invalid-feedback">{{ $errors->first('is_active') }}</div>
                                @endif
                                <span class="help-block">{{ trans('cruds.page.fields.is_active_helper') }}</span>
                            </div>

                        </div>
                    </div>

                    {{-- NEW: Placement / Visibility Toggles --}}
                    <div class="card inner-card mb-3">
                        <div class="card-header">
                            <strong>Placement</strong>
                            <div class="text-muted small">Choose where this page link should appear.</div>
                        </div>
                        <div class="card-body">

                            <div class="form-group mb-3">
                                <div class="custom-control custom-switch">
                                    <input
                                        type="checkbox"
                                        class="custom-control-input"
                                        id="show_in_navbar"
                                        name="show_in_navbar"
                                        value="1"
                                        {{ old('show_in_navbar', 0) ? 'checked' : '' }}
                                    >
                                    <label class="custom-control-label" for="show_in_navbar">
                                        Add on Navigation bar
                                    </label>
                                </div>
                                @if($errors->has('show_in_navbar'))
                                    <div class="text-danger small mt-1">{{ $errors->first('show_in_navbar') }}</div>
                                @endif
                            </div>

                            <div class="form-group mb-3">
                                <div class="custom-control custom-switch">
                                    <input
                                        type="checkbox"
                                        class="custom-control-input"
                                        id="show_in_footer"
                                        name="show_in_footer"
                                        value="1"
                                        {{ old('show_in_footer', 0) ? 'checked' : '' }}
                                    >
                                    <label class="custom-control-label" for="show_in_footer">
                                        Add on Footer
                                    </label>
                                </div>
                                @if($errors->has('show_in_footer'))
                                    <div class="text-danger small mt-1">{{ $errors->first('show_in_footer') }}</div>
                                @endif
                            </div>

                            <div class="form-group mb-0">
                                <div class="custom-control custom-switch">
                                    <input
                                        type="checkbox"
                                        class="custom-control-input"
                                        id="show_in_footer_bottom"
                                        name="show_in_footer_bottom"
                                        value="1"
                                        {{ old('show_in_footer_bottom', 0) ? 'checked' : '' }}
                                    >
                                    <label class="custom-control-label" for="show_in_footer_bottom">
                                        Add on Footer Bottom
                                    </label>
                                </div>
                                @if($errors->has('show_in_footer_bottom'))
                                    <div class="text-danger small mt-1">{{ $errors->first('show_in_footer_bottom') }}</div>
                                @endif
                            </div>

                            <div class="text-muted small mt-3">
                                Note: The page must be <strong>Active</strong> to appear on the frontend.
                            </div>

                        </div>
                    </div>

                </div>
            </div>

            {{-- Sticky Actions --}}
            <div class="page-actions">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <a href="{{ route('admin.pages.index') }}" class="btn btn-light">
                        Cancel
                    </a>

                    <button class="btn btn-danger" type="submit">
                        {{ trans('global.save') }}
                    </button>
                </div>
            </div>

        </form>
    </div>
</div>

@endsection

@section('styles')
@parent
<style>
    .page-create-card .inner-card { border: 1px solid rgba(0,0,0,.08); }
    .page-actions{
        position: sticky;
        bottom: 0;
        background: #fff;
        padding: 12px;
        border-top: 1px solid rgba(0,0,0,.08);
        margin-top: 10px;
        z-index: 5;
    }
    /* Improve CKEditor block spacing */
    .ck-editor__editable_inline { min-height: 320px; }

    /* Optional: make switches look consistent in older bootstrap/admin themes */
    .custom-control-label { cursor: pointer; }
</style>
@endsection

@section('scripts')
@parent
<script>
$(document).ready(function () {

    // ---------- Slug auto-generate (title -> slug), but don't override if user edits slug ----------
    let slugTouched = false;

    function slugify(text) {
        return text
            .toString()
            .trim()
            .toLowerCase()
            .replace(/['"]/g, '')
            .replace(/\s+/g, '-')         // spaces to dashes
            .replace(/[^a-z0-9\-]/g, '-') // remove invalid chars
            .replace(/\-+/g, '-')         // collapse multiple dashes
            .replace(/^\-+|\-+$/g, '');   // trim dashes
    }

    $('#slug').on('input', function () {
        slugTouched = $(this).val().trim().length > 0;
    });

    $('#title').on('input', function () {
        if (!slugTouched) {
            $('#slug').val(slugify($(this).val()));
        }
    });

    // ---------- SEO counters ----------
    function updateCount(inputSelector, countSelector) {
        const val = $(inputSelector).val() || '';
        $(countSelector).text(val.length);
    }

    updateCount('#seo_title', '#seoTitleCount');
    updateCount('#seo_description', '#seoDescCount');

    $('#seo_title').on('input', function(){ updateCount('#seo_title', '#seoTitleCount'); });
    $('#seo_description').on('input', function(){ updateCount('#seo_description', '#seoDescCount'); });

    // ---------- CKEditor upload adapter (your existing logic; kept intact) ----------
    function SimpleUploadAdapter(editor) {
        editor.plugins.get('FileRepository').createUploadAdapter = function(loader) {
            return {
                upload: function() {
                    return loader.file.then(function (file) {
                        return new Promise(function(resolve, reject) {

                            var xhr = new XMLHttpRequest();
                            xhr.open('POST', '{{ route('admin.pages.storeCKEditorImages') }}', true);
                            xhr.setRequestHeader('x-csrf-token', window._token);
                            xhr.setRequestHeader('Accept', 'application/json');
                            xhr.responseType = 'json';

                            var genericErrorText = `Couldn't upload file: ${ file.name }.`;

                            xhr.addEventListener('error', function() { reject(genericErrorText) });
                            xhr.addEventListener('abort', function() { reject() });
                            xhr.addEventListener('load', function() {
                                var response = xhr.response;

                                if (!response || xhr.status !== 201) {
                                    return reject(
                                        response && response.message
                                            ? `${genericErrorText}\n${xhr.status} ${response.message}`
                                            : `${genericErrorText}\n ${xhr.status} ${xhr.statusText}`
                                    );
                                }

                                $('#pageCreateForm').append('<input type="hidden" name="ck-media[]" value="' + response.id + '">');

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
                            data.append('crud_id', 0);
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
