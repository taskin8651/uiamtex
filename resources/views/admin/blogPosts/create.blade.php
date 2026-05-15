@extends('layouts.admin')
@section('content')

<div class="card amtex-premium-bpostform-card">
    <div class="card-header amtex-premium-bpostform-header">
        <div class="amtex-premium-bpostform-head">
            <div class="amtex-premium-bpostform-title">
                {{ trans('global.create') }} {{ trans('cruds.blogPost.title_singular') }}
            </div>
            <div class="amtex-premium-bpostform-subtitle">
                Create a new blog post with auto slug, read time, and publish date support.
            </div>
        </div>

        <div class="amtex-premium-bpostform-header-actions">
            <a href="{{ route('admin.blog-posts.index') }}" class="btn btn-light amtex-premium-bpostform-btn-soft">
                <i class="fas fa-arrow-left"></i> {{ trans('global.back_to_list') ?? 'Back to list' }}
            </a>
        </div>
    </div>

    <div class="card-body amtex-premium-bpostform-body">
        <form method="POST" action="{{ route("admin.blog-posts.store") }}" enctype="multipart/form-data" class="amtex-premium-bpostform-form">
            @csrf

            <div class="amtex-premium-bpostform-grid">

                {{-- Category --}}
                <div class="form-group amtex-premium-bpostform-field">
                    <label class="required amtex-premium-bpostform-label" for="select_category_id">{{ trans('cruds.blogPost.fields.select_category') }}</label>
                    <select class="form-control select2 amtex-premium-bpostform-input {{ $errors->has('select_category') ? 'is-invalid' : '' }}" name="select_category_id" id="select_category_id" required>
                        @foreach($select_categories as $id => $entry)
                            <option value="{{ $id }}" {{ old('select_category_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('select_category'))
                        <div class="invalid-feedback">
                            {{ $errors->first('select_category') }}
                        </div>
                    @endif
                    <span class="help-block amtex-premium-bpostform-help">{{ trans('cruds.blogPost.fields.select_category_helper') }}</span>
                </div>

                {{-- Title --}}
                <div class="form-group amtex-premium-bpostform-field">
                    <label class="required amtex-premium-bpostform-label" for="title">{{ trans('cruds.blogPost.fields.title') }}</label>
                    <input class="form-control amtex-premium-bpostform-input {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title" id="title" value="{{ old('title', '') }}" required placeholder="e.g. Fire Safety Checklist for Offices">
                    @if($errors->has('title'))
                        <div class="invalid-feedback">
                            {{ $errors->first('title') }}
                        </div>
                    @endif
                    <span class="help-block amtex-premium-bpostform-help">{{ trans('cruds.blogPost.fields.title_helper') }}</span>
                </div>

                {{-- Slug --}}
                <div class="form-group amtex-premium-bpostform-field">
                    <label class="required amtex-premium-bpostform-label" for="slug">{{ trans('cruds.blogPost.fields.slug') }}</label>

                    <div class="amtex-premium-bpostform-slugwrap">
                        <input class="form-control amtex-premium-bpostform-input {{ $errors->has('slug') ? 'is-invalid' : '' }}" type="text" name="slug" id="slug" value="{{ old('slug', '') }}" required placeholder="auto-generated-from-title">
                        <button type="button" class="btn btn-light amtex-premium-bpostform-slugbtn" id="amtexBpostSlugRegenerate" title="Regenerate from title">
                            <i class="fas fa-sync-alt"></i>
                        </button>
                    </div>

                    @if($errors->has('slug'))
                        <div class="invalid-feedback">
                            {{ $errors->first('slug') }}
                        </div>
                    @endif
                    <span class="help-block amtex-premium-bpostform-help">{{ trans('cruds.blogPost.fields.slug_helper') }}</span>
                </div>

                {{-- Excerpt --}}
                <div class="form-group amtex-premium-bpostform-field amtex-premium-bpostform-field--full">
                    <label class="required amtex-premium-bpostform-label" for="excerpt">{{ trans('cruds.blogPost.fields.excerpt') }}</label>
                    <textarea class="form-control amtex-premium-bpostform-textarea {{ $errors->has('excerpt') ? 'is-invalid' : '' }}" name="excerpt" id="excerpt" required placeholder="Short summary shown on listing pages...">{{ old('excerpt') }}</textarea>
                    @if($errors->has('excerpt'))
                        <div class="invalid-feedback">
                            {{ $errors->first('excerpt') }}
                        </div>
                    @endif
                    <span class="help-block amtex-premium-bpostform-help">{{ trans('cruds.blogPost.fields.excerpt_helper') }}</span>
                </div>

                {{-- Content --}}
                <div class="form-group amtex-premium-bpostform-field amtex-premium-bpostform-field--full">
                    <label class="amtex-premium-bpostform-label" for="content">{{ trans('cruds.blogPost.fields.content') }}</label>
                    <textarea class="form-control ckeditor amtex-premium-bpostform-ckeditor {{ $errors->has('content') ? 'is-invalid' : '' }}" name="content" id="content">{!! old('content') !!}</textarea>
                    @if($errors->has('content'))
                        <div class="invalid-feedback">
                            {{ $errors->first('content') }}
                        </div>
                    @endif
                    <span class="help-block amtex-premium-bpostform-help">{{ trans('cruds.blogPost.fields.content_helper') }}</span>

                    <div class="amtex-premium-bpostform-inlinehint">
                        Read Time is auto-calculated from Content (and Excerpt as fallback).
                    </div>
                </div>

                {{-- Featured Image --}}
                <div class="form-group amtex-premium-bpostform-field amtex-premium-bpostform-field--full">
                    <label class="required amtex-premium-bpostform-label" for="featured_image">{{ trans('cruds.blogPost.fields.featured_image') }}</label>
                    <div class="needsclick dropzone amtex-premium-bpostform-dropzone {{ $errors->has('featured_image') ? 'is-invalid' : '' }}" id="featured_image-dropzone"></div>
                    @if($errors->has('featured_image'))
                        <div class="invalid-feedback">
                            {{ $errors->first('featured_image') }}
                        </div>
                    @endif
                    <span class="help-block amtex-premium-bpostform-help">{{ trans('cruds.blogPost.fields.featured_image_helper') }}</span>
                </div>

                {{-- Read Time --}}
                <div class="form-group amtex-premium-bpostform-field">
                    <label class="required amtex-premium-bpostform-label" for="read_time">{{ trans('cruds.blogPost.fields.read_time') }}</label>

                    <div class="amtex-premium-bpostform-readwrap">
                        <input class="form-control amtex-premium-bpostform-input {{ $errors->has('read_time') ? 'is-invalid' : '' }}" type="text" name="read_time" id="read_time" value="{{ old('read_time', '') }}" required placeholder="e.g. 5 min read">
                        <button type="button" class="btn btn-light amtex-premium-bpostform-slugbtn" id="amtexBpostReadRecalc" title="Recalculate read time">
                            <i class="far fa-clock"></i>
                        </button>
                    </div>

                    @if($errors->has('read_time'))
                        <div class="invalid-feedback">
                            {{ $errors->first('read_time') }}
                        </div>
                    @endif
                    <span class="help-block amtex-premium-bpostform-help">{{ trans('cruds.blogPost.fields.read_time_helper') }}</span>
                </div>

                {{-- Published At --}}
                <div class="form-group amtex-premium-bpostform-field">
                    <label class="amtex-premium-bpostform-label" for="published_at">{{ trans('cruds.blogPost.fields.published_at') }}</label>

                    <div class="amtex-premium-bpostform-pubwrap">
                        <input class="form-control amtex-premium-bpostform-input {{ $errors->has('published_at') ? 'is-invalid' : '' }}" type="text" name="published_at" id="published_at" value="{{ old('published_at', '') }}" placeholder="auto-set when published">
                        <button type="button" class="btn btn-light amtex-premium-bpostform-slugbtn" id="amtexBpostSetNow" title="Set publish date to now">
                            <i class="far fa-calendar-check"></i>
                        </button>
                    </div>

                    @if($errors->has('published_at'))
                        <div class="invalid-feedback">
                            {{ $errors->first('published_at') }}
                        </div>
                    @endif
                    <span class="help-block amtex-premium-bpostform-help">{{ trans('cruds.blogPost.fields.published_at_helper') }}</span>
                </div>

                {{-- Is Published --}}
                <div class="form-group amtex-premium-bpostform-field">
                    <label class="amtex-premium-bpostform-label" for="is_published">{{ trans('cruds.blogPost.fields.is_published') }}</label>
                    <select class="form-control amtex-premium-bpostform-input {{ $errors->has('is_published') ? 'is-invalid' : '' }}" name="is_published" id="is_published">
                        <option value disabled {{ old('is_published', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                        @foreach(App\Models\BlogPost::IS_PUBLISHED_SELECT as $key => $label)
                            <option value="{{ $key }}" {{ old('is_published', 'yes') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('is_published'))
                        <div class="invalid-feedback">
                            {{ $errors->first('is_published') }}
                        </div>
                    @endif
                    <span class="help-block amtex-premium-bpostform-help">{{ trans('cruds.blogPost.fields.is_published_helper') }}</span>

                    <div class="amtex-premium-bpostform-inlinehint">
                        When you set Published = Yes, Published At will be auto-filled with current date & time.
                    </div>
                </div>

            </div>

            {{-- Actions --}}
            <div class="amtex-premium-bpostform-actions">
                <button class="btn btn-danger amtex-premium-bpostform-btn-primary" type="submit">
                    <i class="fas fa-save"></i> {{ trans('global.save') }}
                </button>

                <a href="{{ route('admin.blog-posts.index') }}" class="btn btn-secondary amtex-premium-bpostform-btn-secondary">
                    {{ trans('global.cancel') ?? 'Cancel' }}
                </a>
            </div>

        </form>
    </div>
</div>

@endsection

@section('scripts')
@parent

{{-- CKEditor Upload Adapter + ReadTime/Slug/Publish Auto Logic --}}
<script>
$(document).ready(function () {

    // -------------------------
    // Helpers
    // -------------------------
    const slugify = (str) => {
        return (str || '')
            .toString()
            .trim()
            .toLowerCase()
            .replace(/&/g, ' and ')
            .replace(/['"]/g, '')
            .replace(/[^a-z0-9]+/g, '-')
            .replace(/^-+|-+$/g, '')
            .replace(/-+/g, '-');
    };

    const stripHtml = (html) => {
        return (html || '').toString().replace(/<[^>]*>/g, ' ').replace(/\s+/g, ' ').trim();
    };

    // Reading speed assumption: 200 wpm (industry typical)
    const calcReadTimeLabel = (text) => {
        const clean = (text || '').toString().trim();
        const words = clean ? clean.split(/\s+/).filter(Boolean).length : 0;

        // Minimum 1 minute if any content exists
        const minutes = words === 0 ? 0 : Math.max(1, Math.ceil(words / 200));
        return minutes === 0 ? '' : `${minutes} min read`;
    };

    const nowYmdHis = () => {
        // Matches common Laravel datetime string expectations: YYYY-MM-DD HH:mm:ss
        const d = new Date();
        const pad = (n) => String(n).padStart(2, '0');

        const yyyy = d.getFullYear();
        const mm = pad(d.getMonth() + 1);
        const dd = pad(d.getDate());
        const hh = pad(d.getHours());
        const mi = pad(d.getMinutes());
        const ss = pad(d.getSeconds());

        return `${yyyy}-${mm}-${dd} ${hh}:${mi}:${ss}`;
    };

    // Published classifier based on selected option text/value
    const isPublishedChoice = () => {
        const el = document.getElementById('is_published');
        if (!el) return false;

        const value = (el.value || '').toString().trim().toLowerCase();
        const text = (el.options[el.selectedIndex]?.text || '').toString().trim().toLowerCase();

        const pubSet = new Set(['yes','published','true','1','on','live']);
        const unpubSet = new Set(['no','unpublished','false','0','off','draft']);

        if (pubSet.has(value) || pubSet.has(text)) return true;
        if (unpubSet.has(value) || unpubSet.has(text)) return false;

        // Safe phrase checks
        if (text.includes('unpublish') || text.includes('draft') || text.includes('disable')) return false;
        if (text.includes('publish') || text.includes('enable') || text.includes('live')) return true;

        return false;
    };

    // -------------------------
    // Slug Auto-fill
    // -------------------------
    const titleEl = document.getElementById('title');
    const slugEl = document.getElementById('slug');
    const slugBtn = document.getElementById('amtexBpostSlugRegenerate');

    let slugTouched = !!(slugEl && slugEl.value.trim());

    if (slugEl) {
        slugEl.addEventListener('input', function () {
            slugTouched = !!slugEl.value.trim();
        });
    }

    if (titleEl && slugEl) {
        titleEl.addEventListener('input', function () {
            if (!slugTouched) {
                slugEl.value = slugify(titleEl.value);
            }
        });

        if (!slugEl.value.trim() && titleEl.value.trim()) {
            slugEl.value = slugify(titleEl.value);
        }
    }

    if (slugBtn && titleEl && slugEl) {
        slugBtn.addEventListener('click', function () {
            slugEl.value = slugify(titleEl.value);
            slugTouched = true;
        });
    }

    // -------------------------
    // Read Time Auto-fill
    // -------------------------
    const readEl = document.getElementById('read_time');
    const excerptEl = document.getElementById('excerpt');
    const readBtn = document.getElementById('amtexBpostReadRecalc');

    // Only auto-fill if user hasn't manually typed read_time
    let readTouched = !!(readEl && readEl.value.trim());
    if (readEl) {
        readEl.addEventListener('input', function () {
            readTouched = !!readEl.value.trim();
        });
    }

    const updateReadTimeFromText = (text) => {
        if (!readEl) return;
        if (readTouched) return;

        const label = calcReadTimeLabel(text);
        if (label) readEl.value = label;
    };

    if (readBtn) {
        readBtn.addEventListener('click', function () {
            // force recalc and set as touched
            const contentText = window.__amtexBpostContentText || '';
            const excerptText = excerptEl ? excerptEl.value : '';
            const combined = `${excerptText} ${contentText}`.trim();
            const label = calcReadTimeLabel(combined);
            if (readEl) readEl.value = label || '';
            readTouched = true;
        });
    }

    if (excerptEl) {
        excerptEl.addEventListener('input', function () {
            const contentText = window.__amtexBpostContentText || '';
            const combined = `${excerptEl.value} ${contentText}`.trim();
            updateReadTimeFromText(combined);
        });
    }

    // -------------------------
    // Published At Auto-fill
    // -------------------------
    const pubAtEl = document.getElementById('published_at');
    const pubNowBtn = document.getElementById('amtexBpostSetNow');
    const pubSel = document.getElementById('is_published');

    let pubAtTouched = !!(pubAtEl && pubAtEl.value.trim());
    if (pubAtEl) {
        pubAtEl.addEventListener('input', function () {
            pubAtTouched = !!pubAtEl.value.trim();
        });
    }

    const ensurePublishedAt = () => {
        if (!pubAtEl) return;

        const published = isPublishedChoice();

        // If user set published and published_at is empty => auto fill now
        if (published) {
            if (!pubAtEl.value.trim() && !pubAtTouched) {
                pubAtEl.value = nowYmdHis();
            }
        } else {
            // If not published, and user did not touch published_at, keep it empty
            if (!pubAtTouched) {
                pubAtEl.value = '';
            }
        }
    };

    if (pubSel) {
        pubSel.addEventListener('change', function () {
            ensurePublishedAt();
        });

        // apply on load
        ensurePublishedAt();
    }

    if (pubNowBtn && pubAtEl) {
        pubNowBtn.addEventListener('click', function () {
            pubAtEl.value = nowYmdHis();
            pubAtTouched = true;
        });
    }

    // -------------------------
    // CKEditor Upload Adapter + hook content changes for read time
    // -------------------------
    function SimpleUploadAdapter(editor) {
        editor.plugins.get('FileRepository').createUploadAdapter = function(loader) {
            return {
                upload: function() {
                    return loader.file.then(function (file) {
                        return new Promise(function(resolve, reject) {
                            var xhr = new XMLHttpRequest();
                            xhr.open('POST', '{{ route('admin.blog-posts.storeCKEditorImages') }}', true);
                            xhr.setRequestHeader('x-csrf-token', window._token);
                            xhr.setRequestHeader('Accept', 'application/json');
                            xhr.responseType = 'json';

                            var genericErrorText = `Couldn't upload file: ${ file.name }.`;
                            xhr.addEventListener('error', function() { reject(genericErrorText) });
                            xhr.addEventListener('abort', function() { reject() });
                            xhr.addEventListener('load', function() {
                                var response = xhr.response;

                                if (!response || xhr.status !== 201) {
                                    return reject(response && response.message ? `${genericErrorText}\n${xhr.status} ${response.message}` : `${genericErrorText}\n ${xhr.status} ${xhr.statusText}`);
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
                            data.append('crud_id', '0');
                            xhr.send(data);
                        });
                    })
                }
            };
        }
    }

    var allEditors = document.querySelectorAll('.ckeditor');
    for (var i = 0; i < allEditors.length; ++i) {
        ClassicEditor.create(allEditors[i], { extraPlugins: [SimpleUploadAdapter] })
            .then(function(editor) {
                // Store latest plain text for read time
                const syncContentText = () => {
                    const html = editor.getData();
                    const text = stripHtml(html);
                    window.__amtexBpostContentText = text;

                    const excerptText = excerptEl ? excerptEl.value : '';
                    const combined = `${excerptText} ${text}`.trim();
                    updateReadTimeFromText(combined);
                };

                syncContentText();
                editor.model.document.on('change:data', function() {
                    syncContentText();
                });
            })
            .catch(function(error){
                console.error(error);
            });
    }

});
</script>

{{-- Dropzone --}}
<script>
Dropzone.options.featuredImageDropzone = {
    url: '{{ route('admin.blog-posts.storeMedia') }}',
    maxFilesize: 10, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    maxFiles: 1,
    addRemoveLinks: true,
    headers: { 'X-CSRF-TOKEN': "{{ csrf_token() }}" },
    params: { size: 10, width: 4096, height: 4096 },
    success: function (file, response) {
        $('form').find('input[name="featured_image"]').remove()
        $('form').append('<input type="hidden" name="featured_image" value="' + response.name + '">')
    },
    removedfile: function (file) {
        file.previewElement.remove()
        if (file.status !== 'error') {
            $('form').find('input[name="featured_image"]').remove()
            this.options.maxFiles = this.options.maxFiles + 1
        }
    },
    init: function () {
        // create page -> no prefill needed
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
@endsection
