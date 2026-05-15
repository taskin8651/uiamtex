@extends('layouts.admin')
@section('content')

<div class="amtex-catf-page">

  {{-- Header --}}
  <div class="amtex-catf-header">
    <div class="amtex-catf-header-left">
      <div class="amtex-catf-kicker">
        <span class="amtex-catf-kdot"></span>
        Catalog
      </div>
      <h2 class="amtex-catf-title">{{ trans('global.create') }} {{ trans('cruds.category.title_singular') }}</h2>
      <p class="amtex-catf-subtitle">Create a category with clean naming, image, ordering and visibility status.</p>
    </div>

    <div class="amtex-catf-actions">
      <a href="{{ route('admin.categories.index') }}" class="btn amtex-catf-btn amtex-catf-btn-light">
        <i class="fas fa-arrow-left"></i> Back
      </a>
    </div>
  </div>

  <div class="amtex-catf-wrap">

    {{-- Form Card --}}
    <div class="amtex-catf-card">
      <form method="POST" action="{{ route('admin.categories.store') }}" enctype="multipart/form-data" class="amtex-catf-form">
        @csrf

        {{-- Section: Basic Info --}}
        <div class="amtex-catf-section">
          <div class="amtex-catf-section-head">
            <div class="amtex-catf-section-title">
              <div class="amtex-catf-ico">
                <i class="fas fa-pen-nib"></i>
              </div>
              <div>
                <h4 class="amtex-catf-h4">Basic Details</h4>
                <div class="amtex-catf-hint">Name & slug used across listing and URLs.</div>
              </div>
            </div>
            <span class="amtex-catf-chip">Required</span>
          </div>

          <div class="amtex-catf-grid">
            {{-- Name --}}
            <div class="amtex-catf-field">
              <label class="amtex-catf-label required" for="name">{{ trans('cruds.category.fields.name') }}</label>

              <div class="amtex-catf-input">
                <span class="amtex-catf-input-ico"><i class="fas fa-tag"></i></span>
                <input
                  class="form-control amtex-catf-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                  type="text"
                  name="name"
                  id="name"
                  value="{{ old('name', '') }}"
                  placeholder="e.g. Fire Extinguishers"
                  required
                >
              </div>

              @if($errors->has('name'))
                <div class="invalid-feedback d-block">{{ $errors->first('name') }}</div>
              @endif
              <small class="amtex-catf-help">{{ trans('cruds.category.fields.name_helper') }}</small>
            </div>

            {{-- Slug --}}
            <div class="amtex-catf-field">
              <label class="amtex-catf-label required" for="slug">{{ trans('cruds.category.fields.slug') }}</label>

              <div class="amtex-catf-input">
                <span class="amtex-catf-input-ico"><i class="fas fa-link"></i></span>
                <input
                  class="form-control amtex-catf-control {{ $errors->has('slug') ? 'is-invalid' : '' }}"
                  type="text"
                  name="slug"
                  id="slug"
                  value="{{ old('slug', '') }}"
                  placeholder="auto-generated from name"
                  required
                >
                <button type="button" class="amtex-catf-mini" id="amtexCatfRegenerate" title="Regenerate slug from name">
                  <i class="fas fa-sync-alt"></i>
                </button>
              </div>

              @if($errors->has('slug'))
                <div class="invalid-feedback d-block">{{ $errors->first('slug') }}</div>
              @endif
              <small class="amtex-catf-help">{{ trans('cruds.category.fields.slug_helper') }}</small>

              <div class="amtex-catf-inlinehint">
                <i class="fas fa-magic"></i>
                Slug auto-generates from Name. Click refresh to regenerate anytime.
              </div>
            </div>
          </div>
        </div>

        {{-- Section: Media + Settings --}}
        <div class="amtex-catf-section">
          <div class="amtex-catf-section-head">
            <div class="amtex-catf-section-title">
              <div class="amtex-catf-ico">
                <i class="fas fa-image"></i>
              </div>
              <div>
                <h4 class="amtex-catf-h4">Media & Display</h4>
                <div class="amtex-catf-hint">Upload image, set ordering, and status.</div>
              </div>
            </div>
            <span class="amtex-catf-chip amtex-catf-chip-alt">Recommended</span>
          </div>

          <div class="amtex-catf-grid">
            {{-- Image --}}
            <div class="amtex-catf-field amtex-catf-span2">
              <label class="amtex-catf-label" for="image">{{ trans('cruds.category.fields.image') }}</label>

              <div class="amtex-catf-dropwrap {{ $errors->has('image') ? 'amtex-catf-dropwrap-error' : '' }}">
                <div class="needsclick dropzone amtex-catf-dropzone" id="image-dropzone"></div>

                <div class="amtex-catf-dropnote">
                  <div class="amtex-catf-dropnote-title">
                    <i class="fas fa-cloud-upload-alt"></i> Upload Category Image
                  </div>
                  <div class="amtex-catf-dropnote-sub">
                    JPG/PNG/GIF • Max 10MB • 1 image only
                  </div>
                </div>
              </div>

              @if($errors->has('image'))
                <div class="amtex-catf-error">{{ $errors->first('image') }}</div>
              @endif

              <small class="amtex-catf-help">{{ trans('cruds.category.fields.image_helper') }}</small>
            </div>

            {{-- Sort Order --}}
            <div class="amtex-catf-field">
              <label class="amtex-catf-label" for="sort_order">{{ trans('cruds.category.fields.sort_order') }}</label>

              <div class="amtex-catf-input">
                <span class="amtex-catf-input-ico"><i class="fas fa-sort-numeric-up"></i></span>
                <input
                  class="form-control amtex-catf-control {{ $errors->has('sort_order') ? 'is-invalid' : '' }}"
                  type="number"
                  name="sort_order"
                  id="sort_order"
                  value="{{ old('sort_order', '') }}"
                  placeholder="e.g. 1"
                  min="0"
                >
              </div>

              @if($errors->has('sort_order'))
                <div class="invalid-feedback d-block">{{ $errors->first('sort_order') }}</div>
              @endif
              <small class="amtex-catf-help">{{ trans('cruds.category.fields.sort_order_helper') }}</small>

              <div class="amtex-catf-inlinehint">
                <i class="fas fa-info-circle"></i>
                Lower number shows earlier in listing.
              </div>
            </div>

            {{-- Status --}}
            <div class="amtex-catf-field">
              <label class="amtex-catf-label required" for="is_active">{{ trans('cruds.category.fields.is_active') }}</label>

              <div class="amtex-catf-input">
                <span class="amtex-catf-input-ico"><i class="fas fa-toggle-on"></i></span>
                <select
                  class="form-control amtex-catf-control {{ $errors->has('is_active') ? 'is-invalid' : '' }}"
                  name="is_active"
                  id="is_active"
                  required
                >
                  <option value disabled {{ old('is_active', null) === null ? 'selected' : '' }}>
                    {{ trans('global.pleaseSelect') }}
                  </option>
                  @foreach(App\Models\Category::IS_ACTIVE_SELECT as $key => $label)
                    <option value="{{ $key }}" {{ old('is_active', '0') === (string) $key ? 'selected' : '' }}>
                      {{ $label }}
                    </option>
                  @endforeach
                </select>
              </div>

              @if($errors->has('is_active'))
                <div class="invalid-feedback d-block">{{ $errors->first('is_active') }}</div>
              @endif
              <small class="amtex-catf-help">{{ trans('cruds.category.fields.is_active_helper') }}</small>

              <div class="amtex-catf-statushint">
                <span class="amtex-catf-badge amtex-catf-badge-on">Active</span>
                <span class="amtex-catf-badge amtex-catf-badge-off">Inactive</span>
              </div>
            </div>

          </div>
        </div>

        {{-- Footer actions --}}
        <div class="amtex-catf-footer">
          <a href="{{ route('admin.categories.index') }}" class="btn amtex-catf-btn amtex-catf-btn-light">
            Cancel
          </a>

          <button class="btn amtex-catf-btn amtex-catf-btn-primary" type="submit">
            <i class="fas fa-save"></i> {{ trans('global.save') }}
          </button>
        </div>

      </form>
    </div>

    {{-- Preview Card --}}
    <div class="amtex-catf-side">
      <div class="amtex-catf-card amtex-catf-preview">
        <div class="amtex-catf-preview-head">
          <div class="amtex-catf-preview-title">
            <div class="amtex-catf-ico amtex-catf-ico-mini">
              <i class="fas fa-eye"></i>
            </div>
            <h4 class="amtex-catf-h4">Quick Preview</h4>
          </div>
          <span class="amtex-catf-chip">Live</span>
        </div>

        <div class="amtex-catf-preview-box">
          <div class="amtex-catf-preview-label">Name</div>
          <div class="amtex-catf-preview-value" id="amtexCatPrevName">—</div>
        </div>

        <div class="amtex-catf-preview-box">
          <div class="amtex-catf-preview-label">Slug</div>
          <div class="amtex-catf-preview-value" id="amtexCatPrevSlug">—</div>
        </div>

        <div class="amtex-catf-preview-box">
          <div class="amtex-catf-preview-label">Status</div>
          <div class="amtex-catf-preview-value" id="amtexCatPrevStatus">—</div>
        </div>

        <div class="amtex-catf-preview-img" id="amtexCatPrevImg">
          <div class="amtex-catf-preview-imgtext">
            <i class="fas fa-image"></i>
            Image preview will appear after upload
          </div>
        </div>

        <div class="amtex-catf-muted">
          Keep naming consistent across the catalogue for clean URLs and better SEO.
        </div>
      </div>
    </div>

  </div>
</div>

@endsection

@section('scripts')
@parent
<script>
  // -------------------------------
  // Dropzone
  // -------------------------------
  Dropzone.options.imageDropzone = {
    url: '{{ route('admin.categories.storeMedia') }}',
    maxFilesize: 10, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    maxFiles: 1,
    addRemoveLinks: true,
    headers: { 'X-CSRF-TOKEN': "{{ csrf_token() }}" },
    params: { size: 10, width: 4096, height: 4096 },

    success: function (file, response) {
      const $form = $('.amtex-catf-form');
      $form.find('input[name="image"]').remove();
      $form.append('<input type="hidden" name="image" value="' + response.name + '">');

      // Preview image
      if (file && file.dataURL) {
        $('#amtexCatPrevImg').html('<img src="' + file.dataURL + '" alt="Preview" />')
      }
    },

    removedfile: function (file) {
      if (file.previewElement) file.previewElement.remove();
      if (file.status !== 'error') {
        const $form = $('.amtex-catf-form');
        $form.find('input[name="image"]').remove();
        this.options.maxFiles = this.options.maxFiles + 1;
      }
      $('#amtexCatPrevImg').html(
        '<div class="amtex-catf-preview-imgtext"><i class="fas fa-image"></i> Image preview will appear after upload</div>'
      );
    },

    init: function () {},

    error: function (file, response) {
      let message = ($.type(response) === 'string') ? response : (response.errors?.file || 'Upload failed');
      if (file.previewElement) file.previewElement.classList.add('dz-error');
      let _ref = file.previewElement ? file.previewElement.querySelectorAll('[data-dz-errormessage]') : [];
      for (let i = 0; i < _ref.length; i++) {
        _ref[i].textContent = message;
      }
    }
  };

  // -------------------------------
  // Slug auto-generate (Name -> Slug)
  // - live updates
  // - manual override supported
  // -------------------------------
  let amtexSlugManuallyEdited = false;

  function amtexSlugify(text) {
    return (text || '')
      .toString()
      .trim()
      .toLowerCase()
      .replace(/&/g, ' and ')
      .replace(/[^a-z0-9]+/g, '-')
      .replace(/^-+|-+$/g, '')
      .replace(/-{2,}/g, '-');
  }

  function amtexCatUpdatePreview() {
    const name = $('#name').val() || '—';
    const slug = $('#slug').val() || '—';
    const statusVal = $('#is_active').val();
    let statusText = '—';
    if (statusVal === '1') statusText = 'Active';
    if (statusVal === '0') statusText = 'Inactive';

    $('#amtexCatPrevName').text(name);
    $('#amtexCatPrevSlug').text(slug);
    $('#amtexCatPrevStatus').text(statusText);
  }

  // if user edits slug manually, stop auto updates
  $('#slug').on('input', function () {
    amtexSlugManuallyEdited = $(this).val().trim().length > 0;
    amtexCatUpdatePreview();
  });

  // generate slug from name while typing
  $('#name').on('input', function () {
    if (!amtexSlugManuallyEdited) {
      $('#slug').val(amtexSlugify($(this).val()));
    }
    amtexCatUpdatePreview();
  });

  // regenerate button (force overwrite)
  $('#amtexCatfRegenerate').on('click', function () {
    amtexSlugManuallyEdited = false;
    $('#slug').val(amtexSlugify($('#name').val()));
    amtexCatUpdatePreview();
    $('#slug').trigger('focus');
  });

  // if slug cleared, resume auto mode
  $('#slug').on('blur', function () {
    if ($(this).val().trim() === '') {
      amtexSlugManuallyEdited = false;
      $('#slug').val(amtexSlugify($('#name').val()));
      amtexCatUpdatePreview();
    }
  });

  $(document).on('change', '#is_active', amtexCatUpdatePreview);

  // init preview (also handle old values)
  $(document).ready(function () {
    if ($('#slug').val().trim() !== '') {
      amtexSlugManuallyEdited = true; // respect old slug if validation failed
    }
    amtexCatUpdatePreview();
  });
</script>
@endsection
