@extends('web_master')
@section('main')

@php
    use App\Models\SiteSetting;

    $siteSetting = SiteSetting::first();
@endphp

<main>

  <!-- =================== LOGIN HERO =================== -->
  <section id="login-hero">
    <div class="container">
      <div class="row align-items-center g-4 login-hero-row">

        <!-- Left content: brand/story -->
        <div class="col-lg-6">
          <div class="login-hero-eyebrow-row d-flex flex-wrap align-items-center gap-2 mb-2">
            <span class="login-hero-eyebrow">
              <i class="bi bi-shield-lock me-1"></i>
              Secure account access
            </span>
            <span class="login-hero-badge">
              <i class="bi bi-check-circle me-1"></i>
              For customers, partners &amp; dealers
            </span>
          </div>

          <h1 class="login-hero-title">
            Sign in to manage
            <span>your fire safety with confidence.</span>
          </h1>

          <p class="login-hero-subtitle">
            Track orders, manage AMC, raise support requests and stay updated on your fire safety
            infrastructure – all from a single, secure dashboard.
          </p>

          <div class="login-hero-highlights">
            <div class="login-hero-highlight-item">
              <i class="bi bi-clipboard-check"></i>
              <span>View product &amp; service history</span>
            </div>
            <div class="login-hero-highlight-item">
              <i class="bi bi-bell"></i>
              <span>Get reminders for refilling &amp; AMC</span>
            </div>
            <div class="login-hero-highlight-item">
              <i class="bi bi-headset"></i>
              <span>Priority support for registered users</span>
            </div>
          </div>

          <div class="login-hero-meta-strip">
            <span><i class="bi bi-lock-fill me-1"></i>Bank-grade security</span>
            <span><i class="bi bi-clock-history me-1"></i>24×7 login access</span>
          </div>
        </div>

        <!-- Right content: login card -->
        <div class="col-lg-5 offset-lg-1">
          <div class="login-card">
            <div class="login-card-header d-flex justify-content-between align-items-center">
              <div>
                <div class="login-card-eyebrow">Welcome back</div>
                <div class="login-card-title">Login to your account</div>
              </div>
              <span class="login-card-chip">
                <i class="bi bi-shield-check me-1"></i>
                Secured
              </span>
            </div>

            @if(session('message'))
              <div class="alert alert-info" role="alert">
                {{ session('message') }}
              </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="login-card-form">
              @csrf

              <!-- Email / Mobile -->
              <div class="login-field-group">
                <label class="login-field-label" for="email">
                  {{ trans('global.login_email') }}
                </label>
                <div class="login-input-wrap">
                  <i class="bi bi-person login-input-icon"></i>
                  <input
                    id="email"
                    name="email"
                    type="text"
                    class="form-control login-input{{ $errors->has('email') ? ' is-invalid' : '' }}"
                    placeholder="Enter your registered email or mobile"
                    value="{{ old('email', null) }}"
                    required
                    autocomplete="email"
                    autofocus
                  />
                </div>

                @if($errors->has('email'))
                  <div class="invalid-feedback d-block">
                    {{ $errors->first('email') }}
                  </div>
                @endif
              </div>

              <!-- Password -->
              <div class="login-field-group">
                <label class="login-field-label" for="password">
                  {{ trans('global.login_password') }}
                </label>
                <div class="login-input-wrap">
                  <i class="bi bi-lock login-input-icon"></i>
                  <input
                    id="password"
                    name="password"
                    type="password"
                    class="form-control login-input{{ $errors->has('password') ? ' is-invalid' : '' }}"
                    placeholder="Enter your password"
                    required
                  />
                  <button type="button" class="login-input-visibility" id="togglePassword" aria-label="Toggle password visibility">
                    <i class="bi bi-eye"></i>
                  </button>
                </div>

                @if($errors->has('password'))
                  <div class="invalid-feedback d-block">
                    {{ $errors->first('password') }}
                  </div>
                @endif
              </div>

              <!-- Remember + Forgot -->
              <div class="login-options d-flex flex-wrap justify-content-between align-items-center">
                <label class="login-remember" for="remember">
                  <input name="remember" type="checkbox" id="remember" />
                  <span>Keep me signed in</span>
                </label>

                @if(Route::has('password.request'))
                  <a href="{{ route('password.request') }}" class="login-forgot-link">
                    Forgot password?
                  </a>
                @endif
              </div>

              <!-- Login button -->
              <button type="submit" class="btn btn-amtex login-submit-btn">
                Login securely
              </button>

              <!-- Divider -->
              <div class="login-divider">
                <span>or</span>
              </div>

              <!-- Alternative login: maybe OTP -->
              <button type="button" class="btn login-otp-btn">
                <i class="bi bi-phone me-1"></i>
                Login with OTP
              </button>

              <!-- Footer text -->
              <p class="login-footer-text mb-0">
                New to Amtex Safety?

                @if(Route::has('register'))
                  <a href="{{ route('register') }}" class="login-footer-link">
                    Create an account
                  </a>
                @else
                  <a href="register.html" class="login-footer-link">
                    Create an account
                  </a>
                @endif
              </p>
            </form>
          </div>
        </div>

      </div>
    </div>
  </section>

</main>

@endsection

@section('scripts')
@parent

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');

    if (togglePassword && passwordInput) {
      togglePassword.addEventListener('click', function () {
        const icon = this.querySelector('i');

        if (passwordInput.type === 'password') {
          passwordInput.type = 'text';

          if (icon) {
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
          }
        } else {
          passwordInput.type = 'password';

          if (icon) {
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
          }
        }
      });
    }
  });
</script>

@endsection