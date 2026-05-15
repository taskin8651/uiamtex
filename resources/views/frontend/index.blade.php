@extends('web_master')
@section('main')

<main>

    <!-- =================== HERO SLIDER =================== -->
    <section id="hero-slider">
        @php
            $homeHeroes = $homeHeroes ?? collect();

            // ✅ Only keep slides that have at least one meaningful content element
            // (image or any text fields). Otherwise the whole hero section stays hidden.
            $homeHeroes = $homeHeroes->filter(function ($hero) {
                $hasDesktop = !empty($hero->desktop_image);
                $hasMobile  = !empty($hero->mobile_image);

                $hasText =
                    !empty($hero->badge_text) ||
                    !empty($hero->title_line_1) ||
                    !empty($hero->title_highlight) ||
                    !empty($hero->subtitle) ||
                    (!empty($hero->cta_text) && !empty($hero->cta_url)) ||
                    !empty($hero->meta_text);

                return $hasDesktop || $hasMobile || $hasText;
            })->values();

            $hasSlides = $homeHeroes->count() > 0;
            $hasMany   = $homeHeroes->count() > 1;
        @endphp

        @if($hasSlides)
            <div id="homeHeroCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="6000">

                {{-- Indicators (only if more than 1 slide) --}}
                @if($hasMany)
                    <div class="carousel-indicators hero-indicators">
                        @foreach($homeHeroes as $index => $hero)
                            <button
                                type="button"
                                data-bs-target="#homeHeroCarousel"
                                data-bs-slide-to="{{ $index }}"
                                class="{{ $index === 0 ? 'active' : '' }}"
                                aria-current="{{ $index === 0 ? 'true' : 'false' }}"
                                aria-label="Slide {{ $index + 1 }}"
                            ></button>
                        @endforeach
                    </div>
                @endif

                <div class="carousel-inner">

                    @foreach($homeHeroes as $index => $hero)
                        @php
                            // Content flags (per slide)
                            $hasBadge    = !empty($hero->badge_text);
                            $hasTitle    = !empty($hero->title_line_1) || !empty($hero->title_highlight);
                            $hasSubtitle = !empty($hero->subtitle);
                            $hasCTA      = !empty($hero->cta_text) && !empty($hero->cta_url);
                            $hasMeta     = !empty($hero->meta_text);

                            // ✅ If no content at all for overlay/card area, hide that entire block
                            $hasOverlayContent = $hasBadge || $hasTitle || $hasSubtitle || $hasCTA || $hasMeta;

                            // Fallback alt text
                            $altText = $hero->title_line_1
                                ? trim(($hero->title_line_1.' '.$hero->title_highlight))
                                : ($siteSetting->site_name ?? 'Hero Slide');

                            // Images (stored paths like "home-hero/xyz.jpg")
                            $desktopSrc = !empty($hero->desktop_image)
                                ? asset('storage/'.$hero->desktop_image)
                                : asset('frontend/assets/img/hero_one.png');

                            $mobileSrc = !empty($hero->mobile_image)
                                ? asset('storage/'.$hero->mobile_image)
                                : asset('frontend/assets/img/hero_one_mobile.png');
                        @endphp

                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                            <div class="hero-slide">

                                <!-- Desktop image -->
                                <img
                                    src="{{ $desktopSrc }}"
                                    class="hero-bg-img hero-img-desktop"
                                    alt="{{ $altText }}"
                                >

                                <!-- Mobile image -->
                                <img
                                    src="{{ $mobileSrc }}"
                                    class="hero-bg-img hero-img-mobile"
                                    alt="{{ $altText }} Mobile"
                                >

                                {{-- ✅ Only show overlay + content area if there is any content --}}
                                @if($hasOverlayContent)
                                    <div class="hero-overlay"></div>

                                    <div class="container hero-content-wrap">
                                        <div class="row hero-layout">
                                            <div class="col-lg-6">

                                                <div class="hero-card">

                                                    {{-- Badge --}}
                                                    @if($hasBadge)
                                                        <span class="hero-badge">
                                                            @if(!empty($hero->badge_icon))
                                                                <i class="{{ $hero->badge_icon }} me-1"></i>
                                                            @endif
                                                            {{ $hero->badge_text }}
                                                        </span>
                                                    @endif

                                                    {{-- Title --}}
                                                    @if($hasTitle)
                                                        <h1 class="hero-title">
                                                            {{ $hero->title_line_1 ?? '' }}
                                                            @if(!empty($hero->title_highlight))
                                                                <span>{{ $hero->title_highlight }}</span>
                                                            @endif
                                                        </h1>
                                                    @endif

                                                    {{-- Subtitle --}}
                                                    @if($hasSubtitle)
                                                        <p class="hero-subtitle">
                                                            {!! $hero->subtitle !!}
                                                        </p>
                                                    @endif

                                                    @if($hasCTA || $hasMeta)
                                                        <div class="d-flex flex-wrap gap-3 align-items-center">

                                                            {{-- CTA Button --}}
                                                            @if($hasCTA)
                                                                <a href="{{ url($hero->cta_url) }}" class="btn btn-amtex btn-lg px-4">
                                                                    {{ $hero->cta_text }}
                                                                </a>
                                                            @endif

                                                            {{-- Meta --}}
                                                            @if($hasMeta)
                                                                <div class="hero-meta">
                                                                    <span class="dot"></span>
                                                                    {{ $hero->meta_text }}
                                                                </div>
                                                            @endif

                                                        </div>
                                                    @endif

                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                @endif

                            </div>
                        </div>
                    @endforeach

                </div>

                {{-- Controls (only if more than 1 slide) --}}
                @if($hasMany)
                    <button class="carousel-control-prev hero-control" type="button" data-bs-target="#homeHeroCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>

                    <button class="carousel-control-next hero-control" type="button" data-bs-target="#homeHeroCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>
                @endif

            </div>
        @endif
    </section>

    <!-- =================== CERTIFICATIONS =================== -->
    <section id="certifications" class="section-padding">
        <div class="container">
            <div class="cert-premium-clean">

                <div class="cert-head text-center">
                    <span class="cert-kicker">Recognised & Trusted</span>
                    <h2 class="cert-title">Certifications & Compliance</h2>
                </div>

                @if(isset($certifications) && $certifications->count() > 0)
                    <div class="cert-logo-marquee">
                        <div class="cert-logo-track">

                            {{-- First Set --}}
                            @foreach($certifications as $certification)
                                @if($certification->image)
                                    <div class="cert-logo-item">
                                        <div class="cert-logo-box">
                                            <img
                                                src="{{ $certification->image->url }}"
                                                alt="{{ $certification->title ?? 'Certification Logo' }}"
                                                loading="lazy"
                                            >
                                        </div>
                                    </div>
                                @endif
                            @endforeach

                            {{-- Duplicate Set For Infinite Scroll --}}
                            @foreach($certifications as $certification)
                                @if($certification->image)
                                    <div class="cert-logo-item">
                                        <div class="cert-logo-box">
                                            <img
                                                src="{{ $certification->image->url }}"
                                                alt="{{ $certification->title ?? 'Certification Logo' }}"
                                                loading="lazy"
                                            >
                                        </div>
                                    </div>
                                @endif
                            @endforeach

                        </div>
                    </div>
                @endif

            </div>
        </div>
    </section>

    <!-- =================== CLIENT CAROUSEL =================== -->
    <section id="client-carousel" class="section-padding">
        <div class="container">

            <!-- Heading -->
            <div class="text-center mb-3 mb-md-4">
                <span class="client-eyebrow">Trusted by leading organisations</span>
                <h2 class="client-title mb-1">Our Clients</h2>
                <p class="client-subtitle mb-0">
                    From government departments to corporates and institutions, Amtex Safety protects
                    critical facilities across India.
                </p>
            </div>

            <!-- Context tags -->
            <div class="client-tags d-flex flex-wrap justify-content-center gap-2 mb-4 mb-md-5">
                <span class="client-tag">
                    <i class="bi bi-building"></i>
                    Govt &amp; PSU
                </span>
                <span class="client-tag">
                    <i class="bi bi-briefcase"></i>
                    Corporate Offices
                </span>
                <span class="client-tag">
                    <i class="bi bi-mortarboard"></i>
                    Institutions &amp; Campuses
                </span>
            </div>

            @if(isset($clients) && $clients->count())
                <div class="client-marquee-shell">
                    <div class="client-marquee">
                        <div class="client-track">

                            {{-- First Set --}}
                            @foreach($clients as $client)
                                @php
                                    $logoUrl = !empty($client->logo) ? $client->logo->url : asset('frontend/assets/img/clients/placeholder.png');
                                    $altText = $client->name ? $client->name : 'Client';
                                @endphp

                                <div class="client-item">
                                    <div class="client-card" title="{{ $altText }}">
                                        <div class="client-logo-wrap">
                                            <img src="{{ $logoUrl }}" alt="{{ $altText }}" class="client-logo" />
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            {{-- Duplicate Set for seamless infinite scroll --}}
                            @foreach($clients as $client)
                                @php
                                    $logoUrl = !empty($client->logo) ? $client->logo->url : asset('frontend/assets/img/clients/placeholder.png');
                                    $altText = $client->name ? $client->name : 'Client';
                                @endphp

                                <div class="client-item">
                                    <div class="client-card" title="{{ $altText }}">
                                        <div class="client-logo-wrap">
                                            <img src="{{ $logoUrl }}" alt="{{ $altText }}" class="client-logo" />
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            @else
                <div class="text-center text-muted">
                    No clients added yet.
                </div>
            @endif

        </div>
    </section>

    <!-- =================== WHY AMTEX =================== -->
    <section id="why-amtex" class="section-padding">
        <div class="container">
            <div class="why-amtex-shell">
                <div class="row align-items-center gy-4 gy-lg-0">

                    <!-- Left: Image / Visual -->
                    <div class="col-lg-5">
                        <div class="why-image-wrap">
                            <div class="why-image-gradient"></div>

                            <img
                                src="{{ asset('frontend/assets/img/about.png') }}"
                                alt="Amtex Safety Systems fire protection solutions"
                                class="why-image"
                            />

                            <!-- Top chip -->
                            <div class="why-floating-chip">
                                <i class="bi bi-award-fill me-1"></i>
                                BIS &amp; IS Compliant
                            </div>
                        </div>
                    </div>

                    <!-- Right: Content -->
                    <div class="col-lg-7">
                        <div class="why-content">
                            <span class="why-eyebrow">Why Amtex Safety Systems</span>

                            <h2 class="why-title">
                                Trusted Fire Protection Solutions for Homes, Industries &amp; Infrastructure
                            </h2>

                            <p class="why-subtitle">
                                Amtex Safety Systems manufactures certified fire extinguishers and advanced
                                suppression technologies designed for real-world fire risks.
                            </p>

                            <p class="why-subtitle why-subtitle-secondary">
                                Our solutions comply with BIS and IS standards and are trusted across
                                residential, commercial and industrial environments.
                            </p>

                            <div class="why-tags">
                                <span class="why-tag">Homes &amp; Apartments</span>
                                <span class="why-tag">Commercial Spaces</span>
                                <span class="why-tag">Industries &amp; Infrastructure</span>
                            </div>

                            <!-- Premium feature content panel -->
                            <div class="why-feature-panel">
                                <div class="why-feature-accent"></div>

                                <div class="why-feature-body">
                                    <span class="why-feature-kicker">Integrated Safety Ecosystem</span>

                                    <h3 class="why-feature-heading">
                                        Complete Fire Protection Systems &amp; Technologies
                                    </h3>

                                    <p class="why-feature-text">
                                        Comprehensive range of fire protection equipment including all kinds of
                                        first-aid fire extinguishers, along with advanced fire suppression systems,
                                        detection systems, alarms, hydrant systems and safety accessories.
                                    </p>

                                    <p class="why-feature-text mb-0">
                                        Amtex also provides installation guidance, refilling, inspection and
                                        compliance support for diverse fire safety requirements.
                                    </p>
                                </div>
                            </div>

                            <!-- Premium trust strip -->
                            <div class="why-trust-strip">
                                <div class="why-trust-item">
                                    <span class="why-trust-key">BIS</span>
                                    <span class="why-trust-value">Standards Compliant</span>
                                </div>

                                <div class="why-trust-divider"></div>

                                <div class="why-trust-item">
                                    <span class="why-trust-key">IS</span>
                                    <span class="why-trust-value">Certified Solutions</span>
                                </div>

                                <div class="why-trust-divider"></div>

                                <div class="why-trust-item">
                                    <span class="why-trust-key">360°</span>
                                    <span class="why-trust-value">Support &amp; Compliance</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

<!-- =================== OUR WORK / IMAGE GALLERY =================== -->
<section id="our-work" class="section-padding">
    <div class="container">

        <!-- Heading -->
        <div class="text-center mb-4 mb-md-5">
            <span class="ourwork-eyebrow">Real-world deployments</span>
            <h2 class="ourwork-title mb-0">Our Work &amp; Installations</h2>
        </div>

        @php
            $cards = collect();

            if (isset($workGalleries)) {
                foreach ($workGalleries as $gallery) {
                    $imgUrl = '';

                    if (!empty($gallery->image)) {
                        $imgUrl = str_starts_with($gallery->image, 'http')
                            ? $gallery->image
                            : asset($gallery->image);
                    }

                    if (!empty($imgUrl)) {
                        $cards->push([
                            'img'   => $imgUrl,
                            'title' => $gallery->title ?? 'Work Installation',
                            'desc'  => 'Installation',
                        ]);
                    }
                }
            }

            $cards = $cards->values();
        @endphp

        @if($cards->count())
            <div class="ourwork-marquee-shell">

                <!-- Navigation Buttons -->
                <div class="ourwork-controls">
                    <button type="button" class="ourwork-nav ourwork-nav-prev" aria-label="Previous">
                        <i class="bi bi-arrow-left"></i>
                    </button>

                    <button type="button" class="ourwork-nav ourwork-nav-next" aria-label="Next">
                        <i class="bi bi-arrow-right"></i>
                    </button>
                </div>

                <!-- Marquee -->
                <div class="ourwork-marquee" id="ourworkMarquee">
                    <div class="ourwork-track" id="ourworkTrack">

                        {{-- First Set --}}
                        @foreach($cards as $card)
                            <a href="#"
                               class="ourwork-item"
                               data-bs-toggle="modal"
                               data-bs-target="#workPreviewModal"
                               data-img="{{ $card['img'] }}"
                               data-title="{{ $card['title'] }}"
                               data-desc="{{ $card['desc'] }}">
                                <div class="ourwork-frame">
                                    <img src="{{ $card['img'] }}"
                                         alt="{{ $card['title'] }}"
                                         class="ourwork-img">
                                </div>
                            </a>
                        @endforeach

                        {{-- Duplicate Set for infinite smooth loop --}}
                        @foreach($cards as $card)
                            <a href="#"
                               class="ourwork-item"
                               data-bs-toggle="modal"
                               data-bs-target="#workPreviewModal"
                               data-img="{{ $card['img'] }}"
                               data-title="{{ $card['title'] }}"
                               data-desc="{{ $card['desc'] }}">
                                <div class="ourwork-frame">
                                    <img src="{{ $card['img'] }}"
                                         alt="{{ $card['title'] }}"
                                         class="ourwork-img">
                                </div>
                            </a>
                        @endforeach

                    </div>
                </div>
            </div>
        @else
            <div class="alert alert-warning mb-0">
                No work images found. Please add images from Admin panel.
            </div>
        @endif

    </div>
</section>

<!-- =================== WORK IMAGE PREVIEW MODAL =================== -->
<div class="modal fade" id="workPreviewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content work-modal">

            <div class="modal-header work-modal-header">
                <div>
                    <h5 class="modal-title mb-0" id="workModalTitle">Preview</h5>
                    <p class="work-modal-subtitle mb-0" id="workModalDesc"></p>
                </div>
                <button type="button"
                        class="btn-close work-modal-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>

            <div class="modal-body p-0">
                <div class="work-modal-imgwrap">
                    <img src="" alt="Work preview" id="workModalImg" class="work-modal-img">
                </div>
            </div>

        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {

        document.querySelectorAll('a.ourwork-item[data-bs-toggle="modal"]').forEach(function (el) {
            el.addEventListener('click', function (e) {
                e.preventDefault();
            });
        });

        var modalEl = document.getElementById('workPreviewModal');
        if (!modalEl) return;

        modalEl.addEventListener('show.bs.modal', function (event) {
            var trigger = event.relatedTarget;
            if (!trigger) return;

            var img   = trigger.getAttribute('data-img') || '';
            var title = trigger.getAttribute('data-title') || 'Preview';
            var desc  = trigger.getAttribute('data-desc') || '';

            var imgEl = document.getElementById('workModalImg');
            var tEl   = document.getElementById('workModalTitle');
            var dEl   = document.getElementById('workModalDesc');

            if (imgEl) {
                imgEl.src = img;
                imgEl.alt = title;
            }

            if (tEl) tEl.textContent = title;
            if (dEl) dEl.textContent = desc;
        });

        modalEl.addEventListener('hidden.bs.modal', function () {
            var imgEl = document.getElementById('workModalImg');
            if (imgEl) imgEl.src = '';
        });
    });
</script>
@endpush

   <!-- =================== FEATURED PRODUCTS =================== -->
@php
    // Safety
    $featuredProducts = $featuredProducts ?? collect();
    $featuredCategories = $featuredCategories ?? collect();

    // Hide whole section if nothing
    $hasFeatured = $featuredProducts->count() > 0;

    // Helper: stars from rating_avg (0-5)
    $renderStars = function($avg){
        $avg = is_null($avg) ? null : (float)$avg;
        if(!$avg) return '☆☆☆☆☆';
        $full = (int) floor($avg);
        $half = (($avg - $full) >= 0.5) ? 1 : 0;
        $empty = 5 - $full - $half;
        return str_repeat('★', $full) . ($half ? '½' : '') . str_repeat('☆', $empty);
    };
@endphp

@if($hasFeatured)
<section id="featured-products" class="section-padding">
    <div class="container">

        <!-- Panel wrapper for premium card feel -->
        <div class="fp-panel">

            <!-- Heading + Filters -->
            <div class="row align-items-center mb-4 mb-md-5 g-3">
                <div class="col-md-6">
                    <span class="fp-eyebrow">Top Picks from Amtex</span>
                    <h2 class="fp-title mb-1">Featured Products</h2>
                    <p class="fp-subtitle mb-0">
                        Signature mist retardant extinguishers, kitchen safety units and industrial solutions – ready to dispatch.
                    </p>
                </div>

                <div class="col-md-6 d-flex flex-wrap justify-content-md-end gap-2">
                    <button type="button" class="fp-chip active" data-filter="all">All</button>

                    {{-- ✅ Dynamic category chips (max 3 like static UI) --}}
                    @foreach($featuredCategories as $cat)
                        @php
                            $slug = $cat->slug ?? ('cat-'.$cat->id);
                            $label = $cat->name ?? 'Category';
                        @endphp
                        <button type="button" class="fp-chip" data-filter="{{ $slug }}">
                            {{ $label }}
                        </button>
                    @endforeach

                    <a href="{{ route('frontend.products.index') }}" class="fp-view-all d-inline-flex align-items-center">
                        View All
                        <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>

            <!-- Products grid -->
            <div class="row g-3 g-lg-4">

                @foreach($featuredProducts as $p)
                    @php
                        $catName = optional($p->select_category)->name ?? 'PRODUCT';
                        $catSlug = optional($p->select_category)->slug ?? 'all';

                        // Badge
                        $badge = $p->badge ?? null; // "New" / "Best Seller" etc.

                        // Image (Spatie accessor)
                        $imgUrl = $p->main_image?->url ?? asset('frontend/assets/img/product/product-1.png');

                        // Rating
                        $avg = $p->rating_avg ? (float)$p->rating_avg : null;
                        $cnt = $p->rating_count ? (int)$p->rating_count : null;

                        // Pills (use PDP tags if you want)
                        $pills = is_array($p->pdp_tags) ? $p->pdp_tags : [];
                        $pills = array_values(array_filter($pills, fn($x) => trim((string)$x) !== ''));
                        $pills = array_slice($pills, 0, 3);

                        // Price
                        $price = $p->base_price;
                        $compare = $p->compare_price;

                        // Dispatch
                        $dispatch = $p->dispatch_text ?? null;

                        // Link
                        $detailUrl = route('frontend.products.show', $p->slug);
                    @endphp

                    <div class="col-6 col-md-4 col-lg-3">
                        <article class="product-card h-100" data-category="{{ $catSlug }}">
                            <div class="product-card-inner">

                                <div class="product-image-wrap">

                                    @if(!empty($badge))
                                        <span class="product-badge {{ $badge === 'New' ? 'badge-secondary' : '' }}">
                                            {{ strtoupper($badge) }}
                                        </span>
                                    @endif

                                    <button class="product-fav" type="button" aria-label="Add to wishlist">
                                        <i class="bi bi-heart"></i>
                                    </button>

                                    <img
                                        src="{{ $imgUrl }}"
                                        alt="{{ $p->name }}"
                                        class="product-image"
                                        loading="lazy"
                                    />
                                </div>

                                <div class="product-body">
                                    <div class="product-category">{{ strtoupper($catName) }}</div>

                                    <h3 class="product-name">{{ $p->name }}</h3>

                                    <div class="product-rating">
                                        <span class="stars">
                                            @if($avg)
                                                {{ $renderStars($avg) }}
                                            @else
                                                ★★★★☆
                                            @endif
                                        </span>
                                        <span class="rating-count">
                                            @if($avg)
                                                {{ number_format($avg, 1) }}{{ $cnt ? " ({$cnt})" : '' }}
                                            @else
                                                —
                                            @endif
                                        </span>
                                    </div>

                                    @if(!empty($pills))
                                        <div class="product-pills">
                                            @foreach($pills as $pill)
                                                <span class="pill">{{ $pill }}</span>
                                            @endforeach
                                        </div>
                                    @endif

                                    <div class="product-price-row">
                                        <div>
                                            @if(!empty($price))
                                                <span class="product-price">₹{{ number_format((float)$price) }}</span>
                                            @else
                                                <span class="product-price">Contact</span>
                                            @endif

                                            @if(!empty($compare) && !empty($price) && (float)$compare > (float)$price)
                                                <span class="product-price-old">₹{{ number_format((float)$compare) }}</span>
                                            @endif
                                        </div>

                                        <span class="product-delivery">
                                            {{ $dispatch ? "Dispatch: {$dispatch}" : 'Dispatch timelines vary' }}
                                        </span>
                                    </div>
                                </div>

                                <div class="product-actions">
                                    <button class="btn btn-sm btn-amtex w-100 mb-1" type="button">
                                        Add to Cart
                                    </button>
                                    <a href="{{ $detailUrl }}" class="btn btn-sm btn-outline-dark w-100">
                                        View Details
                                    </a>
                                </div>

                            </div>
                        </article>
                    </div>
                @endforeach

            </div>

            <!-- Optional small reassurance strip -->
            <div class="fp-meta-strip">
                <span><i class="bi bi-truck"></i> Pan-India shipping*</span>
                <span><i class="bi bi-shield-lock"></i> Genuine Amtex products</span>
                <span><i class="bi bi-clock-history"></i> Fast dispatch on select items</span>
            </div>

        </div>
    </div>

    {{-- ✅ Filter script (All + Category chips) --}}
    <script>
        (function(){
            const chips = document.querySelectorAll('#featured-products .fp-chip');
            const cards = document.querySelectorAll('#featured-products .product-card');

            function setActive(btn){
                chips.forEach(c => c.classList.remove('active'));
                btn.classList.add('active');
            }

            function applyFilter(filter){
                cards.forEach(card => {
                    const cat = (card.getAttribute('data-category') || 'all').toLowerCase();
                    const show = (filter === 'all') || (cat === filter);
                    card.closest('.col-6, .col-md-4, .col-lg-3')?.classList.toggle('d-none', !show);

                    // Fallback if closest selector fails (old browsers)
                    if (!card.closest('.col-6, .col-md-4, .col-lg-3')) {
                        card.parentElement?.classList.toggle('d-none', !show);
                    }
                });
            }

            chips.forEach(btn => {
                btn.addEventListener('click', function(){
                    const filter = (this.getAttribute('data-filter') || 'all').toLowerCase();
                    setActive(this);
                    applyFilter(filter);
                });
            });

            // default
            applyFilter('all');
        })();
    </script>

</section>
@endif

    <!-- =================== UPGRADE PROMO =================== -->
    <section id="upgrade-promo" class="section-padding">
        <div class="container">
            <div class="row align-items-center gy-4">

            <!-- LEFT CONTENT -->
            <div class="col-lg-6">
                <div class="upgrade-content">

                <span class="upgrade-eyebrow">
                    <i class="bi bi-arrow-repeat me-1"></i>
                    Technology Upgrade Program
                </span>

                <h2 class="upgrade-title">
                    Upgrade to <span>Modern Fire Protection</span>
                </h2>

                <p class="upgrade-subtitle">
                    Older powder-based fire extinguishers can be replaced or upgraded
                    with newer fire suppression technologies such as
                    <strong>Water Mist Fire Extinguishers</strong>, offering cleaner
                    discharge and improved safety for modern environments.
                </p>

                <ul class="upgrade-list">
                    <li><i class="bi bi-check2-circle"></i> Minimal residue and reduced secondary damage</li>
                    <li><i class="bi bi-check2-circle"></i> Suitable for people, electronics and enclosed spaces</li>
                    <li><i class="bi bi-check2-circle"></i> Compliance with applicable fire safety standards</li>
                </ul>

                <!-- Process steps -->
                <div class="upgrade-steps">
                    <div class="upgrade-step">
                    <span class="upgrade-step-number">1</span>
                    <span>Assessment of existing fire extinguisher</span>
                    </div>
                    <div class="upgrade-step">
                    <span class="upgrade-step-number">2</span>
                    <span>Recommendation of suitable modern solution</span>
                    </div>
                    <div class="upgrade-step">
                    <span class="upgrade-step-number">3</span>
                    <span>Supply and commissioning as per requirement</span>
                    </div>
                </div>

                <!-- CTA -->
                <a href="#" class="btn btn-amtex btn-lg mt-2 upgrade-cta">
                    Request Upgrade Consultation
                </a>

                </div>
            </div>

            <!-- RIGHT IMAGE -->
            <div class="col-lg-6">
                <div class="upgrade-image-wrap">
                <div class="upgrade-glow"></div>

                <img
                    src="{{ asset('frontend/assets/img/upgrade-extinguisher.png') }}"
                    alt="Fire Extinguisher Technology Upgrade"
                    class="upgrade-image"
                />

                <!-- Main badge -->
                <div class="upgrade-badge">
                    <i class="bi bi-stars"></i>
                    Advanced Fire Suppression
                </div>

                <!-- Floating tags -->
                <div class="upgrade-floating-tag upgrade-tag-top">
                    <i class="bi bi-droplet-half"></i>
                    Cleaner fire control
                </div>

                <div class="upgrade-floating-tag upgrade-tag-mid">
                    <i class="bi bi-activity"></i>
                    Efficient fire knockdown
                </div>
                </div>
            </div>

            </div>
        </div>
    </section>

    <!-- =================== DEALERSHIP PROMO =================== -->
    <section id="dealership-promo" class="section-padding">
        <div class="container">
            <div class="dealership-card row align-items-center gy-4">

            <!-- Left content -->
            <div class="col-lg-8">
                <span class="dealership-eyebrow">
                <i class="bi bi-people-fill me-1"></i>
                Channel Partner Program
                </span>

                <h2 class="dealership-title mb-2">
                Become an <span>Authorised Amtex Partner</span>
                </h2>

                <p class="dealership-subtitle mb-3 mb-lg-4">
                Collaborate with Amtex Safety Systems as an authorised dealer or service partner
                and represent a trusted portfolio of certified fire extinguishers and fire
                suppression solutions across residential, commercial and industrial segments.
                </p>

                <!-- Benefit pills -->
                <div class="dealership-pills mb-3 mb-lg-0">
                <span class="pill">
                    <i class="bi bi-box-seam"></i>
                    Certified product portfolio
                </span>
                <span class="pill">
                    <i class="bi bi-mortarboard"></i>
                    Product &amp; technical guidance
                </span>
                <span class="pill">
                    <i class="bi bi-geo-alt"></i>
                    Regional sales &amp; service opportunities
                </span>
                </div>
            </div>

            <!-- Right CTA / info -->
            <div class="col-lg-4">
                <div class="dealership-cta text-lg-end">

                <!-- Info block -->
                <div class="dealership-stat">
                    <div class="stat-number">Pan-India</div>
                    <div class="stat-label">Dealer &amp; service network</div>
                </div>

                <!-- Availability line -->
                <div class="dealership-availability">
                    <span class="dot-live"></span>
                    New channel partnerships considered on application
                </div>

                <!-- CTA button -->
                <a href="#" class="btn btn-amtex dealership-cta-btn">
                    Enquire for Partnership
                </a>

                <!-- Small note -->
                <p class="dealership-note small mb-0">
                    Partnership subject to evaluation and regional requirements.
                </p>
                </div>
            </div>

            </div>
        </div>
    </section>

    <!-- =================== BLOG TEASER =================== -->
    <section id="blog-teaser" class="section-padding">
        <div class="container">

            @php
                use Illuminate\Support\Str;
                use Carbon\Carbon;

                $imgOrFallback = function($post){
                    if($post && $post->featured_image && !empty($post->featured_image->url)) return $post->featured_image->url;
                    return asset('frontend/assets/img/blog/blog-1.png'); // fallback
                };

                $catName = function($post){
                    return $post && $post->select_category ? $post->select_category->name : 'General';
                };
            @endphp

            <!-- Heading row -->
            <div class="row align-items-end mb-4 mb-md-5 g-2">
                <div class="col-md-7">
                    <span class="blog-eyebrow">Insights &amp; Resources</span>
                    <h2 class="blog-title mb-1">Latest from Our Blog</h2>
                    <p class="blog-subtitle mb-0">
                        Practical tips, compliance updates and product insights to help you keep your premises fire-safe.
                    </p>
                </div>

                <div class="col-md-5 text-md-end mt-3 mt-md-0">
                    <a href="{{ route('frontend.blog') }}" class="blog-view-all d-inline-flex align-items-center">
                        View all articles
                        <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>

            <!-- Blog cards -->
            <div class="row g-3 g-md-4">

                @forelse($latestBlogPosts as $post)
                    <div class="col-md-4">
                        <article class="blog-card h-100">
                            <div class="blog-image-wrap">
                                <img src="{{ $imgOrFallback($post) }}" alt="{{ $post->title }}" class="blog-image" />
                                <span class="blog-category">{{ $catName($post) }}</span>
                            </div>

                            <div class="blog-body">
                                <div class="blog-meta">
                                    <span>{{ $catName($post) }}</span>
                                    <span class="dot"></span>
                                    <span>{{ $post->read_time ?? '—' }}</span>
                                </div>

                                <h3 class="blog-heading">
                                    {{ Str::limit($post->title ?? '', 65) }}
                                </h3>

                                <p class="blog-excerpt">
                                    {{ Str::limit(strip_tags($post->excerpt ?? ''), 110) }}
                                </p>

                                <a href="{{ route('frontend.blog.show', $post->slug) }}" class="blog-read">
                                    Read article
                                    <i class="bi bi-arrow-right-short"></i>
                                </a>
                            </div>
                        </article>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-light border mb-0">
                            <strong>No posts available right now.</strong> Please check back soon.
                        </div>
                    </div>
                @endforelse

            </div>
        </div>
    </section>

    <!-- =================== FAQ PREVIEW =================== -->
    <section id="faq-preview" class="section-padding">
    <div class="container">
        <div class="row g-4 align-items-start">

        <!-- LEFT: Title + Accordion -->
        <div class="col-lg-7">

            <span class="faq-eyebrow">Support &amp; Assistance</span>

            <div class="d-flex justify-content-between align-items-end mb-3">
            <div>
                <h2 class="faq-title mb-1">Frequently Asked Questions</h2>
                <p class="faq-subtitle mb-0">
                Answers to commonly asked questions about Amtex Safety Systems,
                our fire protection products and support services.
                </p>
            </div>

            <a href="{{ route('faq') }}" class="faq-view-all d-none d-md-inline-flex align-items-center">
                View all FAQs
                <i class="bi bi-arrow-right ms-1"></i>
            </a>
            </div>

            <div class="accordion" id="homeFaqAccordion">

            @php $homeFaqs = $homeFaqs ?? collect(); @endphp

            @forelse($homeFaqs as $i => $faq)
                @php
                $headingId = 'faqHeading' . $faq->id;
                $collapseId = 'faqCollapse' . $faq->id;
                $isFirst = $i === 0;
                @endphp

                <div class="accordion-item faq-item">
                <h2 class="accordion-header" id="{{ $headingId }}">
                    <button
                    class="accordion-button {{ $isFirst ? '' : 'collapsed' }} faq-button"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#{{ $collapseId }}"
                    aria-expanded="{{ $isFirst ? 'true' : 'false' }}"
                    aria-controls="{{ $collapseId }}"
                    >
                    {{ $faq->question }}
                    </button>
                </h2>

                <div
                    id="{{ $collapseId }}"
                    class="accordion-collapse collapse {{ $isFirst ? 'show' : '' }}"
                    aria-labelledby="{{ $headingId }}"
                    data-bs-parent="#homeFaqAccordion"
                >
                    <div class="accordion-body faq-body">
                    {!! $faq->answer ?: '<p class="mb-0">Answer will be updated soon.</p>' !!}
                    </div>
                </div>
                </div>

            @empty
                <div class="alert alert-info mb-0">
                FAQs will be updated soon.
                </div>
            @endforelse

            </div>

            <!-- Mobile "view all" link -->
            <a href="{{ route('faq') }}" class="faq-view-all mt-3 d-inline-flex d-md-none align-items-center">
            View all FAQs
            <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>

        <!-- RIGHT: Support Card -->
        <div class="col-lg-5">
            <div class="faq-support-card">

            <div>
                <span class="support-eyebrow">
                Fire Safety Assistance
                </span>

                <h3 class="support-title">Need expert guidance?</h3>
                <p class="support-text">
                Our team can assist you with product selection, compliance
                requirements and fire safety planning based on your application
                and site conditions.
                </p>

                <!-- Trust indicators -->
                <div class="support-stats">
                <div class="stat-item">
                    <i class="bi bi-shield-check"></i>
                    <div>
                    <strong>Certified Products</strong>
                    <span>As per applicable IS standards</span>
                    </div>
                </div>

                <div class="stat-item">
                    <i class="bi bi-award"></i>
                    <div>
                    <strong>ISO 9001:2015</strong>
                    <span>Quality management certified</span>
                    </div>
                </div>

                <div class="stat-item">
                    <i class="bi bi-gear-wide-connected"></i>
                    <div>
                    <strong>Service Support</strong>
                    <span>Inspection, refilling &amp; maintenance</span>
                    </div>
                </div>
                </div>

                <hr class="support-divider" />

                <!-- Badges -->
                <div class="support-badges">
                <span><i class="bi bi-geo-alt me-1"></i>Pan-India reach</span>
                <span><i class="bi bi-telephone me-1"></i>Phone &amp; email support</span>
                </div>

                <!-- Direct contact options -->
                <div class="support-contact">
                <a href="tel:08047822682" class="support-contact-link">
                    <i class="bi bi-telephone-fill"></i>
                    Call us
                </a>
                <a href="mailto:info@amtexsafety.com" class="support-contact-link">
                    <i class="bi bi-envelope-fill"></i>
                    Email us
                </a>
                </div>
            </div>

            <a href="#quick-enquiry" class="btn btn-light btn-sm support-btn">
                Request assistance
            </a>

            </div>
        </div>

        </div>
    </div>
    </section>

    <!-- =================== QUICK ENQUIRY STRIP =================== -->
    <section id="quick-enquiry" class="section-padding">
        <div class="container">
            <div class="quick-enquiry-card row g-4 align-items-center">

            <!-- LEFT TEXT -->
            <div class="col-lg-5">
                <span class="qe-eyebrow">
                <i class="bi bi-life-preserver me-1"></i>
                Product Enquiry
                </span>

                <h2 class="qe-title mb-2">
                Need assistance selecting the right fire extinguisher?
                </h2>

                <p class="qe-subtitle mb-3">
                Share your basic requirements and our team will help identify
                suitable fire safety solutions based on application, risk type
                and compliance needs.
                </p>

                <ul class="qe-points">
                <li><i class="bi bi-check2-circle"></i> Guidance for residential, commercial &amp; industrial use</li>
                <li><i class="bi bi-check2-circle"></i> Application-based product recommendation</li>
                <li><i class="bi bi-check2-circle"></i> No obligation to proceed</li>
                </ul>

                <!-- trust strip -->
                <div class="qe-trust mt-3">
                <div class="qe-trust-item">
                    <i class="bi bi-shield-check"></i>
                    Certified fire safety products
                </div>
                <div class="qe-trust-item">
                    <i class="bi bi-geo-alt"></i>
                    Pan-India reach
                </div>
                <div class="qe-trust-item">
                    <i class="bi bi-person-check"></i>
                    Technical guidance focused on safety
                </div>
                </div>
            </div>

            <!-- RIGHT FORM -->
            <div class="col-lg-7">
                <form class="row g-2 g-md-3 qe-form">

                <!-- small tagline above form -->
                <div class="col-12">
                    <div class="qe-form-tagline">
                    <span>
                        <i class="bi bi-info-circle-fill me-1"></i>
                        Share basic details for better assistance
                    </span>
                    </div>
                </div>

                <div class="col-md-4">
                    <input type="text" class="form-control qe-input" placeholder="Name *" />
                </div>
                <div class="col-md-4">
                    <input type="tel" class="form-control qe-input" placeholder="Mobile *" />
                </div>
                <div class="col-md-4">
                    <input type="email" class="form-control qe-input" placeholder="Email" />
                </div>

                <div class="col-12">
                    <input type="text" class="form-control qe-input" placeholder="City / Type of premises" />
                </div>

                <div class="col-12">
                    <textarea
                    class="form-control qe-input qe-textarea"
                    rows="2"
                    placeholder="Brief requirement (e.g. office, warehouse, electrical room, kitchen)…"
                    ></textarea>
                </div>

                <!-- CAPTCHA & BUTTON -->
                <div class="col-md-6">
                    <div class="qe-captcha">
                    <span class="qe-captcha-label">Security Check</span>
                    <div class="qe-captcha-box">
                        CAPTCHA Placeholder
                    </div>
                    </div>
                </div>

                <div class="col-md-6 d-flex flex-column align-items-md-end justify-content-between">
                    <button type="submit" class="btn btn-amtex qe-submit mt-2 mt-md-0">
                    Submit Enquiry
                    </button>
                    <span class="qe-privacy mt-2">
                    <i class="bi bi-lock-fill me-1"></i>
                    Your information will be used only for enquiry assistance.
                    </span>
                </div>
                </form>
            </div>

            </div>
        </div>
    </section>

</main>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const marquee = document.getElementById('ourworkMarquee');
    const track = document.getElementById('ourworkTrack');
    const prevBtn = document.querySelector('.ourwork-nav-prev');
    const nextBtn = document.querySelector('.ourwork-nav-next');

    if (!marquee || !track || !prevBtn || !nextBtn) return;

    function getStep() {
        const item = track.querySelector('.ourwork-frame');
        return item ? item.offsetWidth + 22 : 300;
    }

    prevBtn.addEventListener('click', function () {
        track.style.animationPlayState = 'paused';
        marquee.scrollBy({ left: -getStep(), behavior: 'smooth' });
    });

    nextBtn.addEventListener('click', function () {
        track.style.animationPlayState = 'paused';
        marquee.scrollBy({ left: getStep(), behavior: 'smooth' });
    });

    marquee.addEventListener('mouseleave', function () {
        track.style.animationPlayState = 'running';
    });
});
</script>

@endsection