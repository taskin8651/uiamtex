@extends('layouts.admin')
@section('content')

@php
  $productName = $productVariant->select_product->name ?? '—';
  $isDefaultText = App\Models\ProductVariant::IS_DEFAULT_SELECT[$productVariant->is_default] ?? '—';

  $price = $productVariant->price ?? '';
  $compare = $productVariant->compare_price ?? '';
  $stock = $productVariant->stock_qty ?? '';

  $hasDiscount = ($compare !== '' && $price !== '' && floatval($compare) > floatval($price));
@endphp

<div class="amtex-pvs-page">

  {{-- Header --}}
  <div class="amtex-pvs-header">
    <div>
      <div class="amtex-pvs-kicker">
        <span class="amtex-pvs-kdot"></span>
        Variant Details
      </div>
      <h2 class="amtex-pvs-title">{{ trans('global.show') }} {{ trans('cruds.productVariant.title_singular') }}</h2>
      <p class="amtex-pvs-subtitle">View complete information for this product variant in a clean, premium layout.</p>
    </div>

    <div class="amtex-pvs-actions">
      <a class="btn amtex-pvs-btn amtex-pvs-btn-light" href="{{ route('admin.product-variants.index') }}">
        <i class="fas fa-arrow-left"></i> Back
      </a>

      @can('product_variant_edit')
        <a class="btn amtex-pvs-btn amtex-pvs-btn-primary" href="{{ route('admin.product-variants.edit', $productVariant->id) }}">
          <i class="fas fa-pen"></i> Edit
        </a>
      @endcan
    </div>
  </div>

  {{-- Top Summary --}}
  <div class="amtex-pvs-top">
    <div class="amtex-pvs-card amtex-pvs-hero">
      <div class="amtex-pvs-hero-left">
        <div class="amtex-pvs-hero-title">
          {{ $productName }}
        </div>

        <div class="amtex-pvs-hero-sub">
          SKU: <span class="amtex-pvs-mono">{{ $productVariant->sku ?? '—' }}</span>
        </div>

        <div class="amtex-pvs-badges">
          <span class="amtex-pvs-badge amtex-pvs-badge-soft">#{{ $productVariant->id ?? '—' }}</span>

          @if(strtolower($isDefaultText) === 'yes')
            <span class="amtex-pvs-badge amtex-pvs-badge-default">
              <i class="fas fa-star"></i> Default
            </span>
          @else
            <span class="amtex-pvs-badge amtex-pvs-badge-muted">
              Not Default
            </span>
          @endif

          @php
            $stockNum = is_numeric($stock) ? intval($stock) : null;
          @endphp

          @if($stockNum === null)
            <span class="amtex-pvs-badge amtex-pvs-badge-muted">Stock: —</span>
          @elseif($stockNum <= 0)
            <span class="amtex-pvs-badge amtex-pvs-badge-out"><i class="fas fa-xmark"></i> Out of Stock</span>
          @elseif($stockNum <= 5)
            <span class="amtex-pvs-badge amtex-pvs-badge-low"><i class="fas fa-triangle-exclamation"></i> Low Stock</span>
          @else
            <span class="amtex-pvs-badge amtex-pvs-badge-in"><i class="fas fa-check"></i> In Stock</span>
          @endif
        </div>
      </div>

      <div class="amtex-pvs-hero-right">
        <div class="amtex-pvs-pricebox">
          <div class="amtex-pvs-price-label">Price</div>
          <div class="amtex-pvs-price-main">₹{{ $price !== '' ? $price : '—' }}</div>

          <div class="amtex-pvs-price-row">
            <div class="amtex-pvs-price-compare {{ $hasDiscount ? 'amtex-pvs-price-compare-cut' : '' }}">
              ₹{{ $compare !== '' ? $compare : '—' }}
            </div>

            @if($hasDiscount)
              @php
                $off = 0;
                if(floatval($compare) > 0){
                  $off = round((1 - (floatval($price)/floatval($compare))) * 100);
                }
              @endphp
              <div class="amtex-pvs-off">-{{ $off }}%</div>
            @endif
          </div>

          <div class="amtex-pvs-price-meta">
            Stock: <strong>{{ $stock !== '' ? $stock : '—' }}</strong>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- Details Grid --}}
  <div class="amtex-pvs-grid">

    <div class="amtex-pvs-card">
      <div class="amtex-pvs-cardhead">
        <h4>Variant Labels</h4>
        <p>What users see in the catalog for this variant.</p>
      </div>

      <div class="amtex-pvs-kv">
        <div class="amtex-pvs-kv-row">
          <div class="amtex-pvs-kv-key">{{ trans('cruds.productVariant.fields.capacity_label') }}</div>
          <div class="amtex-pvs-kv-val">{{ $productVariant->capacity_label ?? '—' }}</div>
        </div>

        <div class="amtex-pvs-kv-row">
          <div class="amtex-pvs-kv-key">{{ trans('cruds.productVariant.fields.finish_label') }}</div>
          <div class="amtex-pvs-kv-val">{{ $productVariant->finish_label ?? '—' }}</div>
        </div>
      </div>
    </div>

    <div class="amtex-pvs-card">
      <div class="amtex-pvs-cardhead">
        <h4>Inventory & Defaults</h4>
        <p>Stock level and default variant flag.</p>
      </div>

      <div class="amtex-pvs-kv">
        <div class="amtex-pvs-kv-row">
          <div class="amtex-pvs-kv-key">{{ trans('cruds.productVariant.fields.stock_qty') }}</div>
          <div class="amtex-pvs-kv-val">{{ $productVariant->stock_qty ?? '—' }}</div>
        </div>

        <div class="amtex-pvs-kv-row">
          <div class="amtex-pvs-kv-key">{{ trans('cruds.productVariant.fields.is_default') }}</div>
          <div class="amtex-pvs-kv-val">
            @if(strtolower($isDefaultText) === 'yes')
              <span class="amtex-pvs-pill amtex-pvs-pill-yes"><i class="fas fa-star"></i> Yes</span>
            @else
              <span class="amtex-pvs-pill amtex-pvs-pill-no">No</span>
            @endif
          </div>
        </div>
      </div>
    </div>

    <div class="amtex-pvs-card">
      <div class="amtex-pvs-cardhead">
        <h4>Identifiers</h4>
        <p>SKU and internal references.</p>
      </div>

      <div class="amtex-pvs-kv">
        <div class="amtex-pvs-kv-row">
          <div class="amtex-pvs-kv-key">{{ trans('cruds.productVariant.fields.id') }}</div>
          <div class="amtex-pvs-kv-val">#{{ $productVariant->id ?? '—' }}</div>
        </div>

        <div class="amtex-pvs-kv-row">
          <div class="amtex-pvs-kv-key">{{ trans('cruds.productVariant.fields.sku') }}</div>
          <div class="amtex-pvs-kv-val amtex-pvs-mono">{{ $productVariant->sku ?? '—' }}</div>
        </div>

        <div class="amtex-pvs-kv-row">
          <div class="amtex-pvs-kv-key">{{ trans('cruds.productVariant.fields.select_product') }}</div>
          <div class="amtex-pvs-kv-val">{{ $productName }}</div>
        </div>
      </div>
    </div>

  </div>

  {{-- Footer --}}
  <div class="amtex-pvs-footer">
    <a class="btn amtex-pvs-btn amtex-pvs-btn-light" href="{{ route('admin.product-variants.index') }}">
      <i class="fas fa-arrow-left"></i> Back to list
    </a>

    @can('product_variant_edit')
      <a class="btn amtex-pvs-btn amtex-pvs-btn-primary" href="{{ route('admin.product-variants.edit', $productVariant->id) }}">
        <i class="fas fa-pen"></i> Edit Variant
      </a>
    @endcan
  </div>

</div>

@endsection
