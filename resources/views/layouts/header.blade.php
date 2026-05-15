<!-- =================== HEADER / NAVBAR =================== -->
<header id="main-header">
  <!-- Main header row: logo + actions -->
  <div class="header-main">
    <div class="container py-2 py-lg-3">
      <div class="row align-items-center">

        <!-- Logo -->
        <div class="col-6 col-md-3">
          <a href="{{ url('/') }}" class="navbar-brand d-flex align-items-center p-0">
            @if($siteSetting && $siteSetting->logo)
              <img
                src="{{ asset('storage/'.$siteSetting->logo) }}"
                alt="{{ $siteSetting->site_name ?? 'Site Logo' }}"
                class="site-logo"
              />
            @else
              <img
                src="{{ asset('frontend/assets/img/logo.png') }}"
                alt="Default Logo"
                class="site-logo"
              />
            @endif
          </a>
        </div>

        <!-- Right actions -->
        <div class="col-6 col-md-9">
          <div class="d-flex justify-content-end align-items-center gap-2 header-actions">

            <!-- Desktop Login / Register -->
            <a href="/login" class="btn btn-sm btn-outline-light d-none d-md-inline-flex">
              Login
            </a>
            <a href="/register" class="btn btn-sm btn-light text-dark fw-semibold d-none d-md-inline-flex">
              Register
            </a>

            <!-- Cart -->
            <a href="cart.html" class="cart-icon position-relative ms-1">
              <i class="bi bi-cart3"></i>
              <span class="cart-count">0</span>
            </a>

            <!-- Mobile Login Icon -->
            <a href="/login" class="mobile-auth-icon d-inline-flex d-md-none">
              <i class="bi bi-person"></i>
            </a>

            <!-- Mobile Register Icon -->
            <a href="/register" class="mobile-auth-icon d-inline-flex d-md-none">
              <i class="bi bi-person-plus"></i>
            </a>

          </div>
        </div>

      </div>
    </div>
  </div>

  <!-- Navigation bar just below header -->
  <nav class="navbar navbar-expand-lg nav-secondary">
    <div class="container">

      <!-- Mobile toggler -->
      <button
        class="navbar-toggler ms-auto"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#mainNav"
        aria-controls="mainNav"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="mainNav">
        <ul class="navbar-nav mx-auto mb-2 mb-lg-0 nav-menu">

          <li class="nav-item">
            <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">
              Home
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link {{ request()->is('about') ? 'active' : '' }}" href="{{ url('/about') }}">
              About Us
            </a>
          </li>

          <!-- Products + Services together -->
          <li class="nav-item">
            <a class="nav-link {{ request()->is('products') ? 'active' : '' }}" href="{{ url('/products') }}">
              Products
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link {{ request()->is('services') ? 'active' : '' }}" href="{{ url('/services') }}">
              Services
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link {{ request()->is('upgrade-your-extinguisher') ? 'active' : '' }}" href="{{ url('/upgrade-your-extinguisher') }}">
              Upgrade Your Extinguisher
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link {{ request()->is('certificates-clients') ? 'active' : '' }}" href="{{ route('frontend.certificates-clients') }}">
              Certificates &amp; Clients
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link {{ request()->is('dealership') ? 'active' : '' }}" href="{{ url('/dealership') }}">
              Dealership
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link {{ request()->is('blog') ? 'active' : '' }}" href="{{ url('/blog') }}">
              Blogs
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link {{ request()->is('faq') ? 'active' : '' }}" href="{{ url('/faq') }}">
              FAQ
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">
              Contact Us
            </a>
          </li>

          {{-- Dynamic pages: Add on Navigation bar --}}
          @if(!empty($navbarPages) && $navbarPages->count())
            @foreach($navbarPages as $p)
              <li class="nav-item">
                <a
                  class="nav-link {{ request()->is('pages/'.$p->slug) ? 'active' : '' }}"
                  href="{{ route('frontend.pages.show', $p->slug) }}"
                >
                  {{ $p->title }}
                </a>
              </li>
            @endforeach
          @endif

        </ul>
      </div>

    </div>
  </nav>
</header>
