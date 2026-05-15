@extends('web_master')
@section('main')

@php
  /**
   * Normalize PDP fields same as Admin:
   * - arrays (casted)
   * - JSON strings
   * - null
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

  // Category
  $categoryName = optional($product->select_category)->name ?? 'Products';
  $categorySlug = optional($product->select_category)->slug ?? null;

  // PDP fields
  $tags          = $toArray($product->pdp_tags ?? null);
  $pointers      = $toArray($product->pdp_pointers ?? null);        // array of strings
  $keyHighlights = $toArray($product->pdp_key_highlights ?? null);  // [{icon,title,text}]
  $worksOn       = $toArray($product->pdp_works_on ?? null);        // [{icon,title,text}]
  $recoLeft      = $toArray($product->pdp_recommended_for_left ?? null);
  $recoRight     = $toArray($product->pdp_recommended_for_right ?? null);

  $availableSizes    = $toString($product->pdp_available_sizes ?? '');
  $availableVariants = $toString($product->pdp_available_variants ?? '');

  // Tech table format: {columns:[], rows:[{parameter:'', values:[]}]}
  $tech = $toArray($product->pdp_tech_table ?? null);
  $techColumns = $tech['columns'] ?? [];
  $techRows    = $tech['rows'] ?? [];

  // Badge / dispatch / rating
  $badge        = $product->badge ?? null;
  $dispatchText = $product->dispatch_text ?? null;
  $ratingAvg    = $product->rating_avg ? (float)$product->rating_avg : null;
  $ratingCount  = $product->rating_count ? (int)$product->rating_count : null;

  // Gallery
  $placeholder = asset('assets/img/placeholder.png');
  $mainImgUrl  = $product->main_image?->url ?? $placeholder;

  $galleryItems = collect();

  // $gallery comes from controller (flattened ProductImage media)
  if(isset($gallery) && $gallery instanceof \Illuminate\Support\Collection && $gallery->count()){
    $galleryItems = $gallery->filter(function($g){
      return !empty($g?->url);
    })->values();

    $mainImgUrl = $galleryItems->first()?->url ?? $mainImgUrl;
  } else {
    // fallback: just use main image as 1 item
    $galleryItems = collect([$product->main_image])->filter(function($g){
      return !empty($g?->url);
    })->values();
  }

  // Variants / price
  $variants = $product->variants ?? collect();
  $currentVariant = $currentVariant ?? null;

  $priceNow = $currentVariant?->price ?? $product->base_price;
  $priceOld = $currentVariant?->compare_price ?? $product->compare_price;

  $savePercent = null;
  if(!empty($priceNow) && !empty($priceOld) && (float)$priceOld > (float)$priceNow){
    $savePercent = round((((float)$priceOld - (float)$priceNow) / (float)$priceOld) * 100);
  }

  // Dropdown options
  $capacityOptions = $variants->pluck('capacity_label')->filter()->unique()->values();
  $finishOptions   = $variants->pluck('finish_label')->filter()->unique()->values();

  $defaultCapacity = $currentVariant?->capacity_label ?? ($capacityOptions->first() ?? null);
  $defaultFinish   = $currentVariant?->finish_label ?? ($finishOptions->first() ?? null);

  // Variants JSON for JS
  $variantsJson = $variants->map(function($v){
    return [
      'id'             => $v->id,
      'capacity_label' => $v->capacity_label,
      'finish_label'   => $v->finish_label,
      'price'          => $v->price,
      'compare_price'  => $v->compare_price,
      'stock_qty'      => $v->stock_qty,
      'sku'            => $v->sku,
    ];
  })->values();
@endphp

<!-- =================== MAIN =================== -->
<main id="pdp-main">

  <!-- =================== BREADCRUMB =================== -->
  <section id="pdp-breadcrumb" class="pdp-section-pad">
    <div class="container">
      <div class="pdp-bc d-flex flex-wrap align-items-center justify-content-between gap-2">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb mb-0 pdp-bc-list">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('frontend.products.index') }}">Products</a></li>

            @if($categorySlug)
              <li class="breadcrumb-item">
                <a href="{{ route('frontend.products.category', $categorySlug) }}">{{ $categoryName }}</a>
              </li>
            @else
              <li class="breadcrumb-item">{{ $categoryName }}</li>
            @endif

            <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
          </ol>
        </nav>

        <div class="pdp-bc-actions d-flex align-items-center gap-2">
          <span class="pdp-stock-pill">
            <i class="bi bi-check2-circle me-1"></i> In stock
          </span>
          <button type="button" class="pdp-icon-btn" aria-label="Add to wishlist">
            <i class="bi bi-heart"></i>
          </button>
          <button
            type="button"
            class="pdp-icon-btn"
            aria-label="Share"
            onclick="(function(){
              const data = { title: @json($product->name), url: window.location.href };
              if(navigator.share){ navigator.share(data); }
              else { window.prompt('Copy link:', window.location.href); }
            })()"
          >
            <i class="bi bi-share"></i>
          </button>
        </div>

      </div>
    </div>
  </section>

  <!-- =================== TOP: GALLERY + BUY CARD =================== -->
  <section id="pdp-top" class="pdp-section-pad">
    <div class="container">
      <div class="row g-4">

        <!-- Gallery -->
        <div class="col-lg-7">
          <div class="pdp-gallery">

            <div class="pdp-gallery-main">
              <img
                id="pdpMainImg"
                src="{{ $mainImgUrl }}"
                alt="{{ $product->name }}"
                loading="eager"
                decoding="async"
              />
              <span class="pdp-gallery-badge">
                <i class="bi bi-award me-1"></i> ISI / ISO / CE (As Applicable)
              </span>
            </div>

            @if($galleryItems->count() > 1)
              <div class="pdp-gallery-thumbs">
                @foreach($galleryItems as $idx => $g)
                  @php
                    // IMPORTANT:
                    // - data-full must ALWAYS be the full image URL (not preview/thumb)
                    $fullUrl  = $g->url ?? $placeholder;
                    $thumbUrl = $g->preview ?? $g->thumbnail ?? $fullUrl;
                  @endphp

                  <button
                    class="pdp-thumb {{ $idx === 0 ? 'active' : '' }}"
                    type="button"
                    data-full="{{ $fullUrl }}"
                    aria-label="View image {{ $idx + 1 }}"
                  >
                    <img src="{{ $thumbUrl }}" alt="Thumb {{ $idx + 1 }}" loading="lazy" decoding="async" />
                  </button>
                @endforeach
              </div>
            @endif

            <div class="pdp-gallery-note">
              <i class="bi bi-info-circle me-1"></i>
              Images are indicative. Final finish may vary by batch (as per standards).
            </div>

          </div>
        </div>

        <!-- Right: Title + Sticky buy -->
        <div class="col-lg-5">
          <div class="pdp-info">

            <div class="pdp-eyebrow-row d-flex flex-wrap align-items-center gap-2">
              <span class="pdp-eyebrow">
                <i class="bi bi-tags me-1"></i> {{ strtoupper($categoryName) }}
              </span>

              @if(!empty($badge))
                <span class="pdp-tag">{{ $badge }}</span>
              @endif

              @if(!empty($tags))
                @foreach(array_slice($tags, 0, 2) as $t)
                  @if(trim((string)$t) !== '')
                    <span class="pdp-tag pdp-tag-soft">{{ $t }}</span>
                  @endif
                @endforeach
              @endif
            </div>

            <h1 class="pdp-title">{{ $product->name }}</h1>

            <div class="pdp-rating-row d-flex flex-wrap align-items-center gap-2">
              @if($ratingAvg)
                <div class="pdp-stars" aria-label="Rated {{ number_format($ratingAvg,1) }} out of 5">
                  @php
                    $full  = floor($ratingAvg);
                    $half  = (($ratingAvg - $full) >= 0.5) ? 1 : 0;
                    $empty = 5 - $full - $half;
                  @endphp
                  @for($i=0; $i<$full; $i++) <i class="bi bi-star-fill"></i> @endfor
                  @if($half) <i class="bi bi-star-half"></i> @endif
                  @for($i=0; $i<$empty; $i++) <i class="bi bi-star"></i> @endfor
                </div>
                <span class="pdp-rating-text">
                  {{ number_format($ratingAvg,1) }}{{ $ratingCount ? " ({$ratingCount} reviews)" : '' }}
                </span>
                <span class="pdp-dot">•</span>
              @endif

              <span class="pdp-meta-mini">
                <i class="bi bi-truck me-1"></i> {{ $dispatchText ?: 'Dispatch timelines vary' }}
              </span>
            </div>

            {{-- Short desc (admin shows HTML) --}}
            @if($product->short_desc)
              <div class="pdp-subtitle">
                {!! $product->short_desc !!}
              </div>
            @endif

            {{-- ✅ 3 Pointers (right after short desc like static) --}}
            @if(!empty($pointers))
              <div class="pdp-highlights">
                @foreach(array_slice($pointers, 0, 3) as $p)
                  @if(trim((string)$p) !== '')
                    <div class="pdp-hl">
                      <i class="bi bi-check2-circle"></i>
                      <div>
                        <div class="pdp-hl-title">Key Point</div>
                        <div class="pdp-hl-text">{{ $p }}</div>
                      </div>
                    </div>
                  @endif
                @endforeach
              </div>
            @endif

            <!-- Sticky Buy Card -->
            <div class="pdp-buy-card">

              <div class="pdp-price-row d-flex align-items-end justify-content-between gap-2">
                <div>
                  <div class="pdp-price" id="pdpPriceNow">
                    @if(!empty($priceNow)) ₹{{ number_format((float)$priceNow) }} @else Contact for price @endif
                  </div>

                  <div class="pdp-price-old" id="pdpPriceOld"
                       @if(empty($priceOld) || empty($priceNow) || (float)$priceOld <= (float)$priceNow) style="display:none;" @endif>
                    @if(!empty($priceOld) && !empty($priceNow) && (float)$priceOld > (float)$priceNow)
                      ₹{{ number_format((float)$priceOld) }}
                    @endif
                  </div>
                </div>

                <div class="pdp-save-pill" id="pdpSavePill" @if(empty($savePercent)) style="display:none;" @endif>
                  @if(!empty($savePercent)) Save {{ $savePercent }}% @endif
                </div>
              </div>

              @if($variants->count())
                <div class="pdp-variant-row row g-2 mt-1">
                  <div class="col-6">
                    <label class="pdp-label">Capacity</label>
                    <select class="form-select pdp-select" id="pdpCapacity">
                      @foreach($capacityOptions as $cap)
                        <option value="{{ $cap }}" {{ $cap == $defaultCapacity ? 'selected' : '' }}>
                          {{ $cap }}
                        </option>
                      @endforeach
                    </select>
                  </div>

                  <div class="col-6">
                    <label class="pdp-label">Variant</label>
                    <select class="form-select pdp-select" id="pdpFinish">
                      @foreach($finishOptions as $fin)
                        <option value="{{ $fin }}" {{ $fin == $defaultFinish ? 'selected' : '' }}>
                          {{ $fin }}
                        </option>
                      @endforeach
                    </select>
                  </div>
                </div>
              @endif

              <div class="pdp-qty-row d-flex align-items-center justify-content-between gap-2 mt-2">
                <div class="pdp-qty">
                  <button class="pdp-qty-btn" type="button" aria-label="Decrease quantity" id="pdpQtyMinus">
                    <i class="bi bi-dash"></i>
                  </button>
                  <input id="pdpQtyInput" class="pdp-qty-input" value="1" inputmode="numeric" aria-label="Quantity" />
                  <button class="pdp-qty-btn" type="button" aria-label="Increase quantity" id="pdpQtyPlus">
                    <i class="bi bi-plus"></i>
                  </button>
                </div>

                <div class="pdp-mini-ship">
                  <i class="bi bi-shield-lock me-1"></i> Genuine warranty
                </div>
              </div>

              <div class="pdp-buy-actions row g-2 mt-2">
                <div class="col-12">
                  <button class="btn btn-amtex w-100 pdp-btn-primary" type="button" id="pdpAddToCart">
                    <i class="bi bi-cart-plus me-1"></i> Add to Cart
                  </button>
                </div>
                <div class="col-12">
                  <button class="btn btn-dark w-100 pdp-btn-buy" type="button" id="pdpBuyNow">
                    <i class="bi bi-lightning-charge-fill me-1"></i> Buy Now
                  </button>
                </div>
                <div class="col-12">
                  <a href="#pdp-contact" class="btn btn-outline-dark w-100 pdp-btn-outline">
                    <i class="bi bi-chat-dots me-1"></i> Get bulk / project quote
                  </a>
                </div>
              </div>

              <div class="pdp-trust-row">
                <div class="pdp-trust"><i class="bi bi-truck"></i><span>Pan-India shipping</span></div>
                <div class="pdp-trust"><i class="bi bi-clipboard-check"></i><span>Audit assistance</span></div>
                <div class="pdp-trust"><i class="bi bi-arrow-repeat"></i><span>Upgrade options</span></div>
              </div>
            </div>

          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- =================== OVERVIEW / FEATURES =================== -->
  <section id="pdp-overview" class="pdp-section-pad">
    <div class="container">
      <div class="pdp-card">
        <div class="pdp-card-head">
          <div class="pdp-kicker">Product Overview-Product Features</div>
          <h2 class="pdp-h2">{{ $product->name }}</h2>
        </div>

        <div class="row g-4">
          <div class="col-lg-7">
            @if($product->description)
              <div class="pdp-p mb-0">{!! $product->description !!}</div>
            @else
              <div class="pdp-muted">Description will be updated soon.</div>
            @endif
          </div>

          <div class="col-lg-5">
            <div class="pdp-side">
              <div class="pdp-side-title"><i class="bi bi-list-check me-1"></i> Key Highlights</div>

              @if(!empty($keyHighlights))
                <ul class="pdp-bullets">
                  @foreach($keyHighlights as $h)
                    @php
                      $icon  = $h['icon'] ?? 'bi bi-check2-circle';
                      $title = $h['title'] ?? '';
                      $text  = $h['text'] ?? '';
                    @endphp
                    @if(trim($title.$text) !== '')
                      <li class="{{ $loop->last ? 'mb-0' : '' }}">
                        <i class="{{ $icon }}"></i>
                        <strong>{{ $title ?: '—' }}</strong>
                        <div class="pdp-muted">{{ $text ?: '—' }}</div>
                      </li>
                    @endif
                  @endforeach
                </ul>
              @else
                <div class="pdp-muted">Highlights will be updated soon.</div>
              @endif
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- =================== WORKS ON =================== -->
  <section id="pdp-works" class="pdp-section-pad">
    <div class="container">
      <div class="pdp-card">
        <div class="pdp-card-head">
          <h2 class="pdp-h2 mb-1">Works on</h2>
          <div class="pdp-muted">Suitable across multiple fire classes (as per application).</div>
        </div>

        @if(!empty($worksOn))
          <div class="row g-3 g-md-4">
            @foreach($worksOn as $w)
              @php
                $icon  = $w['icon'] ?? 'bi bi-shield';
                $title = $w['title'] ?? '';
                $text  = $w['text'] ?? '';
              @endphp
              @if(trim($title.$text) !== '')
                <div class="col-6 col-md-4 col-lg">
                  <div class="pdp-work">
                    <div class="pdp-work-ico"><i class="{{ $icon }}"></i></div>
                    <div class="pdp-work-title">{{ $title ?: '—' }}</div>
                    <div class="pdp-work-text">{{ $text ?: '—' }}</div>
                  </div>
                </div>
              @endif
            @endforeach
          </div>

          <div class="pdp-footnote">
            *Use from a safe distance and follow safety guidance / site policy.
          </div>
        @else
          <div class="pdp-muted">Works-on data will be updated soon.</div>
        @endif

      </div>
    </div>
  </section>

  <!-- =================== RECOMMENDED FOR =================== -->
  <section id="pdp-recommended" class="pdp-section-pad">
    <div class="container">
      <div class="pdp-card">
        <div class="pdp-card-head">
          <h2 class="pdp-h2 mb-1">Recommended For</h2>
          <div class="pdp-muted">Residential • Commercial • Institutional • Industrial</div>
        </div>

        @if(!empty($recoLeft) || !empty($recoRight))
          <div class="row g-3">
            <div class="col-lg-6">
              @if(!empty($recoLeft))
                <ul class="pdp-list">
                  @foreach($recoLeft as $item)
                    @if(trim((string)$item) !== '')
                      <li><i class="bi bi-dot"></i> {{ $item }}</li>
                    @endif
                  @endforeach
                </ul>
              @endif
            </div>

            <div class="col-lg-6">
              @if(!empty($recoRight))
                <ul class="pdp-list">
                  @foreach($recoRight as $item)
                    @if(trim((string)$item) !== '')
                      <li><i class="bi bi-dot"></i> {{ $item }}</li>
                    @endif
                  @endforeach
                </ul>
              @endif
            </div>
          </div>
        @else
          <div class="pdp-muted">Recommended-for data will be updated soon.</div>
        @endif

        <div class="row g-3 mt-2">
          <div class="col-lg-6">
            <div class="pdp-mini-card">
              <div class="pdp-mini-card-title"><i class="bi bi-bounding-box me-1"></i> Available Sizes</div>
              <div class="pdp-mini-card-text">{{ $availableSizes ?: '—' }}</div>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="pdp-mini-card">
              <div class="pdp-mini-card-title"><i class="bi bi-palette me-1"></i> Available Variants</div>
              <div class="pdp-mini-card-text">{{ $availableVariants ?: '—' }}</div>
            </div>
          </div>
        </div>

        @if($product->brochure_pdf)
          <div class="mt-3">
            <a class="btn btn-outline-dark" href="{{ $product->brochure_pdf->getUrl() }}" target="_blank">
              <i class="bi bi-file-earmark-pdf me-1"></i> Download Brochure
            </a>
          </div>
        @endif

      </div>
    </div>
  </section>

  <!-- =================== TECHNICAL DATA =================== -->
  <section id="pdp-tech" class="pdp-section-pad">
    <div class="container">
      <div class="pdp-card">
        <div class="pdp-card-head">
          <h2 class="pdp-h2 mb-1">Technical &amp; Performance Data</h2>
          <div class="pdp-muted">Reference configuration data (subject to continuous improvements).</div>
        </div>

        @if(!empty($techColumns) && !empty($techRows))
          <div class="table-responsive pdp-table-wrap">
            <table class="table pdp-table mb-0">
              <thead>
                <tr>
                  <th>Parameter</th>
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
                    <td>{{ $param ?: '—' }}</td>
                    @foreach($techColumns as $ci => $c)
                      <td>{{ $vals[$ci] ?? '—' }}</td>
                    @endforeach
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        @else
          <div class="pdp-muted">Technical table will be updated soon.</div>
        @endif

        <div class="pdp-alert-2 mt-3">
          <i class="bi bi-exclamation-triangle"></i>
          <div>
            <div class="pdp-alert-2-title">Important</div>
            <div class="pdp-alert-2-text">
              It is mandatory for the extinguisher to be refilled by Manufacturer or an Authorised Skilled Agent.
              Specifications may change with time due to continuous product improvisation.
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- =================== CONTACT CTA =================== -->
  <section id="pdp-contact" class="pdp-section-pad">
    <div class="container">
      <div class="pdp-cta">
        <div class="pdp-cta-left">
          <div class="pdp-cta-title">Need a quotation or bulk requirement?</div>
          <div class="pdp-cta-text">Get support for selection, placement, BOQ, and compliance documentation.</div>
        </div>
        <div class="pdp-cta-right">
          <a class="btn btn-amtex pdp-cta-btn" href="tel:+918047822682">
            <i class="bi bi-telephone-outbound me-1"></i> +91 804 7822 682
          </a>
          <a class="btn btn-outline-dark pdp-cta-btn" href="mailto:info@amtexsafety.com">
            <i class="bi bi-envelope me-1"></i> info@amtexsafety.com
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- Mobile sticky bottom bar -->
  <div class="pdp-mobile-bar d-lg-none">
    <div class="pdp-mobile-price">
      <div class="pdp-mobile-price-now" id="pdpMobilePriceNow">
        @if(!empty($priceNow)) ₹{{ number_format((float)$priceNow) }} @else Contact for price @endif
      </div>

      <div class="pdp-mobile-price-old" id="pdpMobilePriceOld"
           @if(empty($priceOld) || empty($priceNow) || (float)$priceOld <= (float)$priceNow) style="display:none;" @endif>
        @if(!empty($priceOld) && !empty($priceNow) && (float)$priceOld > (float)$priceNow)
          ₹{{ number_format((float)$priceOld) }}
        @endif
      </div>
    </div>

    <div class="d-flex gap-2">
      <button class="btn btn-amtex pdp-mobile-btn" type="button" id="pdpMobileAdd">Add to Cart</button>
      <button class="btn btn-dark pdp-mobile-btn2" type="button" id="pdpMobileBuy">Buy Now</button>
    </div>
  </div>

</main>

{{-- ✅ Gallery Script (ALWAYS) --}}
<script>
  (function () {
    const main = document.getElementById('pdpMainImg');
    if (!main) return;

    function preloadAndSwap(url){
      if(!url) return;

      const pre = new Image();
      pre.onload = function(){
        // Swap only after image is loaded (prevents blank/not visible)
        main.src = url;
      };
      pre.onerror = function(){
        // If something fails, still try to set it
        main.src = url;
      };
      pre.src = url;
    }

    const thumbs = document.querySelectorAll('.pdp-thumb');
    if (!thumbs.length) return;

    thumbs.forEach(btn => {
      btn.addEventListener('click', () => {
        thumbs.forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        const url = btn.getAttribute('data-full');
        preloadAndSwap(url);
      });
    });
  })();
</script>

{{-- ✅ Variant Pricing + Qty (ONLY if variants exist) --}}
@if($variants->count())
  <script>
    (function () {
      const variants = @json($variantsJson);

      const elCap = document.getElementById('pdpCapacity');
      const elFin = document.getElementById('pdpFinish');

      const elPriceNow = document.getElementById('pdpPriceNow');
      const elPriceOld = document.getElementById('pdpPriceOld');
      const elSave     = document.getElementById('pdpSavePill');

      const elMPriceNow = document.getElementById('pdpMobilePriceNow');
      const elMPriceOld = document.getElementById('pdpMobilePriceOld');

      function formatINR(n){
        try { return '₹' + Number(n).toLocaleString('en-IN'); } catch(e){ return '₹' + n; }
      }
      function show(el){ if(el){ el.style.display = ''; } }
      function hide(el){ if(el){ el.style.display = 'none'; } }

      function updatePrice() {
        if (!elCap || !elFin) return;

        const cap = elCap.value;
        const fin = elFin.value;

        const match =
          variants.find(v => (v.capacity_label === cap) && (v.finish_label === fin)) ||
          variants.find(v => (v.capacity_label === cap)) ||
          variants[0];

        if (!match) return;

        const p  = match.price;
        const cp = match.compare_price;

        if (elPriceNow) elPriceNow.textContent = p ? formatINR(p) : 'Contact for price';
        if (elMPriceNow) elMPriceNow.textContent = p ? formatINR(p) : 'Contact for price';

        if (cp && p && Number(cp) > Number(p)) {
          if (elPriceOld){ elPriceOld.textContent = formatINR(cp); show(elPriceOld); }
          if (elMPriceOld){ elMPriceOld.textContent = formatINR(cp); show(elMPriceOld); }

          const save = Math.round(((Number(cp) - Number(p)) / Number(cp)) * 100);
          if (elSave){ elSave.textContent = 'Save ' + save + '%'; show(elSave); }
        } else {
          if (elPriceOld){ elPriceOld.textContent = ''; hide(elPriceOld); }
          if (elMPriceOld){ elMPriceOld.textContent = ''; hide(elMPriceOld); }
          if (elSave){ elSave.textContent = ''; hide(elSave); }
        }
      }

      if (elCap) elCap.addEventListener('change', updatePrice);
      if (elFin) elFin.addEventListener('change', updatePrice);
      updatePrice();

      // Qty
      const minus = document.getElementById('pdpQtyMinus');
      const plus  = document.getElementById('pdpQtyPlus');
      const qty   = document.getElementById('pdpQtyInput');

      function clampQty(v){
        v = parseInt(v || '1', 10);
        if (isNaN(v) || v < 1) v = 1;
        if (v > 999) v = 999;
        return v;
      }

      if (minus && qty) minus.addEventListener('click', () => { qty.value = clampQty(Number(qty.value) - 1); });
      if (plus && qty)  plus.addEventListener('click', () => { qty.value = clampQty(Number(qty.value) + 1); });
      if (qty) qty.addEventListener('input', () => { qty.value = clampQty(qty.value); });

    })();
  </script>
@endif

@endsection