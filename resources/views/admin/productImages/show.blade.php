@extends('layouts.admin')
@section('content')

<div class="amtex-pimgv-page">

  {{-- Header --}}
  <div class="amtex-pimgv-header">
    <div>
      <h2 class="amtex-pimgv-title">{{ trans('global.show') }} {{ trans('cruds.productImage.title_singular') }}</h2>
      <p class="amtex-pimgv-subtitle">View product gallery details and images in a clean, premium layout.</p>
    </div>

    <div class="amtex-pimgv-actions">
      <a href="{{ route('admin.product-images.index') }}" class="btn amtex-pimgv-btn amtex-pimgv-btn-light">
        <i class="fas fa-arrow-left"></i> Back
      </a>

      @can('product_image_edit')
        <a href="{{ route('admin.product-images.edit', [$productImage->id]) }}" class="btn amtex-pimgv-btn amtex-pimgv-btn-primary">
          <i class="fas fa-pen"></i> Edit
        </a>
      @endcan
    </div>
  </div>

  <div class="amtex-pimgv-wrap">

    {{-- Left: Details --}}
    <div class="amtex-pimgv-card amtex-pimgv-details">

      <div class="amtex-pimgv-section">
        <div class="amtex-pimgv-section-head">
          <h4>Details</h4>
          <span class="amtex-pimgv-chip">Read-only</span>
        </div>

        <div class="amtex-pimgv-kv">
          <div class="amtex-pimgv-kv-row">
            <div class="amtex-pimgv-kv-label">{{ trans('cruds.productImage.fields.id') }}</div>
            <div class="amtex-pimgv-kv-value">#{{ $productImage->id }}</div>
          </div>

          <div class="amtex-pimgv-kv-row">
            <div class="amtex-pimgv-kv-label">{{ trans('cruds.productImage.fields.select_product') }}</div>
            <div class="amtex-pimgv-kv-value">
              {{ $productImage->select_product->name ?? '—' }}
            </div>
          </div>

          <div class="amtex-pimgv-kv-row">
            <div class="amtex-pimgv-kv-label">Total Images</div>
            <div class="amtex-pimgv-kv-value">
              <span class="amtex-pimgv-badge">
                <i class="fas fa-images"></i>
                {{ $productImage->image ? $productImage->image->count() : 0 }}
              </span>
            </div>
          </div>
        </div>
      </div>

      <div class="amtex-pimgv-footer">
        <a href="{{ route('admin.product-images.index') }}" class="btn amtex-pimgv-btn amtex-pimgv-btn-light">
          {{ trans('global.back_to_list') }}
        </a>
      </div>

    </div>

    {{-- Right: Gallery --}}
    <div class="amtex-pimgv-card amtex-pimgv-gallery">

      <div class="amtex-pimgv-section-head">
        <h4>{{ trans('cruds.productImage.fields.image') }}</h4>
        <span class="amtex-pimgv-chip amtex-pimgv-chip-alt">Gallery</span>
      </div>

      @if($productImage->image && $productImage->image->count())
        <div class="amtex-pimgv-grid">
          @foreach($productImage->image as $key => $media)
            <a class="amtex-pimgv-thumb" href="{{ $media->getUrl() }}" target="_blank" title="Open image">
              <img src="{{ $media->getUrl('thumb') }}" alt="Image {{ $key + 1 }}" loading="lazy">
              <span class="amtex-pimgv-thumb-cap">#{{ $key + 1 }}</span>
            </a>
          @endforeach
        </div>

        <div class="amtex-pimgv-hint">
          <i class="fas fa-up-right-from-square"></i>
          Click any image to open the full version in a new tab.
        </div>
      @else
        <div class="amtex-pimgv-empty">
          <div class="amtex-pimgv-empty-card">
            <h3>No images uploaded</h3>
            <p>This product image record doesn’t have any gallery images yet.</p>

            @can('product_image_edit')
              <a href="{{ route('admin.product-images.edit', [$productImage->id]) }}" class="btn amtex-pimgv-btn amtex-pimgv-btn-primary">
                <i class="fas fa-upload"></i> Upload Images
              </a>
            @endcan
          </div>
        </div>
      @endif

    </div>

  </div>
</div>

@endsection
