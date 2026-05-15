@extends('web_master')
@section('main')

@php
  use Illuminate\Support\Str;

  // Safe guards if controller ever sends empty
  $categories = $categories ?? collect();
@endphp

<!-- =================== MAIN =================== -->
<main id="faq-main">

<!-- =================== FAQ HERO =================== -->
<section id="faq-hero">
  <div class="container">
    <nav class="faq-breadcrumb" aria-label="breadcrumb">
      <a href="{{ url('/') }}">Home</a>
      <span class="faq-crumb-dot">•</span>
      <span class="faq-crumb-active">FAQ</span>
    </nav>

    <div class="row g-4 align-items-center">

      <!-- Left -->
      <div class="col-lg-7">
        <div class="faq-hero-chips">
          <span class="faq-chip"><i class="bi bi-shield-check me-1"></i>Standards-aligned</span>
          <span class="faq-chip faq-chip-dark"><i class="bi bi-lightning-charge-fill me-1"></i>Practical answers</span>
        </div>

        <h1 class="faq-title">
          Fire safety FAQs
          <span>answered by people who work on sites.</span>
        </h1>

        <p class="faq-subtitle">
          Learn how to choose the right extinguisher, where to place it, how AMC/refilling works,
          what to keep ready for inspections, and when a Mist upgrade makes sense.
        </p>

        <div class="faq-hero-actions d-flex flex-wrap gap-2">
          <a href="#faq-questions" class="btn btn-amtex faq-btn-pill">
            Browse questions <i class="bi bi-arrow-right-short"></i>
          </a>
          <a href="#quick-enquiry" class="btn btn-outline-dark faq-btn-pill">
            Get site guidance <i class="bi bi-chat-dots"></i>
          </a>
        </div>
      </div>

      <!-- Right -->
      <div class="col-lg-5">
        <div class="faq-hero-card">
          <div class="faq-hero-card-top d-flex align-items-start justify-content-between gap-2">
            <div>
              <div class="faq-hero-card-eyebrow">Need a quick answer?</div>
              <div class="faq-hero-card-title">Search & shortcuts</div>
            </div>
            <span class="faq-mini-chip"><i class="bi bi-clock me-1"></i>Fast lookup</span>
          </div>

          <div class="faq-search-wrap">
            <i class="bi bi-search"></i>
            <input
              type="text"
              id="faqSearch"
              class="form-control faq-search"
              placeholder="Search: CO₂, kitchen, refill, AMC, audit, mist…"
            />
          </div>

          <div class="faq-hero-mini grid mt-3">
            <div class="faq-mini-box">
              <div class="faq-mini-title">Office / IT</div>
              <div class="faq-mini-text">Low-residue options (site dependent)</div>
            </div>
            <div class="faq-mini-box">
              <div class="faq-mini-title">Commercial kitchens</div>
              <div class="faq-mini-text">Wet chemical + correct placement</div>
            </div>
            <div class="faq-mini-box">
              <div class="faq-mini-title">AMC & records</div>
              <div class="faq-mini-text">Scheduled checks + audit-ready logs</div>
            </div>
            <div class="faq-mini-box">
              <div class="faq-mini-title">Upgrade program</div>
              <div class="faq-mini-text">Powder → Mist exchange (eligible units)</div>
            </div>
          </div>

          <div class="faq-hero-note">
            <i class="bi bi-lock-fill me-1"></i> No spam. Only helpful callbacks if you request.
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- =================== FAQ CONTENT =================== -->
<section id="faq-questions" class="faq-pad">
  <div class="container">

    <div class="faq-toolbar">
      <div class="faq-toolbar-left">
        <span class="faq-toolbar-label"><i class="bi bi-funnel me-1"></i>Filter</span>

        <div class="faq-tabs" id="faqTabs">
          <button class="faq-tab active" type="button" data-faq-tab="all">All</button>

          @foreach($categories as $category)
            @php
              $tabKey = Str::slug($category->name);
            @endphp
            <button class="faq-tab" type="button" data-faq-tab="{{ $tabKey }}">
              {{ $category->name }}
            </button>
          @endforeach
        </div>
      </div>

      <div class="faq-toolbar-right">
        <span class="faq-count" id="faqCount">Showing all questions</span>
      </div>
    </div>

    <div class="row g-4">
      <!-- Left: accordion -->
      <div class="col-lg-8">
        <div class="faq-accordion accordion" id="faqAccordion">

          @php $firstOpen = true; @endphp

          @forelse($categories as $category)
            @php
              $catKey = Str::slug($category->name);
            @endphp

            @foreach(($category->faqs ?? collect()) as $faq)
              @php
                $qid = 'q' . $faq->id;
                $aid = 'a' . $faq->id;
              @endphp

              <div class="accordion-item faq-item"
                   data-faq-cat="{{ $catKey }}"
                   data-faq-q="{{ Str::lower(strip_tags($faq->question ?? '')) }}"
                   data-faq-a="{{ Str::lower(strip_tags($faq->answer ?? '')) }}">
                <h2 class="accordion-header" id="{{ $qid }}">
                  <button class="accordion-button {{ $firstOpen ? '' : 'collapsed' }} faq-btn"
                          type="button"
                          data-bs-toggle="collapse"
                          data-bs-target="#{{ $aid }}"
                          aria-expanded="{{ $firstOpen ? 'true' : 'false' }}"
                          aria-controls="{{ $aid }}">
                    {{ $faq->question }}
                  </button>
                </h2>

                <div id="{{ $aid }}"
                     class="accordion-collapse collapse {{ $firstOpen ? 'show' : '' }}"
                     aria-labelledby="{{ $qid }}"
                     data-bs-parent="#faqAccordion">
                  <div class="accordion-body faq-body">
                    {!! $faq->answer ?: '<p class="mb-0">Answer will be updated soon.</p>' !!}
                  </div>
                </div>
              </div>

              @php $firstOpen = false; @endphp
            @endforeach

          @empty
            <div class="alert alert-info mb-0">
              No FAQs available right now.
            </div>
          @endforelse

        </div>
      </div>

      <!-- Right: sticky help cards -->
      <div class="col-lg-4">
        <aside class="faq-side">

          <div class="faq-side-card faq-side-dark">
            <div class="faq-side-title">Need a site-specific answer?</div>
            <p class="faq-side-text">
              Tell us your premises type and key risk zones — we’ll suggest the right extinguisher mix and a maintenance plan.
            </p>

            <div class="faq-side-badges">
              <span><i class="bi bi-shield-check me-1"></i>Standards-aligned</span>
              <span><i class="bi bi-clipboard-check me-1"></i>Inspection-ready docs</span>
            </div>

            <a href="#quick-enquiry" class="btn btn-amtex w-100 faq-side-btn">
              Talk to our team <i class="bi bi-arrow-right-short"></i>
            </a>
            <a href="products.html" class="btn btn-light w-100 fw-semibold mt-2 faq-side-btn2">
              Browse products <i class="bi bi-grid-3x3-gap"></i>
            </a>
          </div>

          <div class="faq-side-card">
            <div class="faq-side-title2"><i class="bi bi-lightning-charge-fill me-1"></i> Quick tips</div>

            <div class="faq-tip">
              <div class="faq-tip-icon"><i class="bi bi-house-door"></i></div>
              <div>
                <div class="faq-tip-title">Home</div>
                <div class="faq-tip-text">Cover kitchen + common area first. Keep units visible and reachable.</div>
              </div>
            </div>

            <div class="faq-tip">
              <div class="faq-tip-icon"><i class="bi bi-pc-display"></i></div>
              <div>
                <div class="faq-tip-title">Office / IT</div>
                <div class="faq-tip-text">Prefer low-residue solutions near panels and equipment zones.</div>
              </div>
            </div>

            <div class="faq-tip">
              <div class="faq-tip-icon"><i class="bi bi-arrow-repeat"></i></div>
              <div>
                <div class="faq-tip-title">Maintenance</div>
                <div class="faq-tip-text">AMC + records keep your site audit-ready and units serviceable.</div>
              </div>
            </div>

          </div>

        </aside>
      </div>

    </div>

  </div>
</section>

<!-- =================== FAQ CTA =================== -->
<section id="faq-cta" class="faq-pad faq-pad-tight">
  <div class="container">
    <div class="faq-cta-card row g-3 align-items-center">
      <div class="col-lg-8">
        <span class="faq-cta-eyebrow">
          <i class="bi bi-life-preserver me-1"></i>Need expert guidance?
        </span>
        <h2 class="faq-cta-title mb-1">Get the right extinguisher mix for your exact site.</h2>
        <p class="faq-cta-text mb-0">
          Tell us your premises type, key risk zones, and approximate area — we’ll recommend suitable models,
          placement guidance, and AMC/refilling support to stay inspection-ready.
        </p>
      </div>
      <div class="col-lg-4 text-lg-end">
        <a href="#quick-enquiry" class="btn btn-amtex faq-cta-btn">
          Get a quick recommendation
        </a>
      </div>
    </div>
  </div>
</section>

</main>

@endsection

@push('scripts')
<script>
(function () {
  const tabsWrap = document.getElementById('faqTabs');
  const countEl = document.getElementById('faqCount');
  const searchEl = document.getElementById('faqSearch');
  const items = Array.from(document.querySelectorAll('#faqAccordion .faq-item'));

  let activeTab = 'all';

  function visibleItems() {
    return items.filter(el => el.style.display !== 'none');
  }

  function updateCount() {
    const n = visibleItems().length;
    if (!countEl) return;
    if (activeTab === 'all') countEl.textContent = n ? `Showing ${n} questions` : 'No matching questions';
    else countEl.textContent = n ? `Showing ${n} questions` : 'No matching questions';
  }

  function applyFilters() {
    const q = (searchEl?.value || '').trim().toLowerCase();

    items.forEach(el => {
      const cat = el.getAttribute('data-faq-cat') || '';
      const qq = el.getAttribute('data-faq-q') || '';
      const aa = el.getAttribute('data-faq-a') || '';

      const matchTab = (activeTab === 'all') ? true : (cat === activeTab);
      const matchSearch = q ? (qq.includes(q) || aa.includes(q)) : true;

      el.style.display = (matchTab && matchSearch) ? '' : 'none';
    });

    updateCount();
  }

  // Tab click
  if (tabsWrap) {
    tabsWrap.addEventListener('click', function (e) {
      const btn = e.target.closest('.faq-tab');
      if (!btn) return;

      tabsWrap.querySelectorAll('.faq-tab').forEach(b => b.classList.remove('active'));
      btn.classList.add('active');

      activeTab = btn.getAttribute('data-faq-tab') || 'all';
      applyFilters();
    });
  }

  // Search typing
  if (searchEl) {
    searchEl.addEventListener('input', function () {
      applyFilters();
    });
  }

  // Initial
  applyFilters();
})();
</script>
@endpush
