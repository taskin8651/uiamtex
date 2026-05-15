@extends('web_master')
@section('main')

@php
  use Illuminate\Support\Str;
  use Carbon\Carbon;

  $formatDate = function($date){
      if(!$date) return '';
      try { return Carbon::parse($date)->format('d M Y'); } catch(\Exception $e){ return (string)$date; }
  };

  $imgOrFallback = function($post){
      if($post && $post->featured_image && !empty($post->featured_image->url)) return $post->featured_image->url;
      return asset('assets/img/blog/blog-featured.jpg'); // fallback
  };

  $catName = function($post){
      return $post && $post->select_category ? $post->select_category->name : 'General';
  };
@endphp

<style>
/* =================== AMTEX BLOG FEATURED IMAGE FIX (UNIQUE) =================== */
.amtex-bl-featured-media-fix{
  position: relative;
  overflow: hidden;
  border-radius: 18px 0 0 18px;
  min-height: 100%;
}

/* Desktop: give a stable premium ratio */
@media (min-width: 992px){
  .amtex-bl-featured-media-fix{
    aspect-ratio: 16 / 11; /* you can tweak: 16/10 or 4/3 */
  }
}

/* Mobile: avoid huge height */
@media (max-width: 991.98px){
  .amtex-bl-featured-media-fix{
    border-radius: 18px 18px 0 0;
    aspect-ratio: 16 / 9;
  }
}

.amtex-bl-featured-media-fix .amtex-bl-featured-img-fix{
  width: 100%;
  height: 100%;
  display: block;
  object-fit: cover;     /* key: prevents stretch */
  object-position: center;
}

/* keep badge visible */
.amtex-bl-featured-media-fix .bl-featured-badge{
  position: absolute;
  top: 14px;
  left: 14px;
  z-index: 2;
}

/* optional: subtle overlay for readability */
.amtex-bl-featured-media-fix::after{
  content:"";
  position:absolute;
  inset:0;
  background: linear-gradient(180deg, rgba(0,0,0,.14), rgba(0,0,0,0));
  pointer-events:none;
}
</style>

<!-- =================== MAIN =================== -->
<main id="bl-main">

  <!-- =================== BLOG HERO =================== -->
  <section id="bl-hero" class="bl-pad">
    <div class="container">
      <div class="row g-4 align-items-center">

        <div class="col-lg-7">
          <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
            <span class="bl-pill">
              <i class="bi bi-journal-text me-1"></i> Amtex Blog
            </span>
            <span class="bl-pill bl-pill-dark">
              <i class="bi bi-shield-check me-1"></i> Safety • Compliance • Product Guides
            </span>
          </div>

          <h1 class="bl-title">
            Practical fire safety insights
            <span>for homes, offices & industries.</span>
          </h1>

          <p class="bl-subtitle">
            Read easy-to-understand guides on choosing the right extinguishers, maintaining compliance,
            and making your premises safer with modern protection solutions.
          </p>

          <div class="bl-tags d-flex flex-wrap gap-2">
            <a class="bl-tag" href="#"><i class="bi bi-fire me-1"></i>Extinguishers</a>
            <a class="bl-tag" href="#"><i class="bi bi-clipboard-check me-1"></i>Compliance</a>
            <a class="bl-tag" href="#"><i class="bi bi-droplet-half me-1"></i>Mist Tech</a>
            <a class="bl-tag" href="#"><i class="bi bi-tools me-1"></i>Maintenance</a>
          </div>
        </div>

        <div class="col-lg-5">
          <div class="bl-search-card">
            <div class="bl-search-head d-flex align-items-start justify-content-between gap-2">
              <div>
                <div class="bl-card-eyebrow">Find articles</div>
                <div class="bl-card-title">Search & filter</div>
              </div>
              <span class="bl-mini-chip">
                <i class="bi bi-lightning-charge-fill me-1"></i> Quick
              </span>
            </div>

            {{-- Hooked to backend NOW --}}
            <form class="row g-2 mt-2" method="GET" action="{{ route('frontend.blog') }}">
              <div class="col-12">
                <div class="bl-input-wrap">
                  <i class="bi bi-search"></i>
                  <input type="text" name="q" value="{{ request('q') }}" class="form-control bl-input"
                         placeholder="Search topics (e.g., CO₂, AMC, kitchen...)" />
                </div>
              </div>

              <div class="col-md-6">
                <select class="form-select bl-input" name="category">
                  <option value="">Category</option>
                  @foreach($categories as $cat)
                    <option value="{{ $cat->slug }}" {{ request('category') == $cat->slug ? 'selected' : '' }}>
                      {{ $cat->name }}
                    </option>
                  @endforeach
                </select>
              </div>

              <div class="col-md-6">
                <select class="form-select bl-input" name="sort">
                  <option value="latest" {{ request('sort','latest') == 'latest' ? 'selected' : '' }}>Latest</option>
                  <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest</option>
                </select>
              </div>

              <div class="col-12">
                <button type="submit" class="bl-btn w-100">
                  Apply filters
                </button>
              </div>
            </form>

          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- =================== FEATURED POST =================== -->
  @if($featuredPost)
  <section id="bl-featured" class="bl-pad bl-pad-tight">
    <div class="container">
      <div class="bl-featured-card row g-0 align-items-stretch">

        {{-- ✅ FIXED FEATURED IMAGE SIZE --}}
        <div class="col-lg-6 amtex-bl-featured-media-fix">
          <div class="bl-featured-badge">
            <i class="bi bi-stars me-1"></i> Featured
          </div>
          <img src="{{ $imgOrFallback($featuredPost) }}"
               alt="{{ $featuredPost->title }}"
               class="amtex-bl-featured-img-fix" />
        </div>

        <div class="col-lg-6">
          <div class="bl-featured-body">
            <div class="bl-meta">
              <span class="bl-chip">{{ $catName($featuredPost) }}</span>
              <span class="bl-meta-dot">•</span>
              <span><i class="bi bi-clock me-1"></i> {{ $featuredPost->read_time ?? '—' }}</span>
              <span class="bl-meta-dot">•</span>
              <span><i class="bi bi-calendar3 me-1"></i> {{ $formatDate($featuredPost->published_at) }}</span>
            </div>

            <h2 class="bl-featured-title">
              {{ $featuredPost->title }}
            </h2>

            <p class="bl-featured-text">
              {{ Str::limit(strip_tags($featuredPost->excerpt ?? ''), 180) }}
            </p>

            <div class="bl-featured-actions">
              <a href="{{ route('frontend.blog.show', $featuredPost->slug) }}" class="btn btn-amtex bl-read-btn">
                Read full article <i class="bi bi-arrow-right-short"></i>
              </a>
              <a href="#bl-grid" class="bl-link">
                Browse all posts <i class="bi bi-arrow-down-short"></i>
              </a>
            </div>

            <div class="bl-mini-stats">
              <div class="bl-stat">
                <div class="bl-stat-num">Guides</div>
                <div class="bl-stat-label">easy to apply</div>
              </div>
              <div class="bl-stat">
                <div class="bl-stat-num">Practical</div>
                <div class="bl-stat-label">site focused</div>
              </div>
              <div class="bl-stat">
                <div class="bl-stat-num">Updated</div>
                <div class="bl-stat-label">with standards</div>
              </div>
            </div>

          </div>
        </div>

      </div>
    </div>
  </section>
  @endif

  <!-- =================== BLOG GRID + SIDEBAR =================== -->
  <section id="bl-grid" class="bl-pad">
    <div class="container">
      <div class="row g-4">

        <!-- POSTS -->
        <div class="col-lg-8">

          <div class="bl-grid-head d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
            <div class="d-flex align-items-center gap-2">
              <span class="bl-count-pill">
                <i class="bi bi-stack me-1"></i>
                Showing {{ $posts->count() }} posts
              </span>
              <span class="bl-soft-hint d-none d-sm-inline-flex">
                Tip: Use search to find specific extinguisher types.
              </span>
            </div>

            <div class="bl-view d-none d-md-flex">
              <button class="bl-view-btn active" type="button" aria-label="Grid view">
                <i class="bi bi-grid-3x3-gap"></i>
              </button>
              <button class="bl-view-btn" type="button" aria-label="List view">
                <i class="bi bi-menu-button-wide"></i>
              </button>
            </div>
          </div>

          <div class="row g-3 g-md-4">

            @forelse($posts as $post)
              <div class="col-md-6">
                <article class="bl-card">
                  <a href="{{ route('frontend.blog.show', $post->slug) }}" class="bl-card-media">
                    <img src="{{ $imgOrFallback($post) }}" alt="{{ $post->title }}" class="bl-card-img" />
                    <span class="bl-card-badge">{{ $catName($post) }}</span>
                  </a>

                  <div class="bl-card-body">
                    <div class="bl-meta bl-meta-small">
                      <span><i class="bi bi-clock me-1"></i> {{ $post->read_time ?? '—' }}</span>
                      <span class="bl-meta-dot">•</span>
                      <span><i class="bi bi-calendar3 me-1"></i> {{ $formatDate($post->published_at) }}</span>
                    </div>

                    <h3 class="bl-card-title">
                      <a href="{{ route('frontend.blog.show', $post->slug) }}">{{ $post->title }}</a>
                    </h3>

                    <p class="bl-card-text">
                      {{ Str::limit(strip_tags($post->excerpt ?? ''), 120) }}
                    </p>

                    <div class="bl-card-actions">
                      <a href="{{ route('frontend.blog.show', $post->slug) }}" class="bl-read">
                        Read more <i class="bi bi-arrow-right-short"></i>
                      </a>
                      <button class="bl-save" type="button" aria-label="Save post">
                        <i class="bi bi-bookmark"></i>
                      </button>
                    </div>
                  </div>
                </article>
              </div>
            @empty
              <div class="col-12">
                <div class="alert alert-light border">
                  <strong>No posts found.</strong> Try clearing filters or searching with different keywords.
                </div>
              </div>
            @endforelse

          </div>

          {{-- Laravel Pagination --}}
          @if($posts->hasPages())
            <div class="mt-4">
              {{ $posts->links() }}
            </div>
          @endif

        </div>

        <!-- SIDEBAR -->
        <div class="col-lg-4">
          <div class="bl-sidebar">

            <div class="bl-side-card">
              <div class="bl-side-title">
                <i class="bi bi-fire me-1"></i> Categories
              </div>

              <div class="bl-topic-list">
                <a href="{{ route('frontend.blog') }}" class="bl-topic">
                  <span>All</span><i class="bi bi-arrow-right-short"></i>
                </a>

                @foreach($categories as $cat)
                  <a href="{{ route('frontend.blog', ['category' => $cat->slug]) }}" class="bl-topic">
                    <span>{{ $cat->name }}</span><i class="bi bi-arrow-right-short"></i>
                  </a>
                @endforeach
              </div>
            </div>

            <div class="bl-side-card bl-side-card-dark">
              <div class="bl-side-title text-white">
                Get expert help
              </div>
              <p class="bl-side-text">
                Not sure what fits your site? Share details and we’ll suggest a safe, compliant solution.
              </p>
              <a href="products.html" class="btn btn-amtex w-100 bl-side-btn">Browse products</a>
              <a href="#quick-enquiry" class="btn btn-light w-100 fw-semibold mt-2 bl-side-btn2">Talk to our team</a>
            </div>

            <div class="bl-side-card">
              <div class="bl-side-title">
                <i class="bi bi-envelope me-1"></i> Newsletter
              </div>
              <p class="bl-side-text text-muted">
                Monthly safety updates (no spam).
              </p>
              <div class="bl-input-wrap mb-2">
                <i class="bi bi-at"></i>
                <input type="email" class="form-control bl-input" placeholder="Email address" />
              </div>
              <button class="bl-btn w-100" type="button">Subscribe</button>
              <div class="bl-note mt-2">
                <i class="bi bi-lock-fill me-1"></i> We never share your email.
              </div>
            </div>

          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- =================== BLOG CTA =================== -->
  <section id="bl-cta" class="bl-pad bl-pad-tight">
    <div class="container">
      <div class="bl-cta-card row g-3 align-items-center">
        <div class="col-lg-8">
          <span class="bl-cta-eyebrow">
            <i class="bi bi-life-preserver me-1"></i> Need help choosing?
          </span>
          <h2 class="bl-cta-title mb-1">Get the right product mix for your premises.</h2>
          <p class="bl-cta-text mb-0">
            Share your site type and risk zone — our team will suggest a compliant, effective solution.
          </p>
        </div>
        <div class="col-lg-4 text-lg-end">
          <a href="#quick-enquiry" class="btn btn-amtex bl-cta-btn">Talk to our team</a>
        </div>
      </div>
    </div>
  </section>

</main>

@endsection
