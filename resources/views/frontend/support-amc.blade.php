@extends('web_master')
@section('main')

<!-- =================== MAIN =================== -->
<main id="amc-main">

  <!-- =================== AMC HERO =================== -->
  <section id="amc-hero" class="amc-pad">
    <div class="container">

      <div class="amc-breadcrumb">
        <a href="index.html">Home</a>
        <span>•</span>
        <span class="amc-breadcrumb-active">Support &amp; AMC</span>
      </div>

      <div class="row g-4 align-items-center">
        <div class="col-lg-7">

          <div class="amc-hero-chiprow d-flex flex-wrap gap-2 mb-2">
            <span class="amc-chip">
              <i class="bi bi-gear-wide-connected me-1"></i>
              Support & AMC
            </span>
            <span class="amc-chip amc-chip-dark">
              <i class="bi bi-clipboard-check me-1"></i>
              Audit-ready documentation
            </span>
          </div>

          <h1 class="amc-hero-title">
            Keep your extinguishers
            <span>always ready & compliant.</span>
          </h1>

          <p class="amc-hero-subtitle">
            With Amtex AMC & support, you get periodic inspections, refilling reminders, service tagging,
            records for audits, and reliable help — so your safety system stays ready when it matters most.
          </p>

          <div class="amc-hero-points d-flex flex-wrap gap-2 mt-3">
            <span class="amc-point"><i class="bi bi-check2-circle me-1"></i>Scheduled checks</span>
            <span class="amc-point"><i class="bi bi-check2-circle me-1"></i>Refilling & tagging</span>
            <span class="amc-point"><i class="bi bi-check2-circle me-1"></i>Compliance records</span>
            <span class="amc-point"><i class="bi bi-check2-circle me-1"></i>Priority support</span>
          </div>

          <div class="amc-hero-actions d-flex flex-wrap gap-2 mt-3">
            <a href="#amc-plans" class="btn btn-amtex btn-lg px-4">
              View AMC Plans
            </a>
            <a href="#amc-enquiry" class="btn btn-outline-dark btn-lg px-4 amc-outline-btn">
              Request a Call Back
            </a>
          </div>

          <div class="amc-mini-strip mt-3">
            <div class="amc-mini-item">
              <i class="bi bi-clock-history"></i>
              Response within 24 hours*
            </div>
            <div class="amc-mini-item">
              <i class="bi bi-geo-alt"></i>
              Pan-India support*
            </div>
            <div class="amc-mini-item">
              <i class="bi bi-shield-check"></i>
              Genuine Amtex service
            </div>
          </div>

          <div class="amc-footnote mt-2">
            *Update timelines/coverage as per operations before go-live.
          </div>

        </div>

        <div class="col-lg-5">
          <div class="amc-hero-card">
            <div class="amc-hero-card-head">
              <div>
                <div class="amc-hero-card-label">Quick support</div>
                <div class="amc-hero-card-title">Raise a service request</div>
              </div>
              <span class="amc-pill">
                <i class="bi bi-lightning-charge-fill me-1"></i> 1–2 min
              </span>
            </div>

            @if(session('success'))
  <div class="alert alert-success mb-3">
    {{ session('success') }}
  </div>
@endif

@if($errors->any())
  <div class="alert alert-danger mb-3">
    Please check the required fields and try again.
  </div>
@endif

<form method="POST" action="{{ route('frontend.amc.store') }}" class="row g-2 mt-2">
  @csrf

  <div class="col-12">
    <input
      type="text"
      name="user"
      class="form-control amc-input{{ $errors->has('user') ? ' is-invalid' : '' }}"
      placeholder="Name / Company *"
      value="{{ old('user') }}"
      required
    />

    @if($errors->has('user'))
      <div class="invalid-feedback d-block">
        {{ $errors->first('user') }}
      </div>
    @endif
  </div>

  <div class="col-12">
    <input
      type="tel"
      name="phone"
      class="form-control amc-input{{ $errors->has('phone') ? ' is-invalid' : '' }}"
      placeholder="Mobile number *"
      value="{{ old('phone') }}"
      required
    />

    @if($errors->has('phone'))
      <div class="invalid-feedback d-block">
        {{ $errors->first('phone') }}
      </div>
    @endif
  </div>

  <div class="col-12">
    <input
      type="text"
      name="city"
      class="form-control amc-input{{ $errors->has('city') ? ' is-invalid' : '' }}"
      placeholder="City / Site location"
      value="{{ old('city') }}"
    />

    @if($errors->has('city'))
      <div class="invalid-feedback d-block">
        {{ $errors->first('city') }}
      </div>
    @endif
  </div>

  <div class="col-12">
    <select
      name="plan_type"
      class="form-select amc-input{{ $errors->has('plan_type') ? ' is-invalid' : '' }}"
    >
      <option value="">What do you need?</option>
      <option value="AMC / Annual maintenance" {{ old('plan_type') == 'AMC / Annual maintenance' ? 'selected' : '' }}>
        AMC / Annual maintenance
      </option>
      <option value="Refilling request" {{ old('plan_type') == 'Refilling request' ? 'selected' : '' }}>
        Refilling request
      </option>
      <option value="Inspection & tagging" {{ old('plan_type') == 'Inspection & tagging' ? 'selected' : '' }}>
        Inspection & tagging
      </option>
      <option value="Hydro-testing support" {{ old('plan_type') == 'Hydro-testing support' ? 'selected' : '' }}>
        Hydro-testing support
      </option>
      <option value="Replacement / Upgrade advice" {{ old('plan_type') == 'Replacement / Upgrade advice' ? 'selected' : '' }}>
        Replacement / Upgrade advice
      </option>
    </select>

    @if($errors->has('plan_type'))
      <div class="invalid-feedback d-block">
        {{ $errors->first('plan_type') }}
      </div>
    @endif
  </div>

  <div class="col-12">
    <button type="submit" class="amc-primary-btn w-100">
      Submit request
      <i class="bi bi-arrow-right-short ms-1"></i>
    </button>

    <p class="amc-form-note mb-0">
      <i class="bi bi-lock-fill me-1"></i>We keep your details private.
    </p>
  </div>
</form>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- =================== AMC TRUST STRIP =================== -->
  <section id="amc-trust" class="amc-pad-sm">
    <div class="container">
      <div class="amc-trust-strip">
        <div class="amc-trust-item">
          <i class="bi bi-clipboard-check"></i>
          Service reports for audits
        </div>
        <div class="amc-trust-item">
          <i class="bi bi-tags"></i>
          Proper tagging & records
        </div>
        <div class="amc-trust-item">
          <i class="bi bi-check2-circle"></i>
          Standard-compliant checks
        </div>
        <div class="amc-trust-item">
          <i class="bi bi-tools"></i>
          Expert technicians & support
        </div>
      </div>
    </div>
  </section>

  <!-- =================== AMC PLANS =================== -->
  <section id="amc-plans" class="amc-pad">
    <div class="container">

      <div class="text-center mb-4 mb-md-5">
        <span class="amc-eyebrow">Plans</span>
        <h2 class="amc-title mb-2">Choose the right AMC coverage</h2>
        <p class="amc-subtitle">
          For homes, offices, restaurants, warehouses and industrial sites — pick a plan, or we’ll customise it.
        </p>
      </div>

      <div class="row g-3 g-md-4 justify-content-center">

        <div class="col-md-4">
          <div class="amc-plan-card">
            <div class="amc-plan-top">
              <span class="amc-plan-badge">Essential</span>
              <span class="amc-plan-chip"><i class="bi bi-house-door me-1"></i>Homes / Small offices</span>
            </div>

            <h3 class="amc-plan-title">Basic compliance cover</h3>
            <p class="amc-plan-text">
              Ideal when you need regular checks, tagging and compliance-ready record keeping.
            </p>

            <ul class="amc-list">
              <li><i class="bi bi-check2-circle"></i> Periodic inspections</li>
              <li><i class="bi bi-check2-circle"></i> Tagging & basic reporting</li>
              <li><i class="bi bi-check2-circle"></i> Refill reminders</li>
            </ul>

            <a href="#amc-enquiry" class="amc-plan-btn">
              Enquire for pricing <i class="bi bi-arrow-right-short"></i>
            </a>
          </div>
        </div>

        <div class="col-md-4">
          <div class="amc-plan-card amc-plan-highlight">
            <div class="amc-plan-top">
              <span class="amc-plan-badge amc-plan-badge-grad">Most Popular</span>
              <span class="amc-plan-chip"><i class="bi bi-building me-1"></i>Offices / Retail</span>
            </div>

            <h3 class="amc-plan-title">Standard AMC + service</h3>
            <p class="amc-plan-text">
              Balanced plan for businesses that need scheduled service plus priority support.
            </p>

            <ul class="amc-list">
              <li><i class="bi bi-check2-circle"></i> Scheduled inspection visits</li>
              <li><i class="bi bi-check2-circle"></i> Service records for audits</li>
              <li><i class="bi bi-check2-circle"></i> Priority assistance & call support</li>
              <li><i class="bi bi-check2-circle"></i> Refill planning guidance</li>
            </ul>

            <a href="#amc-enquiry" class="amc-plan-btn amc-plan-btn-solid">
              Get a callback <i class="bi bi-arrow-right-short"></i>
            </a>
          </div>
        </div>

        <div class="col-md-4">
          <div class="amc-plan-card">
            <div class="amc-plan-top">
              <span class="amc-plan-badge">Enterprise</span>
              <span class="amc-plan-chip"><i class="bi bi-building-gear me-1"></i>Factories / Warehouses</span>
            </div>

            <h3 class="amc-plan-title">Custom projects & sites</h3>
            <p class="amc-plan-text">
              Multi-location sites, higher-risk zones, audits, drills, and documentation support.
            </p>

            <ul class="amc-list">
              <li><i class="bi bi-check2-circle"></i> Site mapping & inventory list</li>
              <li><i class="bi bi-check2-circle"></i> Documentation pack & BOQ support</li>
              <li><i class="bi bi-check2-circle"></i> Refilling & hydro-testing coordination</li>
            </ul>

            <a href="#amc-enquiry" class="amc-plan-btn">
              Request custom plan <i class="bi bi-arrow-right-short"></i>
            </a>
          </div>
        </div>

      </div>

      <div class="amc-note text-center mt-4">
        <i class="bi bi-info-circle me-1"></i>
        Pricing depends on quantity, type (ABC/CO₂/Mist/Clean Agent) and site category. We’ll share a quick quote after enquiry.
      </div>

    </div>
  </section>

  <!-- =================== WHAT'S INCLUDED =================== -->
  <section id="amc-includes" class="amc-pad">
    <div class="container">

      <div class="row g-4 align-items-center">
        <div class="col-lg-5">
          <span class="amc-eyebrow">Coverage</span>
          <h2 class="amc-title mb-2">What’s included in support & AMC</h2>
          <p class="amc-subtitle mb-0">
            A structured approach to keep extinguishers ready, properly placed, tagged, and documented.
          </p>

          <div class="amc-side-card mt-3">
            <div class="amc-side-title">Perfect for</div>
            <div class="amc-side-tags">
              <span><i class="bi bi-house me-1"></i>Societies</span>
              <span><i class="bi bi-building me-1"></i>Offices</span>
              <span><i class="bi bi-shop me-1"></i>Retail</span>
              <span><i class="bi bi-egg-fried me-1"></i>Kitchens</span>
              <span><i class="bi bi-truck me-1"></i>Warehouses</span>
            </div>
          </div>
        </div>

        <div class="col-lg-7">
          <div class="row g-3 g-md-4">
            <div class="col-md-6">
              <div class="amc-feature">
                <div class="amc-feature-icon"><i class="bi bi-search"></i></div>
                <h3 class="amc-feature-title">Inspection & condition check</h3>
                <p class="amc-feature-text">Pressure, seal, hose, nozzle, bracket and placement check.</p>
              </div>
            </div>

            <div class="col-md-6">
              <div class="amc-feature">
                <div class="amc-feature-icon"><i class="bi bi-tags"></i></div>
                <h3 class="amc-feature-title">Tagging & record keeping</h3>
                <p class="amc-feature-text">Service tag updates and records you can show in audits.</p>
              </div>
            </div>

            <div class="col-md-6">
              <div class="amc-feature">
                <div class="amc-feature-icon"><i class="bi bi-arrow-repeat"></i></div>
                <h3 class="amc-feature-title">Refilling reminders & planning</h3>
                <p class="amc-feature-text">Alerts + guidance for refilling cycles & replacements.</p>
              </div>
            </div>

            <div class="col-md-6">
              <div class="amc-feature">
                <div class="amc-feature-icon"><i class="bi bi-file-earmark-text"></i></div>
                <h3 class="amc-feature-title">Documentation support</h3>
                <p class="amc-feature-text">Service reports, checklists and compliance-ready paperwork.</p>
              </div>
            </div>

          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- =================== PROCESS =================== -->
  <section id="amc-process" class="amc-pad">
    <div class="container">
      <div class="text-center mb-4 mb-md-5">
        <span class="amc-eyebrow">How it works</span>
        <h2 class="amc-title mb-2">A simple 4-step service workflow</h2>
        <p class="amc-subtitle">
          From onboarding to periodic checks, we follow a clear process so nothing is missed.
        </p>
      </div>

      <div class="row g-3 g-md-4 justify-content-center">
        <div class="col-md-3 col-6">
          <div class="amc-step">
            <div class="amc-step-no">01</div>
            <div class="amc-step-title">Site details</div>
            <div class="amc-step-text">Share quantity, type, and premises category.</div>
          </div>
        </div>
        <div class="col-md-3 col-6">
          <div class="amc-step">
            <div class="amc-step-no">02</div>
            <div class="amc-step-title">Plan & schedule</div>
            <div class="amc-step-text">We map the schedule and confirm visit dates.</div>
          </div>
        </div>
        <div class="col-md-3 col-6">
          <div class="amc-step">
            <div class="amc-step-no">03</div>
            <div class="amc-step-title">Inspection & tagging</div>
            <div class="amc-step-text">Perform checks, tag updates, and reporting.</div>
          </div>
        </div>
        <div class="col-md-3 col-6">
          <div class="amc-step">
            <div class="amc-step-no">04</div>
            <div class="amc-step-title">Ongoing support</div>
            <div class="amc-step-text">Priority help + refilling & compliance guidance.</div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- =================== FAQ =================== -->
  <section id="amc-faq" class="amc-pad">
    <div class="container">
      <div class="row g-4 align-items-start">

        <div class="col-lg-7">
          <span class="amc-eyebrow">FAQs</span>
          <h2 class="amc-title mb-2">Support questions people ask</h2>
          <p class="amc-subtitle mb-3">
            Quick answers about inspections, refilling, tagging and documentation.
          </p>

        <div class="accordion" id="amcFaqAccordion">

  @forelse($amcFaqs as $index => $faq)

    @php
      $headingId = 'amcFaqHeading' . $faq->id;
      $collapseId = 'amcFaqCollapse' . $faq->id;
      $isFirst = $index === 0;
    @endphp

    <div class="accordion-item amc-acc-item">
      <h2 class="accordion-header" id="{{ $headingId }}">
        <button
          class="accordion-button {{ $isFirst ? '' : 'collapsed' }} amc-acc-btn"
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
        data-bs-parent="#amcFaqAccordion"
      >
        <div class="accordion-body amc-acc-body">
          {!! $faq->answer !!}
        </div>
      </div>
    </div>

  @empty

    <div class="accordion-item amc-acc-item">
      <h2 class="accordion-header" id="amcFaqEmptyH">
        <button
          class="accordion-button amc-acc-btn"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#amcFaqEmpty"
          aria-expanded="true"
        >
          No FAQs available
        </button>
      </h2>

      <div
        id="amcFaqEmpty"
        class="accordion-collapse collapse show"
        data-bs-parent="#amcFaqAccordion"
      >
        <div class="accordion-body amc-acc-body">
          AMC related FAQs will be updated soon.
        </div>
      </div>
    </div>

  @endforelse

</div>
        </div>

        <div class="col-lg-5">
          <div class="amc-help-card">
            <div class="amc-help-top">
              <span class="amc-help-chip">
                <i class="bi bi-headset me-1"></i> Priority Support
              </span>
              <span class="amc-help-mini">
                <i class="bi bi-clock-history me-1"></i> Fast response
              </span>
            </div>

            <h3 class="amc-help-title">Need urgent assistance?</h3>
            <p class="amc-help-text">
              Talk to our team for site-specific guidance on service, refilling, and replacement planning.
            </p>

            <div class="amc-help-links">
             @php
    use App\Models\SiteSetting;

    $siteSetting = $siteSetting ?? SiteSetting::first();

    $phone = $siteSetting->phone ?? '+919973113905';
    $email = $siteSetting->email ?? 'info@amtexsafety.com';

    $cleanPhone = preg_replace('/\D+/', '', $phone);
@endphp

<a href="tel:+{{ $cleanPhone }}" class="amc-help-link">
    <i class="bi bi-telephone-fill"></i> Call support
</a>

<a href="mailto:{{ $email }}" class="amc-help-link">
    <i class="bi bi-envelope-fill"></i> Email us
</a>
            </div>

            <a href="#amc-enquiry" class="amc-help-btn">
              Request a call back <i class="bi bi-arrow-right-short"></i>
            </a>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- =================== CTA =================== -->
  <section id="amc-cta" class="amc-pad">
    <div class="container">
      <div class="amc-cta-card row g-3 align-items-center">
        <div class="col-lg-8">
          <div class="amc-cta-eyebrow">
            <i class="bi bi-shield-check me-1"></i> Stay compliant. Stay protected.
          </div>
          <h2 class="amc-cta-title mb-1">Get an AMC quote for your site</h2>
          <p class="amc-cta-text mb-0">
            Tell us your extinguisher quantity and site type — we’ll share a suitable plan and schedule.
          </p>
        </div>
        <div class="col-lg-4 text-lg-end">
          <a href="#amc-enquiry" class="btn btn-amtex btn-lg px-4">Get Quote</a>
        </div>
      </div>
    </div>
  </section>

  <!-- =================== ENQUIRY =================== -->
  <section id="amc-enquiry" class="amc-pad">
    <div class="container">
      <div class="amc-enquiry-card row g-4 align-items-center">

        <div class="col-lg-5">
          <span class="amc-eyebrow">
            <i class="bi bi-life-preserver me-1"></i> AMC Enquiry
          </span>
          <h2 class="amc-title mb-2">Tell us your site details</h2>
          <p class="amc-subtitle mb-3">
            We’ll recommend plan type, visit frequency and a quick quote for AMC/service support.
          </p>

          <ul class="amc-bullets">
            <li><i class="bi bi-check2-circle"></i> Guidance for homes, offices & industries</li>
            <li><i class="bi bi-check2-circle"></i> No-obligation consultation</li>
            <li><i class="bi bi-check2-circle"></i> Fast response from our team</li>
          </ul>

          <div class="amc-trust-mini mt-3">
            <div class="amc-trust-mini-item"><i class="bi bi-shield-check"></i> ISO-certified solutions</div>
            <div class="amc-trust-mini-item"><i class="bi bi-geo-alt"></i> Pan-India support</div>
            <div class="amc-trust-mini-item"><i class="bi bi-clipboard-check"></i> Audit-ready records</div>
          </div>
        </div>

        <div class="col-lg-7">
         @if(session('success'))
  <div class="alert alert-success mb-3">
    {{ session('success') }}
  </div>
@endif

@if($errors->any())
  <div class="alert alert-danger mb-3">
    Please check the required fields and try again.
  </div>
@endif

<form method="POST" action="{{ route('frontend.amc.store') }}" class="row g-2 g-md-3 amc-form">
  @csrf

  <div class="col-md-6">
    <input
      type="text"
      name="user"
      class="form-control amc-input{{ $errors->has('user') ? ' is-invalid' : '' }}"
      placeholder="Name *"
      value="{{ old('user') }}"
      required
    />

    @if($errors->has('user'))
      <div class="invalid-feedback d-block">
        {{ $errors->first('user') }}
      </div>
    @endif
  </div>

  <div class="col-md-6">
    <input
      type="tel"
      name="phone"
      class="form-control amc-input{{ $errors->has('phone') ? ' is-invalid' : '' }}"
      placeholder="Mobile *"
      value="{{ old('phone') }}"
      required
    />

    @if($errors->has('phone'))
      <div class="invalid-feedback d-block">
        {{ $errors->first('phone') }}
      </div>
    @endif
  </div>

  <div class="col-md-6">
    <input
      type="email"
      name="email"
      class="form-control amc-input{{ $errors->has('email') ? ' is-invalid' : '' }}"
      placeholder="Email"
      value="{{ old('email') }}"
    />

    @if($errors->has('email'))
      <div class="invalid-feedback d-block">
        {{ $errors->first('email') }}
      </div>
    @endif
  </div>

  <div class="col-md-6">
    <input
      type="text"
      name="city"
      class="form-control amc-input{{ $errors->has('city') ? ' is-invalid' : '' }}"
      placeholder="City / Location"
      value="{{ old('city') }}"
    />

    @if($errors->has('city'))
      <div class="invalid-feedback d-block">
        {{ $errors->first('city') }}
      </div>
    @endif
  </div>

  <div class="col-12">
    <select
      name="site_type"
      class="form-select amc-input{{ $errors->has('site_type') ? ' is-invalid' : '' }}"
    >
      <option value="">Type of premises</option>
      <option value="Apartment / Society" {{ old('site_type') == 'Apartment / Society' ? 'selected' : '' }}>
        Apartment / Society
      </option>
      <option value="Office / IT park" {{ old('site_type') == 'Office / IT park' ? 'selected' : '' }}>
        Office / IT park
      </option>
      <option value="Shop / Showroom" {{ old('site_type') == 'Shop / Showroom' ? 'selected' : '' }}>
        Shop / Showroom
      </option>
      <option value="Restaurant / Kitchen" {{ old('site_type') == 'Restaurant / Kitchen' ? 'selected' : '' }}>
        Restaurant / Kitchen
      </option>
      <option value="Factory / Warehouse" {{ old('site_type') == 'Factory / Warehouse' ? 'selected' : '' }}>
        Factory / Warehouse
      </option>
      <option value="Institution / Hospital" {{ old('site_type') == 'Institution / Hospital' ? 'selected' : '' }}>
        Institution / Hospital
      </option>
    </select>

    @if($errors->has('site_type'))
      <div class="invalid-feedback d-block">
        {{ $errors->first('site_type') }}
      </div>
    @endif
  </div>

  <div class="col-md-6">
    <select
      name="quantity"
      class="form-select amc-input{{ $errors->has('quantity') ? ' is-invalid' : '' }}"
    >
      <option value="">Approx quantity</option>
      <option value="1–5" {{ old('quantity') == '1–5' ? 'selected' : '' }}>1–5</option>
      <option value="6–15" {{ old('quantity') == '6–15' ? 'selected' : '' }}>6–15</option>
      <option value="16–50" {{ old('quantity') == '16–50' ? 'selected' : '' }}>16–50</option>
      <option value="50+" {{ old('quantity') == '50+' ? 'selected' : '' }}>50+</option>
    </select>

    @if($errors->has('quantity'))
      <div class="invalid-feedback d-block">
        {{ $errors->first('quantity') }}
      </div>
    @endif
  </div>

  <div class="col-md-6">
    <select
      name="fire_type"
      class="form-select amc-input{{ $errors->has('fire_type') ? ' is-invalid' : '' }}"
    >
      <option value="">Extinguisher type</option>
      <option value="Mist" {{ old('fire_type') == 'Mist' ? 'selected' : '' }}>Mist</option>
      <option value="ABC Dry Powder" {{ old('fire_type') == 'ABC Dry Powder' ? 'selected' : '' }}>ABC Dry Powder</option>
      <option value="CO₂" {{ old('fire_type') == 'CO₂' ? 'selected' : '' }}>CO₂</option>
      <option value="Clean Agent" {{ old('fire_type') == 'Clean Agent' ? 'selected' : '' }}>Clean Agent</option>
      <option value="Multiple types" {{ old('fire_type') == 'Multiple types' ? 'selected' : '' }}>Multiple types</option>
    </select>

    @if($errors->has('fire_type'))
      <div class="invalid-feedback d-block">
        {{ $errors->first('fire_type') }}
      </div>
    @endif
  </div>

  <div class="col-12">
    <textarea
      name="message"
      class="form-control amc-input amc-textarea{{ $errors->has('message') ? ' is-invalid' : '' }}"
      rows="3"
      placeholder="Brief requirement (AMC/refilling/tagging/hydro-testing)…"
    >{{ old('message') }}</textarea>

    @if($errors->has('message'))
      <div class="invalid-feedback d-block">
        {{ $errors->first('message') }}
      </div>
    @endif
  </div>

  <input type="hidden" name="plan_type" value="AMC Enquiry">

  <div class="col-md-6">
    <div class="amc-captcha">
      <span class="amc-captcha-label">Security Check</span>
      <div class="amc-captcha-box">CAPTCHA Placeholder</div>
    </div>
  </div>

  <div class="col-md-6 d-flex flex-column align-items-md-end justify-content-between">
    <button type="submit" class="btn btn-amtex amc-submit mt-2 mt-md-0">
      Submit Enquiry
    </button>
    <span class="amc-privacy mt-2">
      <i class="bi bi-lock-fill me-1"></i>Your details are kept private.
    </span>
  </div>
</form>
        </div>

      </div>
    </div>
  </section>

</main>

@endsection