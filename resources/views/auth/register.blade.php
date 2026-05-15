@extends('web_master')
@section('main')

@php
    use App\Models\SiteSetting;

    $siteSetting = SiteSetting::first();
@endphp

<main>

  <!-- =================== REGISTER HERO =================== -->
  <section id="register-hero">
    <div class="container">
      <div class="row align-items-center g-4 register-hero-row">

        <!-- Left: brand story -->
        <div class="col-lg-6">
          <div class="register-hero-eyebrow-row d-flex flex-wrap align-items-center gap-2 mb-2">
            <span class="register-hero-eyebrow">
              <i class="bi bi-person-plus me-1"></i>
              Create your Amtex account
            </span>
            <span class="register-hero-badge">
              <i class="bi bi-star-fill me-1"></i>
              Customers, facility teams &amp; dealers
            </span>
          </div>

          <h1 class="register-hero-title">
            Get more control over
            <span>your fire safety in minutes.</span>
          </h1>

          <p class="register-hero-subtitle">
            Register once to access order history, AMC schedules, refilling reminders and
            priority support. Designed for customers, safety officers and dealer partners.
          </p>

          <div class="register-hero-highlights">
            <div class="register-hero-highlight-item">
              <i class="bi bi-clipboard-check"></i>
              <span>Manage products &amp; services in one place</span>
            </div>
            <div class="register-hero-highlight-item">
              <i class="bi bi-bell"></i>
              <span>Stay ahead of due refilling &amp; AMC</span>
            </div>
            <div class="register-hero-highlight-item">
              <i class="bi bi-people"></i>
              <span>Built for both end-users &amp; dealers</span>
            </div>
          </div>

          <div class="register-hero-meta-strip">
            <span><i class="bi bi-shield-lock-fill me-1"></i>Bank-grade security</span>
            <span><i class="bi bi-clock-history me-1"></i>Registration in under 2 minutes</span>
          </div>
        </div>

        <!-- Right: register card -->
        <div class="col-lg-5 offset-lg-1">
          <div class="register-card">
            <div class="register-card-header d-flex justify-content-between align-items-center">
              <div>
                <div class="register-card-eyebrow">Start here</div>
                <div class="register-card-title">Create your account</div>
              </div>
              <span class="register-card-chip">
                <i class="bi bi-lock-fill me-1"></i>
                Secure sign-up
              </span>
            </div>

            @if(session('message'))
              <div class="alert alert-info" role="alert">
                {{ session('message') }}
              </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="register-card-form">
              @csrf

              <div class="row g-2">

                <!-- Full Name -->
                <div class="col-12">
                  <div class="register-field-group">
                    <label class="register-field-label" for="name">
                      Full Name
                    </label>
                    <div class="register-input-wrap">
                      <i class="bi bi-person register-input-icon"></i>
                      <input
                        id="name"
                        name="name"
                        type="text"
                        class="form-control register-input{{ $errors->has('name') ? ' is-invalid' : '' }}"
                        placeholder="Enter your full name"
                        value="{{ old('name', null) }}"
                        required
                        autofocus
                      />
                    </div>

                    @if($errors->has('name'))
                      <div class="invalid-feedback d-block">
                        {{ $errors->first('name') }}
                      </div>
                    @endif
                  </div>
                </div>

                <!-- Mobile -->
                <div class="col-md-6">
                  <div class="register-field-group">
                    <label class="register-field-label" for="mobile">
                      Mobile Number
                    </label>
                    <div class="register-input-wrap">
                      <i class="bi bi-phone register-input-icon"></i>
                      <input
                        id="mobile"
                        name="mobile"
                        type="tel"
                        class="form-control register-input{{ $errors->has('mobile') ? ' is-invalid' : '' }}"
                        placeholder="10-digit mobile number"
                        value="{{ old('mobile', null) }}"
                      />
                    </div>

                    @if($errors->has('mobile'))
                      <div class="invalid-feedback d-block">
                        {{ $errors->first('mobile') }}
                      </div>
                    @endif
                  </div>
                </div>

                <!-- Email -->
                <div class="col-md-6">
                  <div class="register-field-group">
                    <label class="register-field-label" for="email">
                      Email Address
                    </label>
                    <div class="register-input-wrap">
                      <i class="bi bi-envelope register-input-icon"></i>
                      <input
                        id="email"
                        name="email"
                        type="email"
                        class="form-control register-input{{ $errors->has('email') ? ' is-invalid' : '' }}"
                        placeholder="name@example.com"
                        value="{{ old('email', null) }}"
                        required
                      />
                    </div>

                    @if($errors->has('email'))
                      <div class="invalid-feedback d-block">
                        {{ $errors->first('email') }}
                      </div>
                    @endif
                  </div>
                </div>

                <!-- Account Type -->
                <div class="col-md-6">
                  <div class="register-field-group">
                    <label class="register-field-label" for="account_type">
                      Account Type
                    </label>
                    <div class="register-input-wrap register-input-wrap-select">
                      <i class="bi bi-building register-input-icon"></i>
                      <select
                        id="account_type"
                        name="account_type"
                        class="form-select register-input register-input-select{{ $errors->has('account_type') ? ' is-invalid' : '' }}"
                      >
                        <option value="">Choose type</option>
                        <option value="customer" {{ old('account_type') == 'customer' ? 'selected' : '' }}>
                          Customer / End-user
                        </option>
                        <option value="dealer" {{ old('account_type') == 'dealer' ? 'selected' : '' }}>
                          Dealer / Partner
                        </option>
                        <option value="facility_team" {{ old('account_type') == 'facility_team' ? 'selected' : '' }}>
                          Facility / Safety Team
                        </option>
                      </select>
                    </div>

                    @if($errors->has('account_type'))
                      <div class="invalid-feedback d-block">
                        {{ $errors->first('account_type') }}
                      </div>
                    @endif
                  </div>
                </div>

                <!-- Company / Organisation -->
                <div class="col-md-6">
                  <div class="register-field-group">
                    <label class="register-field-label" for="company_name">
                      Company / Organisation (Optional)
                    </label>
                    <div class="register-input-wrap">
                      <i class="bi bi-briefcase register-input-icon"></i>
                      <input
                        id="company_name"
                        name="company_name"
                        type="text"
                        class="form-control register-input{{ $errors->has('company_name') ? ' is-invalid' : '' }}"
                        placeholder="Company / Organisation name"
                        value="{{ old('company_name', null) }}"
                      />
                    </div>

                    @if($errors->has('company_name'))
                      <div class="invalid-feedback d-block">
                        {{ $errors->first('company_name') }}
                      </div>
                    @endif
                  </div>
                </div>

                <!-- Password -->
                <div class="col-md-6">
                  <div class="register-field-group">
                    <label class="register-field-label" for="password">
                      Password
                    </label>
                    <div class="register-input-wrap">
                      <i class="bi bi-lock register-input-icon"></i>
                      <input
                        id="password"
                        name="password"
                        type="password"
                        class="form-control register-input{{ $errors->has('password') ? ' is-invalid' : '' }}"
                        placeholder="Create a strong password"
                        required
                      />
                      <button type="button" class="register-input-visibility" id="toggleRegisterPassword" aria-label="Toggle password visibility">
                        <i class="bi bi-eye"></i>
                      </button>
                    </div>

                    @if($errors->has('password'))
                      <div class="invalid-feedback d-block">
                        {{ $errors->first('password') }}
                      </div>
                    @endif
                  </div>
                </div>

                <!-- Confirm Password -->
                <div class="col-md-6">
                  <div class="register-field-group">
                    <label class="register-field-label" for="password_confirmation">
                      Confirm Password
                    </label>
                    <div class="register-input-wrap">
                      <i class="bi bi-lock-fill register-input-icon"></i>
                      <input
                        id="password_confirmation"
                        name="password_confirmation"
                        type="password"
                        class="form-control register-input"
                        placeholder="Re-enter password"
                        required
                      />
                    </div>
                  </div>
                </div>
              </div>

              <!-- Terms + newsletter -->
              <div class="register-options">
                <label class="register-check" for="terms">
                  <input
                    id="terms"
                    name="terms"
                    type="checkbox"
                    value="1"
                    {{ old('terms') ? 'checked' : '' }}
                  />
                  <span>
                    I agree to the
                    <a href="#" class="register-link-inline">Terms of Use</a>
                    &amp;
                    <a href="#" class="register-link-inline">Privacy Policy</a>.
                  </span>
                </label>

                @if($errors->has('terms'))
                  <div class="invalid-feedback d-block">
                    {{ $errors->first('terms') }}
                  </div>
                @endif
              </div>

              <!-- Submit -->
              <button type="submit" class="btn btn-amtex register-submit-btn">
                Create account
              </button>

              <!-- Divider -->
              <div class="register-divider">
                <span>or</span>
              </div>

              <!-- Register via OTP -->
              <button type="button" class="btn register-otp-btn">
                <i class="bi bi-phone me-1"></i>
                Continue with mobile OTP
              </button>

              <p class="register-footer-text mb-0">
                Already have an account?

                @if(Route::has('login'))
                  <a href="{{ route('login') }}" class="register-footer-link">
                    Login here
                  </a>
                @else
                  <a href="login.html" class="register-footer-link">
                    Login here
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
    const togglePassword = document.getElementById('toggleRegisterPassword');
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