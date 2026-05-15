@extends('layouts.admin')
@section('content')

<div class="amtex-pimgf-page">

  {{-- Header --}}
  <div class="amtex-pimgf-header">
    <div>
      <h2 class="amtex-pimgf-title">{{ trans('global.edit') }} {{ trans('cruds.productImage.title_singular') }}</h2>
      <p class="amtex-pimgf-subtitle">Update product gallery images with a clean, premium workflow.</p>
    </div>

    <div class="amtex-pimgf-actions">
      <a href="{{ route('admin.product-images.index') }}" class="btn amtex-pimgf-btn amtex-pimgf-btn-light">
        <i class="fas fa-arrow-left"></i> Back
      </a>
    </div>
  </div>

  <div class="amtex-pimgf-wrap">

    {{-- Form Card --}}
    <div class="amtex-pimgf-card">
      <form method="POST" action="{{ route('admin.product-images.update', [$productImage->id]) }}" enctype="multipart/form-data" class="amtex-pimgf-form">
        @method('PUT')
        @csrf

        {{-- Section: Product --}}
        <div class="amtex-pimgf-section">
          <div class="amtex-pimgf-section-head">
            <h4>Product Selection</h4>
            <span class="amtex-pimgf-chip">Required</span>
          </div>

          <div class="amtex-pimgf-grid">
            <div class="amtex-pimgf-field amtex-pimgf-span2">
              <label class="amtex-pimgf-label required" for="select_product_id">{{ trans('cruds.productImage.fields.select_product') }}</label>

              <select
                class="form-control select2 amtex-pimgf-control {{ $errors->has('select_product') ? 'is-invalid' : '' }}"
                name="select_product_id"
                id="select_product_id"
                required
              >
                @foreach($select_products as $id => $entry)
                  <option value="{{ $id }}"
                    {{ (old('select_product_id') ? old('select_product_id') : ($productImage->select_product->id ?? '')) == $id ? 'selected' : '' }}>
                    {{ $entry }}
                  </option>
                @endforeach
              </select>

              @if($errors->has('select_product'))
                <div class="invalid-feedback">{{ $errors->first('select_product') }}</div>
              @endif

              <small class="amtex-pimgf-help">{{ trans('cruds.productImage.fields.select_product_helper') }}</small>

              <div class="amtex-pimgf-inlinehint">
                <i class="fas fa-info-circle"></i>
                Changing the product here will re-attach this image set to the selected product.
              </div>
            </div>
          </div>
        </div>

        {{-- Section: Images --}}
        <div class="amtex-pimgf-section">
          <div class="amtex-pimgf-section-head">
            <h4>Gallery Images</h4>
            <span class="amtex-pimgf-chip amtex-pimgf-chip-alt">Multiple</span>
          </div>

          <div class="amtex-pimgf-grid">
            <div class="amtex-pimgf-field amtex-pimgf-span2">
              <label class="amtex-pimgf-label required" for="image">{{ trans('cruds.productImage.fields.image') }}</label>

              <div class="amtex-pimgf-dropwrap {{ $errors->has('image') ? 'amtex-pimgf-dropwrap-error' : '' }}">
                <div class="needsclick dropzone amtex-pimgf-dropzone" id="image-dropzone"></div>

                <div class="amtex-pimgf-dropnote">
                  <div class="amtex-pimgf-dropnote-title">
                    <i class="fas fa-cloud-upload-alt"></i> Upload / Replace Gallery Images
                  </div>
                  <div class="amtex-pimgf-dropnote-sub">
                    JPG/PNG/GIF • Max 10MB each • Multiple images allowed
                  </div>
                </div>
              </div>

              @if($errors->has('image'))
                <div class="amtex-pimgf-error">{{ $errors->first('image') }}</div>
              @endif

              <small class="amtex-pimgf-help">{{ trans('cruds.productImage.fields.image_helper') }}</small>

              <div class="amtex-pimgf-tipbar">
                <div class="amtex-pimgf-tip">
                  <i class="fas fa-bolt"></i>
                  Tip: Keep 4–8 images per product for best UX (cover + angles + closeups).
                </div>
                <div class="amtex-pimgf-count">
                  <span class="amtex-pimgf-badge">
                    <i class="fas fa-images"></i> Selected: <span id="amtexPimgfCount">0</span>
                  </span>
                </div>
              </div>

            </div>
          </div>
        </div>

        {{-- Footer actions --}}
        <div class="amtex-pimgf-footer">
          <a href="{{ route('admin.product-images.index') }}" class="btn amtex-pimgf-btn amtex-pimgf-btn-light">
            Cancel
          </a>

          <button class="btn amtex-pimgf-btn amtex-pimgf-btn-primary" type="submit">
            <i class="fas fa-save"></i> {{ trans('global.save') }}
          </button>
        </div>

      </form>
    </div>

    {{-- Preview Card --}}
    <div class="amtex-pimgf-side">
      <div class="amtex-pimgf-card amtex-pimgf-preview">
        <div class="amtex-pimgf-preview-head">
          <h4>Quick Preview</h4>
          <span class="amtex-pimgf-chip">Live</span>
        </div>

        <div class="amtex-pimgf-preview-box">
          <div class="amtex-pimgf-preview-label">Selected Product</div>
          <div class="amtex-pimgf-preview-value" id="amtexPimgfProduct">—</div>
        </div>

        <div class="amtex-pimgf-preview-gallery" id="amtexPimgfGallery">
          <div class="amtex-pimgf-preview-muted">
            Image previews will appear here after upload.
          </div>
        </div>

        <div class="amtex-pimgf-muted">
          Existing images are loaded here automatically. Removing a file will remove it from this set.
        </div>
      </div>
    </div>

  </div>
</div>

@endsection

@section('scripts')
<script>
  // -------------------------------
  // Product preview
  // -------------------------------
  function amtexPimgfUpdateProductPreview(){
    const text = $('#select_product_id option:selected').text() || '—';
    $('#amtexPimgfProduct').text(text);
  }
  $(document).ready(function(){
    amtexPimgfUpdateProductPreview();
  });
  $(document).on('change', '#select_product_id', amtexPimgfUpdateProductPreview);

  // -------------------------------
  // Dropzone (Multiple images) + Preview gallery + Count
  // -------------------------------
  var uploadedImageMap = {};

  function amtexPimgfUpdateCount(){
    const count = $('form').find('input[name="image[]"]').length;
    $('#amtexPimgfCount').text(count);
  }

  function amtexPimgfEnsureGalleryNotEmpty(){
    const wrap = $('#amtexPimgfGallery');
    const hasThumb = wrap.find('.amtex-pimgf-prevthumb').length > 0;
    if (!hasThumb) {
      wrap.html('<div class="amtex-pimgf-preview-muted">Image previews will appear here after upload.</div>');
    }
  }

  function amtexPimgfAddPreviewThumb(src){
    if(!src) return;

    const wrap = $('#amtexPimgfGallery');

    // Replace empty message on first thumb
    if (wrap.find('.amtex-pimgf-preview-muted').length) {
      wrap.html('');
    }

    const html = `
      <a class="amtex-pimgf-prevthumb" href="${src}" target="_blank" title="Open image">
        <img src="${src}" alt="Preview" loading="lazy" />
      </a>
    `;
    wrap.append(html);
  }

  Dropzone.options.imageDropzone = {
    url: '{{ route('admin.product-images.storeMedia') }}',
    maxFilesize: 10, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    addRemoveLinks: true,
    headers: { 'X-CSRF-TOKEN': "{{ csrf_token() }}" },
    params: { size: 10, width: 4096, height: 4096 },

    success: function (file, response) {
      $('form').append('<input type="hidden" name="image[]" value="' + response.name + '">');
      uploadedImageMap[file.name] = response.name;

      // preview from local dataURL
      if (file && file.dataURL) {
        amtexPimgfAddPreviewThumb(file.dataURL);
      }

      amtexPimgfUpdateCount();
    },

    removedfile: function (file) {
      if (file.previewElement) file.previewElement.remove();

      var name = '';
      if (typeof file.file_name !== 'undefined') {
        name = file.file_name;
      } else {
        name = uploadedImageMap[file.name];
      }

      $('form').find('input[name="image[]"][value="' + name + '"]').remove();

      // Also try to remove one preview thumb (best-effort)
      // If file had dataURL, remove that matching thumb
      if (file && file.dataURL) {
        $('#amtexPimgfGallery a[href="' + file.dataURL + '"]').remove();
      }

      amtexPimgfUpdateCount();
      amtexPimgfEnsureGalleryNotEmpty();
    },

    init: function () {
      amtexPimgfUpdateCount();

      // Load existing files (Edit)
@if(isset($productImage) && $productImage->image)
      var files = {!! json_encode($productImage->image) !!};
      for (var i in files) {
        var file = files[i];

        // Add to dropzone
        this.options.addedfile.call(this, file);

        // Use preview or thumb url if present
        var thumb = file.preview ?? file.preview_url ?? null;
        if (thumb) {
          this.options.thumbnail.call(this, file, thumb);
        }

        file.previewElement.classList.add('dz-complete');

        // Keep hidden inputs aligned with existing media
        $('form').append('<input type="hidden" name="image[]" value="' + file.file_name + '">');

        // Add to right-side preview gallery
        if (thumb) {
          amtexPimgfAddPreviewThumb(thumb);
        }
      }
      amtexPimgfUpdateCount();
      amtexPimgfEnsureGalleryNotEmpty();
@endif
    },

    error: function (file, response) {
      let message = ($.type(response) === 'string') ? response : (response.errors?.file || 'Upload failed');
      file.previewElement.classList.add('dz-error');
      let _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]');
      for (let i = 0; i < _ref.length; i++) {
        _ref[i].textContent = message;
      }
    }
  };
</script>
@endsection
