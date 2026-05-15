@extends('web_master')
@section('main')

<!-- =================== MAIN =================== -->
<main id="products-main">

  <!-- =================== PRODUCTS HERO =================== -->
  <section id="products-hero" class="section-padding">
    <div class="container">
      <div class="row g-4 align-items-center">

        <!-- ================= LEFT TEXT ================= -->
        <div class="col-lg-7">
          <div class="products-hero-eyebrow-row d-flex flex-wrap align-items-center gap-2 mb-2">
            <span class="products-hero-eyebrow">
              <i class="bi bi-fire me-1"></i>
              Product Catalogue
            </span>

            <span class="products-hero-badge">
              <i class="bi bi-shield-check me-1"></i>
              ISO &amp; ISI Certified Range
            </span>
          </div>

          <h1 class="products-hero-title">
            Fire extinguishers & safety products
            <span>for every risk zone.</span>
          </h1>

          <p class="products-hero-subtitle mb-3 mb-md-4">
            Browse our mist retardant extinguishers, kitchen safety units and industrial models –
            engineered for homes, commercial spaces and high-risk facilities.
          </p>

          <div class="products-hero-tags d-flex flex-wrap gap-2">
            <span class="products-hero-tag"><i class="bi bi-droplet-half me-1"></i>Mist Extinguishers</span>
            <span class="products-hero-tag"><i class="bi bi-egg-fried me-1"></i>Kitchen Safety</span>
            <span class="products-hero-tag"><i class="bi bi-building-gear me-1"></i>Industrial &amp; Warehouse</span>
          </div>
        </div>

        <!-- ================= RIGHT SUGGESTION PANEL ================= -->
        <div class="col-lg-5">
          <div class="products-hero-panel">

            <div class="products-hero-panel-heading">
              <h3 class="products-hero-panel-title-xl">
                Need a quick suggestion?
              </h3>
              <p class="products-hero-panel-subtext">
                Tell us where you need protection and get instant model recommendations.
              </p>

              <span class="products-hero-panel-mini-chip">
                <i class="bi bi-lightning-charge-fill me-1"></i> 1–2 min
              </span>
            </div>

            <form class="products-hero-form row g-2 mt-2" action="javascript:void(0)">
              <div class="col-12">
                <select class="form-select products-hero-input">
                  <option selected>Select area of installation</option>
                  <option>Apartment / Home</option>
                  <option>Office / IT Space</option>
                  <option>Shop / Showroom</option>
                  <option>Restaurant / Kitchen</option>
                  <option>Factory / Warehouse</option>
                  <option>Other</option>
                </select>
              </div>

              <div class="col-md-12">
                <select class="form-select products-hero-input">
                  <option selected>Approx Area Size</option>
                  <option>Small room</option>
                  <option>2–3 rooms / offices</option>
                  <option>Full commercial floor</option>
                  <option>Industrial space</option>
                  <option>Other</option>
                </select>
              </div>

              <div class="col-12">
                <textarea
                  class="form-control products-hero-input products-hero-textarea"
                  rows="3"
                  placeholder="Tell us your requirement (e.g., number of floors, kitchen type, electrical panel area, budget, site location, etc.)"
                ></textarea>
              </div>

              <div class="col-12">
                <button type="button" class="products-hero-big-btn w-100">
                  Get Product Recommendation
                </button>
                <p class="products-hero-note mb-0">
                  <i class="bi bi-lock-fill me-1"></i>
                  No spam. Expert guidance only.
                </p>
              </div>
            </form>

          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- =================== FILTER BAR =================== -->
  <section id="products-filter-bar">
    <div class="container">
      <div class="products-filter-card row align-items-center g-2">

        <!-- Left: category chips -->
        <div class="col-md-8">
          <div class="d-flex flex-wrap align-items-center gap-2 mb-1">
            <span class="products-filter-label">
              <i class="bi bi-funnel me-1"></i> Filter by
            </span>

            <div class="products-filter-chips d-flex flex-wrap gap-2">

              {{-- All products --}}
              <a
                class="products-filter-chip {{ empty($activeCategory) ? 'active' : '' }}"
                href="{{ route('frontend.products.index', array_filter(['sort' => $sort ?? request('sort')])) }}"
              >
                All products
              </a>

              {{-- Dynamic Categories --}}
              @if(isset($categories) && $categories->count())
                @foreach($categories as $cat)
                  <a
                    class="products-filter-chip {{ (!empty($activeCategory) && $activeCategory->id === $cat->id) ? 'active' : '' }}"
                    href="{{ route('frontend.products.category', $cat->slug) }}?{{ http_build_query(array_filter(['sort' => $sort ?? request('sort')])) }}"
                  >
                    {{ $cat->name }}
                  </a>
                @endforeach
              @endif

            </div>
          </div>
        </div>

        <!-- Right: sort + view -->
        <div class="col-md-4">
          <div class="products-filter-actions d-flex justify-content-md-end align-items-center gap-2">

            <div class="products-sort-wrap">
              <label class="products-sort-label">Sort by</label>

              {{-- Sort is server-side (GET) --}}
              <form method="GET" action="{{ empty($activeCategory) ? route('frontend.products.index') : route('frontend.products.category', $activeCategory->slug) }}">
                <select class="form-select products-sort-select" name="sort" onchange="this.form.submit()">
                  @php $currentSort = $sort ?? request('sort', 'recommended'); @endphp
                  <option value="recommended" {{ $currentSort === 'recommended' ? 'selected' : '' }}>Recommended</option>
                  <option value="price_low" {{ $currentSort === 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                  <option value="price_high" {{ $currentSort === 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                </select>
              </form>
            </div>

            <div class="products-view-toggle d-none d-md-flex">
              <button type="button" class="products-view-btn active" aria-label="Grid view">
                <i class="bi bi-grid-3x3-gap"></i>
              </button>
              <button type="button" class="products-view-btn" aria-label="List view">
                <i class="bi bi-menu-button-wide"></i>
              </button>
            </div>

          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- =================== PRODUCT GRID =================== -->
  <section id="products-listing">
    <div class="container">

      <!-- meta row -->
      <div class="products-listing-meta d-flex flex-wrap justify-content-between align-items-center mb-3 mb-md-4">
        <div class="products-listing-meta-left">
          <span class="products-listing-count-pill">
            @if(isset($products))
              Showing {{ $products->count() }} of {{ $products->total() }} products
            @else
              Showing 0 products
            @endif
          </span>
        </div>

        <div class="products-listing-meta-right d-none d-sm-flex align-items-center gap-2">
          <i class="bi bi-info-circle products-listing-meta-icon"></i>
          <span class="products-listing-meta-text">
            Need help? Use the filters above or <a href="#quick-enquiry">talk to our team</a>.
          </span>
        </div>
      </div>

      <div class="row g-3 g-md-4">

        @forelse($products as $product)
          @php
            $img = $product->main_image ? $product->main_image->getUrl() : null;
            $badge = $product->badge ?? null;
            $catName = $product->select_category->name ?? 'Product';
            $catSlug = $product->select_category->slug ?? 'all';
            $dispatch = $product->dispatch_text ?? null;

            $tags = is_array($product->pdp_tags) ? $product->pdp_tags : [];

            $sizes = trim((string) ($product->pdp_available_sizes ?? ''));
            $firstSize = $sizes ? explode(',', $sizes)[0] : null;
            $firstSize = $firstSize ? trim($firstSize) : null;
          @endphp

          <div class="col-6 col-md-4 col-lg-3">
            <article class="products-card" data-category="{{ $catSlug }}">
              <div class="products-card-inner">

                <div class="products-card-badge-row">
                  @if($badge)
                    <span class="products-card-badge products-card-badge-primary">
                      {{ $badge }}
                    </span>
                  @endif

                  <button class="products-card-fav" type="button" aria-label="Add to wishlist">
                    <i class="bi bi-heart"></i>
                  </button>
                </div>

                <div class="products-card-image-wrap">
                  @if($img)
                    <img
                      src="{{ $img }}"
                      alt="{{ $product->name }}"
                      class="products-card-image"
                      loading="lazy"
                    />
                  @else
                    <div class="products-card-image products-card-image-fallback d-flex align-items-center justify-content-center">
                      <div class="text-center">
                        <i class="bi bi-image" style="font-size:24px;"></i>
                        <div class="small mt-1">No Image</div>
                      </div>
                    </div>
                  @endif
                </div>

                <div class="products-card-body">
                  <div class="products-card-category">{{ strtoupper($catName) }}</div>

                  <h3 class="products-card-title">{{ $product->name }}</h3>

                  <div class="products-card-meta">
                    @if($firstSize)
                      <span><i class="bi bi-bezier me-1"></i>{{ $firstSize }}</span>
                    @endif

                    @if(!empty($product->rating_avg))
                      <span><i class="bi bi-star-fill me-1"></i>{{ $product->rating_avg }}</span>
                    @endif
                  </div>

                  @if(!empty($tags))
                    <div class="products-card-pills">
                      @foreach(array_slice($tags, 0, 3) as $t)
                        <span>{{ $t }}</span>
                      @endforeach
                    </div>
                  @endif

                  <div class="products-card-price-row">
                    <div class="products-card-price-block">
                      @if(!empty($product->base_price))
                        <span class="products-card-price">₹{{ $product->base_price }}</span>
                      @else
                        <span class="products-card-price">₹—</span>
                      @endif

                      @if(!empty($product->compare_price))
                        <span class="products-card-price-old">₹{{ $product->compare_price }}</span>
                      @endif
                    </div>

                    @if($dispatch)
                      <span class="products-card-delivery">Dispatch: {{ $dispatch }}</span>
                    @endif
                  </div>

                  <div class="products-card-actions">
                   <form method="POST" action="{{ route('cart.add') }}">
    @csrf

    <input type="hidden" name="product_id" value="{{ $product->id }}">
    <input type="hidden" name="variant_id" value="">
    <input type="hidden" name="quantity" value="1">

    <button class="btn btn-sm btn-amtex products-card-btn w-100" type="submit">
        Add to Cart
    </button>
</form>

                    <a href="{{ route('frontend.products.show', $product->slug) }}" class="products-card-link">
                      View details
                      <i class="bi bi-arrow-right-short"></i>
                    </a>
                  </div>
                </div>

              </div>
            </article>
          </div>

        @empty
          <div class="col-12">
            <div class="alert alert-warning mb-0">
              No products found.
            </div>
          </div>
        @endforelse

      </div>

      {{-- Pagination --}}
      @if(isset($products) && $products->hasPages())
        <style>
          /* ========= Pagination Fix (scoped) ========= */
          .amtex-pagination-wrap nav {
            width: 100%;
          }
          .amtex-pagination-wrap .pagination {
            margin: 0;
            gap: 8px;
            justify-content: center;
            flex-wrap: wrap;
          }
          .amtex-pagination-wrap .page-item {
            margin: 0 !important;
          }
          .amtex-pagination-wrap .page-item .page-link {
            padding: 8px 12px !important;
            font-size: 14px !important;
            line-height: 1 !important;
            border-radius: 10px !important;
            min-width: 44px;
            height: 40px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            white-space: nowrap;
          }
          .amtex-pagination-wrap .page-item.active .page-link {
            font-weight: 600;
          }
          .amtex-pagination-wrap .page-item.disabled .page-link {
            opacity: .6;
          }
          .amtex-pagination-wrap .page-link:focus {
            box-shadow: none !important;
          }

          /* Safety clamp: if ANY SVG appears, keep it small */
          .amtex-pagination-wrap svg {
            width: 16px !important;
            height: 16px !important;
          }
        </style>

        <div class="mt-4 d-flex justify-content-center amtex-pagination-wrap">
          {{-- ✅ Force Bootstrap pagination (removes huge Tailwind SVG arrows) --}}
          {{ $products->withQueryString()->links('pagination::bootstrap-5') }}
        </div>
      @endif

      <!-- reassurance row -->
      <div class="products-reassure-strip mt-4">
        <div class="products-reassure-item">
          <i class="bi bi-truck"></i>
          Pan-India shipping on select models
        </div>
        <div class="products-reassure-item">
          <i class="bi bi-shield-lock"></i>
          Genuine Amtex products with warranty
        </div>
        <div class="products-reassure-item">
          <i class="bi bi-clipboard-check"></i>
          Assistance with audits &amp; compliance
        </div>
      </div>

    </div>
  </section>

  <!-- =================== PRODUCTS HELP CTA (LIGHT) =================== -->
  <section id="products-help-cta" class="section-padding-bottom">
    <div class="container">
      <div class="products-help-card row g-3 align-items-center">
        <div class="col-lg-8">
          <span class="products-help-eyebrow">
            <i class="bi bi-life-preserver me-1"></i>
            Need help choosing?
          </span>
          <h2 class="products-help-title">
            Not sure which model fits your site?
          </h2>
          <p class="products-help-text mb-0">
            Share your site details and we’ll suggest a product mix that matches your risk profile,
            budget and compliance requirements.
          </p>
        </div>
        <div class="col-lg-4 text-lg-end">
          <a href="#quick-enquiry" class="btn btn-amtex products-help-btn">
            Talk to our team
          </a>
        </div>
      </div>
    </div>
  </section>

</main>

@endsection