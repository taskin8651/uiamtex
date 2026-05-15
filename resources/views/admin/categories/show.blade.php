@extends('layouts.admin')
@section('content')

<div class="amtex-cats-page">

  {{-- Header --}}
  <div class="amtex-cats-header">
    <div class="amtex-cats-header-left">
      <div class="amtex-cats-kicker">
        <span class="amtex-cats-kdot"></span>
        Catalog
      </div>
      <h2 class="amtex-cats-title">{{ trans('global.show') }} {{ trans('cruds.category.title_singular') }}</h2>
      <p class="amtex-cats-subtitle">View category details, image, ordering and status in a clean layout.</p>
    </div>

    <div class="amtex-cats-actions">
      <a class="btn amtex-cats-btn amtex-cats-btn-light" href="{{ route('admin.categories.index') }}">
        <i class="fas fa-arrow-left"></i> {{ trans('global.back_to_list') }}
      </a>

      @can('category_edit')
        <a class="btn amtex-cats-btn amtex-cats-btn-primary" href="{{ route('admin.categories.edit', $category->id) }}">
          <i class="fas fa-pen"></i> {{ trans('global.edit') }}
        </a>
      @endcan
    </div>
  </div>

  <div class="amtex-cats-wrap">

    {{-- Left: Details --}}
    <div class="amtex-cats-card">
      <div class="amtex-cats-card-head">
        <div class="amtex-cats-card-title">
          <div class="amtex-cats-ico"><i class="fas fa-layer-group"></i></div>
          <div>
            <h4 class="amtex-cats-h4">Category Details</h4>
            <div class="amtex-cats-hint">Core identity fields for this category.</div>
          </div>
        </div>

        <div class="amtex-cats-badges">
          @php
            $isActive = (string)($category->is_active ?? '') === '1';
            $statusText = $isActive ? 'Active' : 'Inactive';
          @endphp

          <span class="amtex-cats-badge {{ $isActive ? 'amtex-cats-badge-on' : 'amtex-cats-badge-off' }}">
            {{ $statusText }}
          </span>
          <span class="amtex-cats-badge amtex-cats-badge-soft">#{{ $category->id }}</span>
        </div>
      </div>

      <div class="amtex-cats-table">
        <div class="amtex-cats-row">
          <div class="amtex-cats-label">{{ trans('cruds.category.fields.id') }}</div>
          <div class="amtex-cats-value">{{ $category->id }}</div>
        </div>

        <div class="amtex-cats-row">
          <div class="amtex-cats-label">{{ trans('cruds.category.fields.name') }}</div>
          <div class="amtex-cats-value">
            <span class="amtex-cats-strong">{{ $category->name }}</span>
          </div>
        </div>

        <div class="amtex-cats-row">
          <div class="amtex-cats-label">{{ trans('cruds.category.fields.slug') }}</div>
          <div class="amtex-cats-value">
            <span class="amtex-cats-code">{{ $category->slug }}</span>
          </div>
        </div>

        <div class="amtex-cats-row">
          <div class="amtex-cats-label">{{ trans('cruds.category.fields.sort_order') }}</div>
          <div class="amtex-cats-value">
            {{ $category->sort_order ?? '—' }}
          </div>
        </div>

        <div class="amtex-cats-row">
          <div class="amtex-cats-label">{{ trans('cruds.category.fields.is_active') }}</div>
          <div class="amtex-cats-value">
            {{ App\Models\Category::IS_ACTIVE_SELECT[$category->is_active] ?? '' }}
          </div>
        </div>
      </div>

      <div class="amtex-cats-footer">
        <a class="btn amtex-cats-btn amtex-cats-btn-light" href="{{ route('admin.categories.index') }}">
          <i class="fas fa-arrow-left"></i> {{ trans('global.back_to_list') }}
        </a>

        @can('category_edit')
          <a class="btn amtex-cats-btn amtex-cats-btn-primary" href="{{ route('admin.categories.edit', $category->id) }}">
            <i class="fas fa-pen"></i> {{ trans('global.edit') }}
          </a>
        @endcan
      </div>
    </div>

    {{-- Right: Image Preview --}}
    <div class="amtex-cats-card amtex-cats-imagecard">
      <div class="amtex-cats-card-head">
        <div class="amtex-cats-card-title">
          <div class="amtex-cats-ico"><i class="fas fa-image"></i></div>
          <div>
            <h4 class="amtex-cats-h4">Category Image</h4>
            <div class="amtex-cats-hint">Used in listings and promotions.</div>
          </div>
        </div>
      </div>

      <div class="amtex-cats-imagebox">
        @if($category->image)
          <a href="{{ $category->image->getUrl() }}" target="_blank" class="amtex-cats-imagelink" title="Open full image">
            <img src="{{ $category->image->getUrl() }}" alt="{{ $category->name }}" loading="lazy">
          </a>
          <div class="amtex-cats-imagemeta">
            <span class="amtex-cats-chip"><i class="fas fa-up-right-from-square"></i> Click image to open</span>
          </div>
        @else
          <div class="amtex-cats-nophoto">
            <div class="amtex-cats-nophoto-ico"><i class="fas fa-image"></i></div>
            <div class="amtex-cats-nophoto-title">No image uploaded</div>
            <div class="amtex-cats-nophoto-sub">You can add one from Edit page.</div>
          </div>
        @endif
      </div>

      @can('category_edit')
        <div class="amtex-cats-imageactions">
          <a class="btn amtex-cats-btn amtex-cats-btn-primary" href="{{ route('admin.categories.edit', $category->id) }}">
            <i class="fas fa-upload"></i> Upload / Replace
          </a>
        </div>
      @endcan
    </div>

  </div>
</div>

@endsection
