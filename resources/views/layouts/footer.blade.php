<!-- =================== FOOTER =================== -->
<footer id="main-footer">
  <div class="container">

    <!-- Top area -->
    <div class="row footer-main g-4">

      <!-- Brand / Intro -->
      <div class="col-lg-4">
        <div class="footer-brand">
          <div class="d-flex align-items-center mb-2">

            <img
              src="{{ !empty($siteSetting?->logo) ? asset('storage/'.$siteSetting->logo) : asset('frontend/assets/img/logo.png') }}"
              alt="{{ $siteSetting?->site_name ?? 'Amtex Safety Systems' }}"
              class="footer-logo me-2"
            />

            <span class="footer-tagline-badge">Safety with Quality</span>
          </div>

          <p class="footer-text">
            {{ $siteSetting?->footer_about ?? 'Amtex Safety Systems is engaged in the design, manufacture and supply of certified fire extinguishers and fire safety solutions for residential, commercial and industrial applications across India.' }}
          </p>

          <div class="footer-badges">
            <span><i class="bi bi-shield-check me-1"></i>ISO 9001:2015 Certified</span>
            <span><i class="bi bi-award me-1"></i>BIS / ISI Approved Products</span>
          </div>
        </div>
      </div>

      <!-- Navigation Links -->
      <div class="col-lg-5">
        <div class="row g-4">
          <div class="col-6 col-md-6">
            <h6 class="footer-heading">Explore</h6>
            <ul class="footer-links list-unstyled">
              <li><a href="{{ url('/products') }}">Products</a></li>
              <li><a href="{{ url('/services') }}">Professional Services</a></li>
              <li><a href="{{ url('/upgrade') }}">Technology Upgrade</a></li>
              <li><a href="{{ url('/dealership') }}">Channel Partnership</a></li>
              <li><a href="{{ url('/contact') }}">Contact</a></li>

              {{-- Dynamic pages: Add on Navigation bar --}}
              @if(!empty($navbarPages) && $navbarPages->count())
                @foreach($navbarPages as $p)
                  <li>
                    <a href="{{ route('frontend.pages.show', $p->slug) }}">{{ $p->title }}</a>
                  </li>
                @endforeach
              @endif
            </ul>
          </div>

          <div class="col-6 col-md-6">
            <h6 class="footer-heading">Resources</h6>
            <ul class="footer-links list-unstyled">
              <li><a href="{{ url('/certificates-clients') }}">Certificates &amp; Clients</a></li>
              <li><a href="{{ url('/faq') }}">FAQs</a></li>
              <li><a href="#">Product Catalogues</a></li>
              <li><a href="{{ url('/support-amc') }}">Refilling &amp; AMC</a></li>

              {{-- Dynamic pages: Add on Footer --}}
              @if(!empty($footerPages) && $footerPages->count())
                @foreach($footerPages as $p)
                  <li>
                    <a href="{{ route('frontend.pages.show', $p->slug) }}">{{ $p->title }}</a>
                  </li>
                @endforeach
              @else
                {{-- Fallback (optional): keep if you still want static links when no DB pages exist --}}
                <li><a href="{{ url('/pages/privacy-policy') }}">Privacy Policy</a></li>
              @endif
            </ul>
          </div>
        </div>
      </div>

      <!-- Contact / Social -->
      <div class="col-lg-3">
        <h6 class="footer-heading">Contact</h6>

        <p class="footer-text mb-2">
          {!! nl2br(e($siteSetting?->address ?? '')) !!}
        </p>

        @if(!empty($siteSetting?->phone))
          <p class="footer-text mb-1 footer-contact-line">
            <i class="bi bi-telephone-outbound me-1"></i>
            <a href="tel:{{ preg_replace('/\s+/', '', $siteSetting->phone) }}">{{ $siteSetting->phone }}</a>
          </p>
        @endif

        @if(!empty($siteSetting?->email))
          <p class="footer-text mb-1 footer-contact-line">
            <i class="bi bi-envelope me-1"></i>
            <a href="mailto:{{ $siteSetting->email }}">{{ $siteSetting->email }}</a>
          </p>
        @endif

        @if(!empty($siteSetting?->whatsapp))
          <p class="footer-text mb-3 footer-contact-line">
            <i class="bi bi-whatsapp me-1"></i>
            <a
              target="_blank"
              rel="noopener"
              href="https://wa.me/91{{ preg_replace('/\D+/', '', $siteSetting->whatsapp) }}?text={{ urlencode('Hi '.($siteSetting?->site_name ?? 'Amtex').', I need assistance.') }}"
            >
              {{ $siteSetting->whatsapp }}
            </a>
          </p>
        @else
          <div class="mb-3"></div>
        @endif

        <div class="footer-social">
          @if(!empty($siteSetting?->linkedin))
            <a href="{{ $siteSetting->linkedin }}" target="_blank" rel="noopener" aria-label="LinkedIn">
              <i class="bi bi-linkedin"></i>
            </a>
          @endif

          @if(!empty($siteSetting?->instagram_url))
            <a href="{{ $siteSetting->instagram_url }}" target="_blank" rel="noopener" aria-label="Instagram">
              <i class="bi bi-instagram"></i>
            </a>
          @endif

          @if(!empty($siteSetting?->facebook_url))
            <a href="{{ $siteSetting->facebook_url }}" target="_blank" rel="noopener" aria-label="Facebook">
              <i class="bi bi-facebook"></i>
            </a>
          @endif

          @if(!empty($siteSetting?->youtube))
            <a href="{{ $siteSetting->youtube }}" target="_blank" rel="noopener" aria-label="YouTube">
              <i class="bi bi-youtube"></i>
            </a>
          @endif
        </div>
      </div>

    </div>

    <!-- Bottom bar -->
    <div class="footer-bottom d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
      <span class="small">
        © <span id="year"></span> {{ $siteSetting?->site_name ?? 'Amtex Safety Systems' }}. All rights reserved.
      </span>

      <div class="d-flex flex-wrap align-items-center gap-3 small">
        <span>
          Designed &amp; maintained by <strong>{{ $siteSetting?->site_name ?? 'Amtex Safety Systems' }}</strong>
        </span>

        <span class="footer-bottom-links">
          {{-- Dynamic pages: Add on Footer Bottom --}}
          @if(!empty($footerBottomPages) && $footerBottomPages->count())
            @foreach($footerBottomPages as $index => $p)
              <a href="{{ route('frontend.pages.show', $p->slug) }}">{{ $p->title }}</a>
              @if($index < ($footerBottomPages->count() - 1))
                <span class="mx-1">•</span>
              @endif
            @endforeach
          @else
            {{-- Fallback (optional) --}}
            <a href="{{ url('/pages/privacy-policy') }}">Privacy Policy</a>
            <span class="mx-1">•</span>
            <a href="{{ url('/terms') }}">Terms &amp; Conditions</a>
          @endif
        </span>
      </div>
    </div>

  </div>
</footer>
