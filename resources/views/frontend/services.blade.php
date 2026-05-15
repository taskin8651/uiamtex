@extends('web_master')
@section('main')

    <main>

  <!-- =================== SERVICES HERO =================== -->
  <section id="services-hero" class="section-padding">
    <div class="container">
      <div class="row g-4 align-items-center">

        <!-- Left content -->
        <div class="col-lg-7">
          <div class="services-hero-eyebrow-wrap d-flex flex-wrap align-items-center gap-2 mb-2">
            <span class="services-hero-eyebrow">
              <i class="bi bi-gear-wide-connected me-1"></i>
              Services
            </span>
            <span class="services-hero-badge">
              <i class="bi bi-clipboard-check me-1"></i>
              Standards-aligned fire safety support
            </span>
          </div>

          <h1 class="services-hero-title">
            Fire safety services
            <span>planned around your site requirements.</span>
          </h1>

          <p class="services-hero-subtitle mb-3 mb-md-4">
            Amtex Safety Systems provides inspection, supply, installation and maintenance
            services for fire extinguishers and fire protection equipment across residential,
            commercial and industrial premises.
          </p>

          <div class="services-hero-points">
            <div class="services-hero-point">
              <i class="bi bi-shield-lock"></i>
              <span>Recommendations based on applicable IS &amp; NBC guidelines.</span>
            </div>
            <div class="services-hero-point">
              <i class="bi bi-people"></i>
              <span>Technical support for installations, audits and ongoing maintenance.</span>
            </div>
            <div class="services-hero-point">
              <i class="bi bi-geo-alt"></i>
              <span>Service coordination through authorised partners across locations.</span>
            </div>
          </div>
        </div>

        <!-- Right quick card -->
        <div class="col-lg-5">
          <div class="services-hero-panel">
            <div class="services-hero-panel-glow"></div>

            <div class="services-hero-panel-header d-flex justify-content-between align-items-center">
              <div>
                <div class="services-hero-panel-label">Service enquiry</div>
                <div class="services-hero-panel-title">Share your requirement</div>
              </div>
              <span class="services-hero-panel-chip">
                <i class="bi bi-lightning-charge-fill me-1"></i>Quick form
              </span>
            </div>

            <form method="POST" action="{{ route('frontend.services.enquiry.store') }}" class="row g-2 services-hero-form">
              @csrf

              {{-- ✅ Premises Type --}}
              <div class="col-12">
                <select name="premises_type" class="form-select services-hero-input {{ $errors->has('premises_type') ? 'is-invalid' : '' }}" required>
                  <option value="" selected disabled>Type of premises</option>
                  <option value="Apartment / Housing Society" {{ old('premises_type') == 'Apartment / Housing Society' ? 'selected' : '' }}>Apartment / Housing Society</option>
                  <option value="Office / IT Space" {{ old('premises_type') == 'Office / IT Space' ? 'selected' : '' }}>Office / IT Space</option>
                  <option value="Shop / Showroom" {{ old('premises_type') == 'Shop / Showroom' ? 'selected' : '' }}>Shop / Showroom</option>
                  <option value="Restaurant / Kitchen" {{ old('premises_type') == 'Restaurant / Kitchen' ? 'selected' : '' }}>Restaurant / Kitchen</option>
                  <option value="Factory / Warehouse" {{ old('premises_type') == 'Factory / Warehouse' ? 'selected' : '' }}>Factory / Warehouse</option>
                  <option value="Institution / Campus" {{ old('premises_type') == 'Institution / Campus' ? 'selected' : '' }}>Institution / Campus</option>
                </select>
                @if($errors->has('premises_type'))
                  <div class="invalid-feedback">{{ $errors->first('premises_type') }}</div>
                @endif
              </div>

              {{-- ✅ Service Required --}}
              <div class="col-md-6">
                <select name="service_required" class="form-select services-hero-input {{ $errors->has('service_required') ? 'is-invalid' : '' }}" required>
                  <option value="" selected disabled>Service required</option>
                  <option value="New installation" {{ old('service_required') == 'New installation' ? 'selected' : '' }}>New installation</option>
                  <option value="Inspection / assessment" {{ old('service_required') == 'Inspection / assessment' ? 'selected' : '' }}>Inspection / assessment</option>
                  <option value="AMC & refilling" {{ old('service_required') == 'AMC & refilling' ? 'selected' : '' }}>AMC &amp; refilling</option>
                  <option value="Compliance support" {{ old('service_required') == 'Compliance support' ? 'selected' : '' }}>Compliance support</option>
                  <option value="Training & drills" {{ old('service_required') == 'Training & drills' ? 'selected' : '' }}>Training &amp; drills</option>
                  <option value="Other" {{ old('service_required') == 'Other' ? 'selected' : '' }}>Other</option>
                </select>
                @if($errors->has('service_required'))
                  <div class="invalid-feedback">{{ $errors->first('service_required') }}</div>
                @endif
              </div>

              {{-- ✅ City --}}
              <div class="col-md-6">
                <input
                  type="text"
                  name="city"
                  value="{{ old('city') }}"
                  class="form-control services-hero-input {{ $errors->has('city') ? 'is-invalid' : '' }}"
                  placeholder="City / location"
                  required
                />
                @if($errors->has('city'))
                  <div class="invalid-feedback">{{ $errors->first('city') }}</div>
                @endif
              </div>

              {{-- ✅ Name --}}
              <div class="col-md-6">
                <input
                  type="text"
                  name="name"
                  value="{{ old('name') }}"
                  class="form-control services-hero-input {{ $errors->has('name') ? 'is-invalid' : '' }}"
                  placeholder="Your name"
                  required
                />
                @if($errors->has('name'))
                  <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                @endif
              </div>

              {{-- ✅ Phone --}}
              <div class="col-md-6">
                <input
                  type="text"
                  name="phone"
                  value="{{ old('phone') }}"
                  class="form-control services-hero-input {{ $errors->has('phone') ? 'is-invalid' : '' }}"
                  placeholder="Phone number"
                  required
                />
                @if($errors->has('phone'))
                  <div class="invalid-feedback">{{ $errors->first('phone') }}</div>
                @endif
              </div>

              {{-- ✅ Email (optional) --}}
              <div class="col-12">
                <input
                  type="email"
                  name="email"
                  value="{{ old('email') }}"
                  class="form-control services-hero-input {{ $errors->has('email') ? 'is-invalid' : '' }}"
                  placeholder="Email (optional)"
                />
                @if($errors->has('email'))
                  <div class="invalid-feedback">{{ $errors->first('email') }}</div>
                @endif
              </div>

              {{-- ✅ Message (maps to your model message) --}}
              <div class="col-12">
                <input
                  type="text"
                  name="message"
                  value="{{ old('message') }}"
                  class="form-control services-hero-input {{ $errors->has('message') ? 'is-invalid' : '' }}"
                  placeholder="Your requirement (e.g., building size, floors, urgency, etc.)"
                />
                @if($errors->has('message'))
                  <div class="invalid-feedback">{{ $errors->first('message') }}</div>
                @endif
              </div>

              <div class="col-12">
                <button type="submit" class="btn btn-amtex w-100 services-hero-btn">
                  Submit enquiry
                </button>

                <p class="services-hero-note mb-0">
                  <i class="bi bi-lock-fill me-1"></i>Your information is used only to respond to this request.
                </p>
              </div>
            </form>

            <div class="services-hero-alt-contact">
              Prefer to speak with our team?
              <a href="tel:08047822682">
                <i class="bi bi-telephone-outbound me-1"></i>08047822682
              </a>
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>

<!-- =================== SERVICES OVERVIEW =================== -->
<section id="services-overview" class="section-padding">
  <div class="container">

    <div class="text-center mb-4 mb-md-5">
      <span class="services-overview-eyebrow">What we do</span>
      <h2 class="services-overview-title mb-2">
        Fire safety services covering the full equipment lifecycle.
      </h2>
      <p class="services-overview-subtitle">
        From assessment and supply to maintenance and training, our services are
        structured to support compliance, safety and long-term reliability.
      </p>
    </div>

    {{-- ✅ HARD FIX: ensure links are clickable even if card overlays exist --}}
    <style>
      /* Make sure the card becomes a stacking context */
      .services-card{
        position: relative !important;
      }

      /* Many UI kits use pseudo overlays that block clicks */
      .services-card::before,
      .services-card::after{
        pointer-events: none !important;
      }

      /* Common overlay/icon layers that may sit above link */
      .services-card-top,
      .services-card-icon,
      .services-card-glow,
      .services-card-bg,
      .services-card-overlay{
        pointer-events: none !important;
      }

      /* Put link clearly above everything */
      .services-card-cta{
        position: relative !important;
        z-index: 999 !important;
        pointer-events: auto !important;
      }

      .services-card-link{
        position: relative !important;
        z-index: 999 !important;
        pointer-events: auto !important;
        display: inline-flex; /* helps if parent has weird display */
        align-items: center;
        gap: .25rem;
      }
    </style>

    <div class="row g-3 g-md-4 services-overview-grid">

      @php
        $categoryClassMap = [
          'Assessment'   => 'services-card-label',
          'Supply'       => 'services-card-label-soft',
          'Maintenance'  => 'services-card-label-outline',
          'Projects'     => 'services-card-label',
          'Training'     => 'services-card-label-soft-orange',
          'Review'       => 'services-card-label-soft',
        ];

        // Optional icon mapping by category (since category is not icon class)
        $categoryIconMap = [
          'Assessment'  => 'bi bi-clipboard-data',
          'Supply'      => 'bi bi-fire',
          'Maintenance' => 'bi bi-arrow-repeat',
          'Projects'    => 'bi bi-buildings',
          'Training'    => 'bi bi-people-fill',
          'Review'      => 'bi bi-arrow-up-right-circle',
        ];
      @endphp

      @forelse($services as $service)
        @php
          $cat = trim((string) $service->category);
          $labelClass = $categoryClassMap[$cat] ?? 'services-card-label';
          $ctaText = $service->cta_label ?: 'Enquire now';
          $iconClass = $categoryIconMap[$cat] ?? 'bi bi-gear';
        @endphp

        <div class="col-md-4">
          <article class="services-card">

            <div class="services-card-top">
              <span class="{{ $labelClass }}">
                <i class="{{ $iconClass }}"></i>
                {{ $cat ?: 'Service' }}
              </span>

              <div class="services-card-icon">
                <i class="{{ $iconClass }}"></i>
              </div>
            </div>

            <h3 class="services-card-title">{{ $service->title }}</h3>

            <p class="services-card-text">{{ $service->short_description }}</p>

            @if($service->features && $service->features->count())
              <ul class="services-card-list">
                @foreach($service->features as $feature)
                  <li>{{ $feature->feature_text }}</li>
                @endforeach
              </ul>
            @endif

            {{-- ✅ Put CTA in its own wrapper with high z-index --}}
            <div class="services-card-cta mt-2">
              <a href="javascript:void(0)"
                 class="services-card-link"
                 data-bs-toggle="modal"
                 data-bs-target="#quickEnquiryModal"
                 data-service="{{ $service->title }}"
                 data-category="{{ $cat }}">
                {{ $ctaText }} <i class="bi bi-arrow-right-short"></i>
              </a>
            </div>

          </article>
        </div>

      @empty
        <div class="col-12">
          <div class="alert alert-warning mb-0">
            No services found. Please add services from admin panel.
          </div>
        </div>
      @endforelse

    </div>
  </div>
</section>



  <!-- =================== INDUSTRIES WE SERVE =================== -->
  <section id="services-industries" class="section-padding">
    <div class="container">
      <div class="row g-4 align-items-center services-industries-row">

        <!-- LEFT: Text + bullets -->
        <div class="col-lg-5">
          <span class="services-industries-eyebrow">Industries we support</span>
          <h2 class="services-industries-title mb-2">
            Fire safety support across diverse occupancy types.
          </h2>
          <p class="services-industries-text mb-3">
            Amtex Safety Systems works with a wide range of residential, commercial
            and industrial facilities, each with distinct fire risk profiles and
            compliance requirements.
          </p>

          <ul class="services-industries-bullets">
            <li>
              <i class="bi bi-check2-circle"></i>
              Housing societies &amp; residential buildings
            </li>
            <li>
              <i class="bi bi-check2-circle"></i>
              Offices, IT parks &amp; commercial premises
            </li>
            <li>
              <i class="bi bi-check2-circle"></i>
              Retail spaces, showrooms &amp; hospitality
            </li>
            <li>
              <i class="bi bi-check2-circle"></i>
              Factories, warehouses &amp; logistics facilities
            </li>
            <li>
              <i class="bi bi-check2-circle"></i>
              Institutions, hospitals &amp; educational campuses
            </li>
          </ul>
        </div>

        <!-- RIGHT: Industry pill panel -->
        <div class="col-lg-7">
          <div class="services-industries-panel">
            <div class="services-industries-panel-header d-flex justify-content-between align-items-center">
              <div>
                <div class="services-industries-chip">
                  <i class="bi bi-geo-alt-fill me-1"></i>
                  Multi-location service support
                </div>
                <p class="services-industries-panel-text mb-0">
                  Typical environments where Amtex fire safety equipment and services are applied.
                </p>
              </div>
              <span class="services-industries-badge">
                <i class="bi bi-shield-check me-1"></i>
                ISO &amp; ISI aligned
              </span>
            </div>

            <div class="row g-3 mt-2">

              @php
                // If icons are empty in DB, fallback icons will be used
                $fallbackIcons = [
                  'bi bi-house-door',
                  'bi bi-building',
                  'bi bi-bag',
                  'bi bi-egg-fried',
                  'bi bi-truck-front',
                  'bi bi-hospital',
                  'bi bi-briefcase',
                  'bi bi-geo-alt',
                ];
                $i = 0;
              @endphp

              @forelse($industries as $industry)
                @php
                  // DB icon should be like: "bi bi-house-door"
                  $icon = trim((string) $industry->icon);
                  if ($icon === '') {
                    $icon = $fallbackIcons[$i % count($fallbackIcons)];
                  }
                  $i++;

                  // First item highlighted like your existing design
                  $isFirst = $loop->first;
                @endphp

                <div class="col-6 col-md-4">
                  <div class="services-industries-pill {{ $isFirst ? 'services-industries-pill-highlight' : '' }}">
                    <i class="{{ $icon }}"></i>
                    <span>{{ $industry->title }}</span>
                  </div>
                </div>

              @empty
                <div class="col-12">
                  <div class="alert alert-warning mb-0">
                    No industries found. Please add industries from admin panel.
                  </div>
                </div>
              @endforelse

            </div>

            <p class="services-industries-note mb-0">
              If your facility has specialised requirements, our team can review
              the site conditions and suggest suitable fire safety measures.
            </p>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- =================== SERVICE PROCESS =================== -->
  <section id="services-process" class="section-padding">
    <div class="container">
      <div class="text-center mb-4 mb-md-5">
        <span class="services-process-eyebrow">How we work</span>
        <h2 class="services-process-title mb-2">
          A structured process for implementing fire safety services.
        </h2>
        <p class="services-process-subtitle">
          Our approach follows a clear sequence to support correct assessment,
          implementation and ongoing maintenance of fire safety equipment.
        </p>
      </div>

      <div class="row g-3 g-md-4 justify-content-center">

        @forelse($serviceProcessSteps as $step)
          @php
            // Prefer step_no if present, else fallback to loop index
            $num = $step->step_no ?: ($loop->index + 1);
            $numFormatted = str_pad((int)$num, 2, '0', STR_PAD_LEFT);
          @endphp

          <div class="col-md-3 col-6">
            <div class="services-process-step">
              <div class="services-process-number">{{ $numFormatted }}</div>
              <h3 class="services-process-heading">{{ $step->title }}</h3>
              <p class="services-process-text">{{ $step->description }}</p>
            </div>
          </div>

        @empty
          <div class="col-12">
            <div class="alert alert-warning mb-0">
              No service process steps found. Please add steps from admin panel.
            </div>
          </div>
        @endforelse

      </div>
    </div>
  </section>

  <!-- =================== SERVICES CTA =================== -->
  <section id="services-cta" class="section-padding">
    <div class="container">
      <div class="services-cta-card row align-items-center g-3">

        <div class="col-lg-8">
          <h2 class="services-cta-title">
            Need assistance with fire safety services?
          </h2>
          <p class="services-cta-text mb-0">
            Share basic details about your site and our team will help identify the
            appropriate fire safety services, equipment and maintenance requirements.
          </p>
        </div>

        <div class="col-lg-4 text-lg-end">
            <a
              href="javascript:void(0)"
              class="btn btn-amtex services-cta-btn"
              data-bs-toggle="modal"
              data-bs-target="#quickEnquiryModal"
            >
              Request service guidance
            </a>
        </div>

      </div>
    </div>
  </section>

</main>

<!-- ✅ THANK YOU MODAL -->
<div class="modal fade" id="serviceThanksModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Thank you!</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <p class="mb-0">
          Your enquiry has been submitted successfully. Our team will contact you shortly.
        </p>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-amtex" data-bs-dismiss="modal">OK</button>
      </div>

    </div>
  </div>
</div>

@if(session('enquiry_success'))
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const modalEl = document.getElementById('serviceThanksModal');
      if (modalEl && typeof bootstrap !== 'undefined') {
        const modal = new bootstrap.Modal(modalEl);
        modal.show();
      }
    });
  </script>
@endif


@endsection
