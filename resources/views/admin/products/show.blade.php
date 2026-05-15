@extends('layouts.admin')
@section('content')

@php
  /**
   * PDP fields can arrive in different shapes:
   * - arrays (casted)
   * - JSON strings
   * - null
   * So we normalize safely.
   */
  $toArray = function ($val) {
    if (is_array($val)) return $val;
    if (is_object($val)) return (array) $val;
    if (is_string($val) && trim($val) !== '') {
      $decoded = json_decode($val, true);
      return is_array($decoded) ? $decoded : [];
    }
    return [];
  };

  $toString = function($val){
    return is_string($val) ? $val : (is_null($val) ? '' : (string)$val);
  };

  $tags          = $toArray($product->pdp_tags ?? null);
  $pointers      = $toArray($product->pdp_pointers ?? null);
  $keyHighlights = $toArray($product->pdp_key_highlights ?? null); // [{icon,title,text}]
  $worksOn       = $toArray($product->pdp_works_on ?? null);       // [{icon,title,text}]

  $recoLeft  = $toArray($product->pdp_recommended_for_left ?? null);
  $recoRight = $toArray($product->pdp_recommended_for_right ?? null);

  $availableSizes    = $toString($product->pdp_available_sizes ?? '');
  $availableVariants = $toString($product->pdp_available_variants ?? '');

  $tech = $toArray($product->pdp_tech_table ?? null);
  // expected: {columns:[], rows:[{parameter:'', values:[]}]}
  $techColumns = $tech['columns'] ?? [];
  $techRows    = $tech['rows'] ?? [];

  // Labels
  $activeLabel   = \App\Models\Product::IS_ACTIVE_SELECT[$product->is_active] ?? '';
  $featuredLabel = \App\Models\Product::IS_FEATURED_SELECT[$product->is_featured] ?? '';
  $badgeLabel    = \App\Models\Product::BADGE_SELECT[$product->badge] ?? '';
@endphp

<div class="amtex-prods-page">

  {{-- Header --}}
  <div class="amtex-prods-header">
    <div class="amtex-prods-header-left">
      <div class="amtex-prods-kicker">
        <span class="amtex-prods-kdot"></span>
        Product Details
      </div>
      <h2 class="amtex-prods-title">{{ $product->name ?? trans('cruds.product.title_singular') }}</h2>
      <p class="amtex-prods-subtitle">
        View complete product information, media, brochure and PDP builder details in a clean premium layout.
      </p>
    </div>

    <div class="amtex-prods-actions">
      <a class="btn amtex-prods-btn amtex-prods-btn-light" href="{{ route('admin.products.index') }}">
        <i class="fas fa-arrow-left"></i> Back
      </a>

      @can('product_edit')
        <a class="btn amtex-prods-btn amtex-prods-btn-primary" href="{{ route('admin.products.edit', $product->id) }}">
          <i class="fas fa-pen"></i> Edit
        </a>
      @endcan
    </div>
  </div>

  <div class="amtex-prods-wrap">

    {{-- Left: Main --}}
    <div class="amtex-prods-main">

      {{-- Top Summary Card --}}
      <div class="amtex-prods-card amtex-prods-summary">
        <div class="amtex-prods-summary-left">

          {{-- Image --}}
          <div class="amtex-prods-media">
            @if($product->main_image)
              <a href="{{ $product->main_image->getUrl() }}" target="_blank" class="amtex-prods-media-link" title="Open full image">
                <img src="{{ $product->main_image->getUrl() }}" alt="{{ $product->name ?? 'Product' }}">
              </a>
            @else
              <div class="amtex-prods-media-fallback">
                <i class="fas fa-image"></i>
                <div>No Image</div>
              </div>
            @endif
          </div>

        </div>

        <div class="amtex-prods-summary-right">
          <div class="amtex-prods-topline">
            <div class="amtex-prods-id">#{{ $product->id }}</div>

            <div class="amtex-prods-pills">
              @if($activeLabel)
                <span class="amtex-prods-pill {{ (strtolower($activeLabel) === 'yes' || strtolower($activeLabel) === 'active') ? 'amtex-prods-pill-active' : 'amtex-prods-pill-inactive' }}">
                  <i class="fas fa-circle"></i> {{ $activeLabel }}
                </span>
              @endif

              @if($featuredLabel)
                <span class="amtex-prods-pill amtex-prods-pill-featured">
                  <i class="fas fa-star"></i> {{ $featuredLabel }}
                </span>
              @endif

              @if($badgeLabel)
                <span class="amtex-prods-pill amtex-prods-pill-badge">
                  <i class="fas fa-bolt"></i> {{ $badgeLabel }}
                </span>
              @endif
            </div>
          </div>

          <div class="amtex-prods-name">{{ $product->name }}</div>
          <div class="amtex-prods-cat">
            <i class="fas fa-layer-group"></i>
            {{ $product->select_category->name ?? '—' }}
          </div>

          @if(!empty($tags))
            <div class="amtex-prods-tags">
              @foreach($tags as $t)
                @if(trim((string)$t) !== '')
                  <span class="amtex-prods-tag">{{ $t }}</span>
                @endif
              @endforeach
            </div>
          @endif

          <div class="amtex-prods-price">
            <div class="amtex-prods-price-main">₹{{ $product->base_price ?? '—' }}</div>
            @if(!empty($product->compare_price))
              <div class="amtex-prods-price-compare">₹{{ $product->compare_price }}</div>
            @endif
          </div>

          <div class="amtex-prods-mini-grid">
            <div class="amtex-prods-mini">
              <div class="amtex-prods-mini-label">SKU</div>
              <div class="amtex-prods-mini-value">{{ $product->sku ?? '—' }}</div>
            </div>

            <div class="amtex-prods-mini">
              <div class="amtex-prods-mini-label">Slug</div>
              <div class="amtex-prods-mini-value">{{ $product->slug ?? '—' }}</div>
            </div>

            <div class="amtex-prods-mini">
              <div class="amtex-prods-mini-label">Rating</div>
              <div class="amtex-prods-mini-value">
                {{ $product->rating_avg ?? '—' }} <span class="amtex-prods-muted">({{ $product->rating_count ?? '—' }})</span>
              </div>
            </div>

            <div class="amtex-prods-mini">
              <div class="amtex-prods-mini-label">Dispatch</div>
              <div class="amtex-prods-mini-value">{{ $product->dispatch_text ?? '—' }}</div>
            </div>

            @if($availableSizes)
              <div class="amtex-prods-mini">
                <div class="amtex-prods-mini-label">Available Sizes</div>
                <div class="amtex-prods-mini-value">{{ $availableSizes }}</div>
              </div>
            @endif

            @if($availableVariants)
              <div class="amtex-prods-mini">
                <div class="amtex-prods-mini-label">Available Variants</div>
                <div class="amtex-prods-mini-value">{{ $availableVariants }}</div>
              </div>
            @endif
          </div>

          {{-- Brochure --}}
          <div class="amtex-prods-brochure">
            <div class="amtex-prods-brochure-left">
              <div class="amtex-prods-brochure-ico"><i class="fas fa-file-pdf"></i></div>
              <div>
                <div class="amtex-prods-brochure-title">Brochure PDF</div>
                <div class="amtex-prods-brochure-sub">Attach a brochure for customers / sales team.</div>
              </div>
            </div>

            <div class="amtex-prods-brochure-right">
              @if($product->brochure_pdf)
                <a href="{{ $product->brochure_pdf->getUrl() }}" target="_blank" class="btn amtex-prods-btn amtex-prods-btn-primary">
                  <i class="fas fa-arrow-up-right-from-square"></i> View File
                </a>
              @else
                <span class="amtex-prods-emptyline">No brochure uploaded</span>
              @endif
            </div>
          </div>

        </div>
      </div>

      {{-- Content Card --}}
      <div class="amtex-prods-card amtex-prods-content">
        <div class="amtex-prods-card-head">
          <div class="amtex-prods-card-title">
            <span class="amtex-prods-ico"><i class="fas fa-align-left"></i></span>
            Descriptions
          </div>
          <span class="amtex-prods-chip">Readable</span>
        </div>

        <div class="amtex-prods-body">
          <div class="amtex-prods-block">
            <div class="amtex-prods-block-title">{{ trans('cruds.product.fields.short_desc') }}</div>
            <div class="amtex-prods-html">
              {!! $product->short_desc ?: '<div class="amtex-prods-emptyline">No short description</div>' !!}
            </div>
          </div>

          @if(!empty($pointers))
            <div class="amtex-prods-divider"></div>
            <div class="amtex-prods-block">
              <div class="amtex-prods-block-title">3 Pointers</div>
              <ul class="amtex-prods-list">
                @foreach($pointers as $p)
                  @if(trim((string)$p) !== '')
                    <li><i class="fas fa-check-circle"></i> {{ $p }}</li>
                  @endif
                @endforeach
              </ul>
            </div>
          @endif

          <div class="amtex-prods-divider"></div>

          <div class="amtex-prods-block">
            <div class="amtex-prods-block-title">{{ trans('cruds.product.fields.description') }}</div>
            <div class="amtex-prods-html">
              {!! $product->description ?: '<div class="amtex-prods-emptyline">No full description</div>' !!}
            </div>
          </div>

          {{-- Key Highlights --}}
          @if(!empty($keyHighlights))
            <div class="amtex-prods-divider"></div>
            <div class="amtex-prods-block">
              <div class="amtex-prods-block-title">Key Highlights</div>
              <div class="amtex-prods-grid2">
                @foreach($keyHighlights as $h)
                  @php
                    $icon  = $h['icon'] ?? 'bi bi-star';
                    $title = $h['title'] ?? '';
                    $text  = $h['text'] ?? '';
                  @endphp
                  @if(trim($title.$text) !== '')
                    <div class="amtex-prods-feature">
                      <div class="amtex-prods-feature-ico"><i class="{{ $icon }}"></i></div>
                      <div class="amtex-prods-feature-body">
                        <div class="amtex-prods-feature-title">{{ $title ?: '—' }}</div>
                        <div class="amtex-prods-feature-text">{{ $text ?: '—' }}</div>
                      </div>
                    </div>
                  @endif
                @endforeach
              </div>
            </div>
          @endif

          {{-- Works On --}}
          @if(!empty($worksOn))
            <div class="amtex-prods-divider"></div>
            <div class="amtex-prods-block">
              <div class="amtex-prods-block-title">Works On</div>
              <div class="amtex-prods-grid2">
                @foreach($worksOn as $w)
                  @php
                    $icon  = $w['icon'] ?? 'bi bi-shield';
                    $title = $w['title'] ?? '';
                    $text  = $w['text'] ?? '';
                  @endphp
                  @if(trim($title.$text) !== '')
                    <div class="amtex-prods-feature">
                      <div class="amtex-prods-feature-ico"><i class="{{ $icon }}"></i></div>
                      <div class="amtex-prods-feature-body">
                        <div class="amtex-prods-feature-title">{{ $title ?: '—' }}</div>
                        <div class="amtex-prods-feature-text">{{ $text ?: '—' }}</div>
                      </div>
                    </div>
                  @endif
                @endforeach
              </div>
            </div>
          @endif

          {{-- Recommended For --}}
          @if(!empty($recoLeft) || !empty($recoRight))
            <div class="amtex-prods-divider"></div>
            <div class="amtex-prods-block">
              <div class="amtex-prods-block-title">Recommended For</div>
              <div class="amtex-prods-reco">
                <div class="amtex-prods-reco-col">
                  <div class="amtex-prods-reco-head">Left</div>
                  @if(!empty($recoLeft))
                    <ul class="amtex-prods-list">
                      @foreach($recoLeft as $item)
                        @if(trim((string)$item) !== '')
                          <li><i class="fas fa-chevron-right"></i> {{ $item }}</li>
                        @endif
                      @endforeach
                    </ul>
                  @else
                    <div class="amtex-prods-emptyline">No items</div>
                  @endif
                </div>

                <div class="amtex-prods-reco-col">
                  <div class="amtex-prods-reco-head">Right</div>
                  @if(!empty($recoRight))
                    <ul class="amtex-prods-list">
                      @foreach($recoRight as $item)
                        @if(trim((string)$item) !== '')
                          <li><i class="fas fa-chevron-right"></i> {{ $item }}</li>
                        @endif
                      @endforeach
                    </ul>
                  @else
                    <div class="amtex-prods-emptyline">No items</div>
                  @endif
                </div>
              </div>
            </div>
          @endif

          {{-- Technical & Performance --}}
          <div class="amtex-prods-divider"></div>
          <div class="amtex-prods-block">
            <div class="amtex-prods-block-title">Technical &amp; Performance</div>

            @if(!empty($techColumns) && !empty($techRows))
              {{-- ✅ Responsive: scrollable table + mobile accordion --}}
              <div class="amtex-prods-tech">

                {{-- Desktop/tablet: scroll table --}}
                <div class="amtex-prods-tech-scroll">
                  <table class="amtex-prods-tech-table">
                    <thead>
                      <tr>
                        <th class="amtex-prods-tech-sticky">Parameter</th>
                        @foreach($techColumns as $col)
                          <th>{{ $col }}</th>
                        @endforeach
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($techRows as $r)
                        @php
                          $param = $r['parameter'] ?? '';
                          $vals  = $r['values'] ?? [];
                        @endphp
                        <tr>
                          <td class="amtex-prods-tech-param">{{ $param ?: '—' }}</td>
                          @foreach($techColumns as $ci => $c)
                            <td>{{ $vals[$ci] ?? '—' }}</td>
                          @endforeach
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>

                {{-- Mobile: accordion cards --}}
                <div class="amtex-prods-tech-mobile">
                  @foreach($techColumns as $ci => $col)
                    <details class="amtex-prods-tech-acc" {{ $ci === 0 ? 'open' : '' }}>
                      <summary>
                        <span class="amtex-prods-tech-acc-title">{{ $col }}</span>
                        <span class="amtex-prods-tech-acc-hint">Tap to expand</span>
                      </summary>

                      <div class="amtex-prods-tech-acc-body">
                        @foreach($techRows as $r)
                          @php
                            $param = $r['parameter'] ?? '';
                            $vals  = $r['values'] ?? [];
                          @endphp
                          <div class="amtex-prods-tech-kv">
                            <div class="amtex-prods-tech-k">{{ $param ?: '—' }}</div>
                            <div class="amtex-prods-tech-v">{{ $vals[$ci] ?? '—' }}</div>
                          </div>
                        @endforeach
                      </div>
                    </details>
                  @endforeach
                </div>

              </div>
            @else
              <div class="amtex-prods-emptyline">No technical table added</div>
            @endif
          </div>

        </div>
      </div>

    </div>

    {{-- Right: Info / Quick actions --}}
    <div class="amtex-prods-side">

      <div class="amtex-prods-card">
        <div class="amtex-prods-card-head">
          <div class="amtex-prods-card-title">
            <span class="amtex-prods-ico"><i class="fas fa-circle-info"></i></span>
            Product Info
          </div>
          <span class="amtex-prods-chip amtex-prods-chip-alt">System</span>
        </div>

        <div class="amtex-prods-kv">
          <div class="amtex-prods-kv-row">
            <div class="amtex-prods-kv-label">{{ trans('cruds.product.fields.select_category') }}</div>
            <div class="amtex-prods-kv-value">{{ $product->select_category->name ?? '—' }}</div>
          </div>

          <div class="amtex-prods-kv-row">
            <div class="amtex-prods-kv-label">{{ trans('cruds.product.fields.badge') }}</div>
            <div class="amtex-prods-kv-value">{{ \App\Models\Product::BADGE_SELECT[$product->badge] ?? '—' }}</div>
          </div>

          <div class="amtex-prods-kv-row">
            <div class="amtex-prods-kv-label">{{ trans('cruds.product.fields.is_featured') }}</div>
            <div class="amtex-prods-kv-value">{{ \App\Models\Product::IS_FEATURED_SELECT[$product->is_featured] ?? '—' }}</div>
          </div>

          <div class="amtex-prods-kv-row">
            <div class="amtex-prods-kv-label">{{ trans('cruds.product.fields.is_active') }}</div>
            <div class="amtex-prods-kv-value">{{ \App\Models\Product::IS_ACTIVE_SELECT[$product->is_active] ?? '—' }}</div>
          </div>

          <div class="amtex-prods-kv-row">
            <div class="amtex-prods-kv-label">{{ trans('cruds.product.fields.base_price') }}</div>
            <div class="amtex-prods-kv-value">₹{{ $product->base_price ?? '—' }}</div>
          </div>

          <div class="amtex-prods-kv-row">
            <div class="amtex-prods-kv-label">{{ trans('cruds.product.fields.compare_price') }}</div>
            <div class="amtex-prods-kv-value">₹{{ $product->compare_price ?? '—' }}</div>
          </div>

          @if($availableSizes)
            <div class="amtex-prods-kv-row">
              <div class="amtex-prods-kv-label">Available Sizes</div>
              <div class="amtex-prods-kv-value">{{ $availableSizes }}</div>
            </div>
          @endif

          @if($availableVariants)
            <div class="amtex-prods-kv-row">
              <div class="amtex-prods-kv-label">Available Variants</div>
              <div class="amtex-prods-kv-value">{{ $availableVariants }}</div>
            </div>
          @endif
        </div>

        <div class="amtex-prods-side-actions">
          <a href="{{ route('admin.products.index') }}" class="btn amtex-prods-btn amtex-prods-btn-light">
            <i class="fas fa-list"></i> Back to List
          </a>

          @can('product_edit')
            <a href="{{ route('admin.products.edit', $product->id) }}" class="btn amtex-prods-btn amtex-prods-btn-primary">
              <i class="fas fa-pen"></i> Edit Product
            </a>
          @endcan
        </div>
      </div>

    </div>

  </div>
</div>

{{-- ✅ Minimal CSS additions only for PDP + Tech responsiveness --}}
<style>
  .amtex-prods-tags{ display:flex; flex-wrap:wrap; gap:8px; margin:10px 0 2px; }
  .amtex-prods-tag{ display:inline-flex; align-items:center; padding:.25rem .6rem; border-radius:999px; border:1px solid rgba(0,0,0,.08); background:#fff; font-size:.78rem; }
  .amtex-prods-list{ margin:0; padding:0; list-style:none; display:grid; gap:8px; }
  .amtex-prods-list li{ display:flex; gap:10px; align-items:flex-start; }
  .amtex-prods-list i{ margin-top:3px; opacity:.75; }

  .amtex-prods-grid2{ display:grid; grid-template-columns:repeat(2, minmax(0,1fr)); gap:12px; }
  @media (max-width: 992px){ .amtex-prods-grid2{ grid-template-columns:1fr; } }

  .amtex-prods-feature{ display:flex; gap:12px; padding:12px; border:1px solid rgba(0,0,0,.08); border-radius:14px; background:#fff; }
  .amtex-prods-feature-ico{ width:40px; height:40px; border-radius:12px; display:flex; align-items:center; justify-content:center; border:1px solid rgba(0,0,0,.08); background:rgba(0,0,0,.03); }
  .amtex-prods-feature-title{ font-weight:700; margin-bottom:2px; }
  .amtex-prods-feature-text{ opacity:.85; }

  .amtex-prods-reco{ display:grid; grid-template-columns:repeat(2, minmax(0,1fr)); gap:14px; }
  .amtex-prods-reco-col{ border:1px solid rgba(0,0,0,.08); border-radius:14px; padding:12px; background:#fff; }
  .amtex-prods-reco-head{ font-weight:800; margin-bottom:10px; opacity:.9; }
  @media (max-width: 992px){ .amtex-prods-reco{ grid-template-columns:1fr; } }

  /* Tech */
  .amtex-prods-tech{ display:block; }
  .amtex-prods-tech-scroll{
    width:100%;
    overflow:auto;
    border:1px solid rgba(0,0,0,.08);
    border-radius:14px;
    background:#fff;
  }
  .amtex-prods-tech-table{ width:100%; border-collapse:separate; border-spacing:0; min-width:720px; }
  .amtex-prods-tech-table th, .amtex-prods-tech-table td{
    padding:10px 12px;
    border-bottom:1px solid rgba(0,0,0,.06);
    vertical-align:top;
    white-space:nowrap;
  }
  .amtex-prods-tech-table th{
    position:sticky; top:0;
    background:#fff;
    z-index:2;
    font-weight:800;
  }
  .amtex-prods-tech-param{ font-weight:700; white-space:normal; min-width:180px; }
  .amtex-prods-tech-sticky{ left:0; z-index:3; }
  .amtex-prods-tech-table td:first-child, .amtex-prods-tech-table th:first-child{
    position:sticky; left:0;
    background:#fff;
    border-right:1px solid rgba(0,0,0,.06);
  }

  .amtex-prods-tech-mobile{ display:none; }
  @media (max-width: 768px){
    .amtex-prods-tech-scroll{ display:none; }
    .amtex-prods-tech-mobile{ display:grid; gap:10px; }
  }
  .amtex-prods-tech-acc{
    border:1px solid rgba(0,0,0,.08);
    border-radius:14px;
    background:#fff;
    overflow:hidden;
  }
  .amtex-prods-tech-acc summary{
    list-style:none;
    padding:12px 14px;
    display:flex;
    justify-content:space-between;
    gap:10px;
    cursor:pointer;
    font-weight:800;
  }
  .amtex-prods-tech-acc summary::-webkit-details-marker{ display:none; }
  .amtex-prods-tech-acc-hint{ font-weight:600; opacity:.65; }
  .amtex-prods-tech-acc-body{ padding:12px 14px; border-top:1px solid rgba(0,0,0,.06); display:grid; gap:10px; }
  .amtex-prods-tech-kv{ display:flex; justify-content:space-between; gap:12px; }
  .amtex-prods-tech-k{ font-weight:700; opacity:.9; }
  .amtex-prods-tech-v{ opacity:.85; text-align:right; }
</style>

@endsection
