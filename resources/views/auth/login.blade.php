@extends('layouts.app')

@section('content')
<div class="row justify-content-center w-100">
    <div class="col-12 col-md-10 col-lg-8 col-xl-7">
        <div class="amtex-auth-card">
            <!-- Left Brand Panel -->
            <div class="amtex-auth-brand">
                <div class="amtex-auth-brand-inner">
                    <div class="amtex-auth-logo-wrap">
                        <img src="{{ asset('img/logo.png') }}" alt="{{ trans('panel.site_title') }}" class="amtex-auth-logo">
                    </div>

                    <h2 class="amtex-auth-title">{{ trans('panel.site_title') }}</h2>
                    <p class="amtex-auth-subtitle">
                        Safety with Quality — Admin Panel Login
                    </p>

                    <div class="amtex-auth-badges">
                        <span class="amtex-pill"><i class="fa fa-shield mr-2"></i>Trusted</span>
                        <span class="amtex-pill"><i class="fa fa-lock mr-2"></i>Secure</span>
                        <span class="amtex-pill"><i class="fa fa-bolt mr-2"></i>Fast</span>
                    </div>

                    <div class="amtex-auth-footer-note">
                        <i class="fa fa-info-circle mr-2"></i>
                        Use your official email & password to continue.
                    </div>
                </div>
            </div>

            <!-- Right Form Panel -->
            <div class="amtex-auth-form">
                <div class="amtex-auth-form-inner">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <h3 class="amtex-form-title mb-0">{{ trans('global.login') }}</h3>
                        <span class="amtex-form-chip">Admin</span>
                    </div>
                    <p class="text-muted mb-4">Welcome back! Please sign in to manage content and enquiries.</p>

                    @if(session('message'))
                        <div class="alert alert-info" role="alert">
                            {{ session('message') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}" class="amtex-form">
                        @csrf

                        <div class="form-group mb-3">
                            <label class="amtex-label" for="email">{{ trans('global.login_email') }}</label>
                            <div class="amtex-input-wrap">
                                <span class="amtex-input-icon"><i class="fa fa-envelope"></i></span>
                                <input
                                    id="email"
                                    name="email"
                                    type="text"
                                    class="form-control amtex-input{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                    required
                                    autocomplete="email"
                                    autofocus
                                    placeholder="name@company.com"
                                    value="{{ old('email', null) }}"
                                >
                            </div>

                            @if($errors->has('email'))
                                <div class="invalid-feedback d-block">
                                    {{ $errors->first('email') }}
                                </div>
                            @endif
                        </div>

                        <div class="form-group mb-3">
                            <label class="amtex-label" for="password">{{ trans('global.login_password') }}</label>
                            <div class="amtex-input-wrap">
                                <span class="amtex-input-icon"><i class="fa fa-lock"></i></span>
                                <input
                                    id="password"
                                    name="password"
                                    type="password"
                                    class="form-control amtex-input{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                    required
                                    placeholder="Enter your password"
                                >
                            </div>

                            @if($errors->has('password'))
                                <div class="invalid-feedback d-block">
                                    {{ $errors->first('password') }}
                                </div>
                            @endif
                        </div>

                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" name="remember" type="checkbox" id="remember" />
                                <label class="custom-control-label" for="remember">
                                    {{ trans('global.remember_me') }}
                                </label>
                            </div>

                            @if(Route::has('password.request'))
                                <a class="amtex-link" href="{{ route('password.request') }}">
                                    {{ trans('global.forgot_password') }}
                                </a>
                            @endif
                        </div>

                        <button type="submit" class="btn amtex-btn w-100 mb-3">
                            <span>Sign In</span>
                            <i class="fa fa-arrow-right ml-2"></i>
                        </button>

                        <div class="text-center">
                            <span class="text-muted">New here?</span>
                            <a class="amtex-link ml-1" href="{{ route('register') }}">
                                {{ trans('global.register') }}
                            </a>
                        </div>

                        <div class="amtex-mini-note mt-4">
                            <i class="fa fa-shield mr-2"></i>
                            Protected area — unauthorized access is prohibited.
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="amtex-auth-bottom text-center mt-3">
            <small class="text-muted">
                © {{ date('Y') }} Amtex Safety Systems. All rights reserved.
            </small>
        </div>
    </div>
</div>
@endsection
