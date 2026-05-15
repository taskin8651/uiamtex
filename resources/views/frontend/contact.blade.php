@extends('web_master')
@section('main')

<!-- =================== MAIN =================== -->
<main id="contact-main">

<!-- =================== CONTACT HERO =================== -->
<section id="contact-hero" class="contact-section-pad">
  <div class="container">

    <div class="contact-breadcrumb">
      <a href="{{ url('/') }}">Home</a>
      <span>•</span>
      <span class="contact-breadcrumb-active">Contact Us</span>
    </div>

    <div class="row g-4 align-items-center">
      <div class="col-lg-7">

        <div class="contact-hero-chiprow d-flex flex-wrap gap-2 mb-2">
          <span class="contact-hero-chip">
            <i class="bi bi-headset me-1"></i>
            Talk to a safety expert
          </span>
          <span class="contact-hero-chip contact-hero-chip-dark">
            <i class="bi bi-shield-check me-1"></i>
            Audit-ready guidance • ISO/ISI focused
          </span>
        </div>

        <h1 class="contact-hero-title">
          Get the right fire safety plan
          <span>for your site — products, service & compliance.</span>
        </h1>

        <p class="contact-hero-subtitle">
          Share your premises type and risk areas (electrical, kitchen, warehouse, parking, etc.).
          We’ll recommend suitable extinguisher models, placement, and AMC/refilling support with proper documentation.
        </p>

        <div class="contact-hero-stats d-flex flex-wrap gap-2 mt-3">
          <div class="contact-hero-stat">
            <i class="bi bi-geo-alt"></i>
            <div>
              <div class="contact-hero-stat-title">Pan-India support</div>
              <div class="contact-hero-stat-sub">Dispatch + service network*</div>
            </div>
          </div>
          <div class="contact-hero-stat">
            <i class="bi bi-lightning-charge"></i>
            <div>
              <div class="contact-hero-stat-title">Quick callback</div>
              <div class="contact-hero-stat-sub">Same/next working day*</div>
            </div>
          </div>
          <div class="contact-hero-stat">
            <i class="bi bi-clipboard-check"></i>
            <div>
              <div class="contact-hero-stat-title">Inspection-ready</div>
              <div class="contact-hero-stat-sub">Records, tagging & docs</div>
            </div>
          </div>
        </div>

        <p class="contact-hero-footnote mb-0 mt-2">
          *Service/response timelines depend on location and requirement.
        </p>

      </div>

      <div class="col-lg-5">
        <div class="contact-hero-card">
          <div class="contact-hero-card-head">
            <div>
              <div class="contact-hero-card-label">Quick enquiry</div>
              <div class="contact-hero-card-title">Request a callback</div>
            </div>
            <span class="contact-hero-mini">
              <i class="bi bi-lightning-charge-fill me-1"></i> 60 sec
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

<form method="POST" action="{{ route('frontend.contact.store') }}" class="contact-hero-form row g-2 mt-2">
  @csrf

  <div class="col-12">
    <input
      type="text"
      name="name"
      class="form-control contact-input{{ $errors->has('name') ? ' is-invalid' : '' }}"
      placeholder="Full name *"
      value="{{ old('name') }}"
      required
    />

    @if($errors->has('name'))
      <div class="invalid-feedback d-block">
        {{ $errors->first('name') }}
      </div>
    @endif
  </div>

  <div class="col-12">
    <input
      type="tel"
      name="phone"
      class="form-control contact-input{{ $errors->has('phone') ? ' is-invalid' : '' }}"
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
      type="email"
      name="email"
      class="form-control contact-input{{ $errors->has('email') ? ' is-invalid' : '' }}"
      placeholder="Email (optional)"
      value="{{ old('email') }}"
    />

    @if($errors->has('email'))
      <div class="invalid-feedback d-block">
        {{ $errors->first('email') }}
      </div>
    @endif
  </div>

  <div class="col-12">
    <select
      name="enquiry_type"
      class="form-select contact-input{{ $errors->has('enquiry_type') ? ' is-invalid' : '' }}"
    >
      <option value="">What can we help you with?</option>
      <option value="Right product selection" {{ old('enquiry_type') == 'Right product selection' ? 'selected' : '' }}>
        Right product selection
      </option>
      <option value="Installation / Projects" {{ old('enquiry_type') == 'Installation / Projects' ? 'selected' : '' }}>
        Installation / Projects
      </option>
      <option value="AMC / Refilling" {{ old('enquiry_type') == 'AMC / Refilling' ? 'selected' : '' }}>
        AMC / Refilling
      </option>
      <option value="Upgrade (Powder → Mist)" {{ old('enquiry_type') == 'Upgrade (Powder → Mist)' ? 'selected' : '' }}>
        Upgrade (Powder → Mist)
      </option>
      <option value="Dealership enquiry" {{ old('enquiry_type') == 'Dealership enquiry' ? 'selected' : '' }}>
        Dealership enquiry
      </option>
    </select>
  </div>

  <div class="col-12">
    <button type="submit" class="contact-submit-btn w-100">
      Send enquiry
      <i class="bi bi-arrow-right-short ms-1"></i>
    </button>

    <p class="contact-form-note mb-0">
      <i class="bi bi-lock-fill me-1"></i>Your details stay private. No spam.
    </p>
  </div>
</form>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- =================== CONTACT INFO =================== -->
<section id="contact-info" class="contact-section-pad">
  <div class="container">
    <div class="row g-3 g-md-4">

      <!-- Call -->
      <div class="col-md-4">
        <div class="contact-info-card">
          <div class="contact-info-icon">
            <i class="bi bi-telephone-outbound"></i>
          </div>
          <h3 class="contact-info-title">Speak with us</h3>
          <p class="contact-info-text">
            Talk directly to our fire safety advisors for quick guidance and support.
          </p>
          @if(!empty($siteSetting?->phone))
            <a class="contact-info-link" href="tel:{{ preg_replace('/\D+/', '', $siteSetting->phone) }}">
              {{ $siteSetting->phone }}
            </a>
          @endif
        </div>
      </div>

      <!-- Email -->
      <div class="col-md-4">
        <div class="contact-info-card">
          <div class="contact-info-icon">
            <i class="bi bi-envelope"></i>
          </div>
          <h3 class="contact-info-title">Email your requirement</h3>
          <p class="contact-info-text">
            Share BOQs, drawings, site details or tender enquiries with our team.
          </p>
          @if(!empty($siteSetting?->email))
            <a class="contact-info-link" href="mailto:{{ $siteSetting->email }}">
              {{ $siteSetting->email }}
            </a>
          @endif
        </div>
      </div>

      <!-- Visit -->
      <div class="col-md-4">
        <div class="contact-info-card">
          <div class="contact-info-icon">
            <i class="bi bi-geo-alt"></i>
          </div>
          <h3 class="contact-info-title">Visit our office</h3>
          <p class="contact-info-text">
            Monday – Saturday | During business hours
          </p>
          @if(!empty($siteSetting?->address))
            <div class="contact-info-address">
              {!! nl2br(e($siteSetting->address)) !!}
            </div>
          @endif
        </div>
      </div>

    </div>
  </div>
</section>

<!-- =================== FORM + MAP =================== -->
<section id="contact-form-map" class="contact-section-pad">
  <div class="container">
    <div class="row g-3 g-md-4 align-items-stretch">

      <div class="col-lg-6">
        <div class="contact-form-box">
          <span class="contact-form-eyebrow">
            <i class="bi bi-clipboard-check me-1"></i> Share your site details
          </span>
          <h2 class="contact-form-title">Tell us about your requirement</h2>
          <p class="contact-form-subtitle">
            We’ll recommend the right extinguisher models, quantities and maintenance plan based on your site type.
          </p>

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

<form method="POST" action="{{ route('frontend.contact.store') }}" class="row g-2 g-md-3">
  @csrf

  <div class="col-md-6">
    <input
      type="text"
      name="name"
      class="form-control contact-input{{ $errors->has('name') ? ' is-invalid' : '' }}"
      placeholder="Full name *"
      value="{{ old('name') }}"
      required
    />

    @if($errors->has('name'))
      <div class="invalid-feedback d-block">
        {{ $errors->first('name') }}
      </div>
    @endif
  </div>

  <div class="col-md-6">
    <input
      type="tel"
      name="phone"
      class="form-control contact-input{{ $errors->has('phone') ? ' is-invalid' : '' }}"
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

  <div class="col-md-6">
    <input
      type="email"
      name="email"
      class="form-control contact-input{{ $errors->has('email') ? ' is-invalid' : '' }}"
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
      class="form-control contact-input"
      placeholder="City / Location"
      value="{{ old('city') }}"
    />
  </div>

  <div class="col-12">
    <select name="premises_type" class="form-select contact-input">
      <option value="">Type of premises</option>
      <option value="Apartment / Society" {{ old('premises_type') == 'Apartment / Society' ? 'selected' : '' }}>
        Apartment / Society
      </option>
      <option value="Office / IT park" {{ old('premises_type') == 'Office / IT park' ? 'selected' : '' }}>
        Office / IT park
      </option>
      <option value="Shop / Showroom" {{ old('premises_type') == 'Shop / Showroom' ? 'selected' : '' }}>
        Shop / Showroom
      </option>
      <option value="Restaurant / Kitchen" {{ old('premises_type') == 'Restaurant / Kitchen' ? 'selected' : '' }}>
        Restaurant / Kitchen
      </option>
      <option value="Factory / Warehouse" {{ old('premises_type') == 'Factory / Warehouse' ? 'selected' : '' }}>
        Factory / Warehouse
      </option>
      <option value="Institution / Hospital" {{ old('premises_type') == 'Institution / Hospital' ? 'selected' : '' }}>
        Institution / Hospital
      </option>
    </select>
  </div>

  <div class="col-12">
    <textarea
      rows="4"
      name="message"
      class="form-control contact-input contact-textarea{{ $errors->has('message') ? ' is-invalid' : '' }}"
      placeholder="Brief requirement (e.g. 10 extinguishers for office + AMC)…"
    >{{ old('message') }}</textarea>

    @if($errors->has('message'))
      <div class="invalid-feedback d-block">
        {{ $errors->first('message') }}
      </div>
    @endif
  </div>

  <input type="hidden" name="enquiry_type" value="Consultation Request">

  <div class="col-12">
    <button type="submit" class="contact-submit-btn w-100">
      Request consultation
      <i class="bi bi-arrow-right-short ms-1"></i>
    </button>

    <div class="contact-form-trust mt-2">
      <span><i class="bi bi-shield-check me-1"></i>ISO-certified guidance</span>
      <span><i class="bi bi-file-earmark-text me-1"></i>Audit-ready documentation</span>
    </div>
  </div>
</form>

        </div>
      </div>

      <div class="col-lg-6">
            <div class="contact-map-box">
                <div class="contact-map-top">
                <div>
                    <div class="contact-map-title">Our location</div>
                    <div class="contact-map-sub">Open exact office location</div>
                </div>

                @if(!empty($siteSetting?->address))
                    <a class="contact-map-btn"
                    href="https://www.google.com/maps/search/?api=1&query={{ urlencode($siteSetting->address) }}"
                    target="_blank" rel="noopener">
                    <i class="bi bi-geo-alt-fill me-1"></i> Open in Maps
                    </a>
                @elseif(!empty($siteSetting?->map_embed))
                    <a class="contact-map-btn"
                    href="{{ $siteSetting->map_embed }}"
                    target="_blank" rel="noopener">
                    <i class="bi bi-geo-alt-fill me-1"></i> Open in Maps
                    </a>
                @endif
                </div>

                @if(!empty($siteSetting?->map_embed))

                {{-- If admin saved full iframe code --}}
                @if(\Illuminate\Support\Str::contains($siteSetting->map_embed, '<iframe'))
                    {!! $siteSetting->map_embed !!}
                @else
                    {{-- If admin saved only a URL, convert it into iframe --}}
                    <iframe
                    src="{{ $siteSetting->map_embed }}"
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                @endif

                @else
                {{-- Default fallback map --}}
                <iframe
                    src="https://www.google.com/maps?q=India&output=embed"
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
                @endif

            </div>
        </div>


    </div>
  </div>
</section>

</main>

@endsection
