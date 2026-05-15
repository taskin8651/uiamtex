<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8" />

    <title>
        {{ $siteSetting->site_name ?? 'Amtex Safety Systems' }} – Safety with Quality
    </title>

    <meta name="viewport" content="width=device-width, initial-scale=1" />

    {{-- ✅ Dynamic Favicon --}}
    @if(!empty($siteSetting?->favicon))
        <link rel="icon" href="{{ asset('storage/'.$siteSetting->favicon) }}" type="image/png">
        <link rel="apple-touch-icon" href="{{ asset('storage/'.$siteSetting->favicon) }}">
    @else
        {{-- Fallback favicon --}}
        <link rel="icon" href="{{ asset('frontend/assets/img/favicon.png') }}" type="image/png">
    @endif

    <!-- Bootstrap CSS -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    />

    <!-- Bootstrap Icons -->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
    />

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet"
    >

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/style.css') }}" />

    {{-- ✅ Allow page-specific CSS --}}
    @stack('styles')
</head>

<body>

    <!-- =================== AMTEX PREMIUM PRELOADER =================== -->
    <div id="premium-preloader" aria-hidden="true">
        <div class="amtex-loader-card">

            <!-- Logo -->
            <div class="amtex-loader-logoWrap">
                <img src="{{ asset('frontend/assets/img/logo.png') }}" alt="Amtex Safety" class="amtex-loader-logo">
                <span class="amtex-orbit amtex-orbit-1"></span>
                <span class="amtex-orbit amtex-orbit-2"></span>
            </div>

            <!-- Sleek progress track (animated, not real %) -->
            <div class="amtex-loader-track">
                <span class="amtex-loader-sweep"></span>
            </div>

            <div class="amtex-loader-text">
                Preparing your experience…
            </div>

        </div>
    </div>
    <!-- =================== AMTEX PREMIUM PRELOADER END =================== -->




    <!-- Header -->
    @include('layouts.header')
    <!-- //Header -->

    <!-- Main Content -->
    @yield('main')
    <!--//Main Content -->

    <!-- Footer -->
    @include('layouts.footer')
    <!-- //Footer -->

    <!-- =================== FLOATING ACTION BUTTONS =================== -->
    <div class="fab-stack">
        <!-- Quick Enquiry Button -->
        <button
            type="button"
            class="fab-btn fab-enquiry"
            data-bs-toggle="modal"
            data-bs-target="#quickEnquiryModal"
            aria-label="Quick Enquiry"
            title="Quick Enquiry"
        >
            <i class="bi bi-chat-dots-fill"></i>
        </button>

        <!-- WhatsApp Button -->
        @if(!empty($siteSetting?->whatsapp))
            <a
                href="https://wa.me/{{ preg_replace('/\D+/', '', $siteSetting->whatsapp) }}?text={{ urlencode('Hi '.($siteSetting->site_name ?? 'Amtex Safety Systems').', I need a quick enquiry.') }}"
                class="fab-btn fab-whatsapp"
                target="_blank"
                rel="noopener"
                aria-label="WhatsApp"
                title="WhatsApp"
            >
                <i class="bi bi-whatsapp"></i>
            </a>
        @endif
    </div>

    <!-- =================== QUICK ENQUIRY MODAL =================== -->
    <div
        class="modal fade"
        id="quickEnquiryModal"
        tabindex="-1"
        aria-labelledby="quickEnquiryModalLabel"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content qe-modal">

                <div class="modal-header qe-modal-header">
                    <div>
                        <h5 class="modal-title" id="quickEnquiryModalLabel">Quick Enquiry</h5>
                        <p class="qe-modal-subtitle mb-0">
                            Share your requirement and our team will contact you shortly.
                        </p>
                    </div>

                    <button type="button" class="btn-close qe-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body qe-modal-body">
                    <form id="quickEnquiryPopupForm" class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label qe-label">Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="full_name" class="form-control qe-input" placeholder="Enter full name" required />
                        </div>

                        <div class="col-md-6">
                            <label class="form-label qe-label">Email</label>
                            <input type="email" name="email" class="form-control qe-input" placeholder="Enter email (optional)" />
                        </div>

                        <div class="col-md-6">
                            <label class="form-label qe-label">Phone Number <span class="text-danger">*</span></label>
                            <input type="tel" name="phone" class="form-control qe-input" placeholder="Enter phone number" required />
                        </div>

                        <div class="col-md-6">
                            <label class="form-label qe-label">City / Premises (Optional)</label>
                            <input type="text" name="city" class="form-control qe-input" placeholder="e.g. Delhi, Office, Warehouse" />
                        </div>

                        <div class="col-12">
                            <label class="form-label qe-label">Message <span class="text-danger">*</span></label>
                            <textarea
                                name="message"
                                class="form-control qe-input qe-textarea"
                                rows="4"
                                placeholder="Tell us what you need (products, refilling, AMC, installation, etc.)"
                                required
                            ></textarea>
                        </div>

                        <div class="col-12 d-flex flex-column flex-md-row gap-2 align-items-md-center justify-content-between mt-1">
                            <div class="qe-privacy-note">
                                <i class="bi bi-lock-fill me-1"></i>
                                Your information will be used only for enquiry assistance.
                            </div>

                            <button type="submit" class="btn btn-amtex px-4 qe-modal-submit">
                                Submit Enquiry
                            </button>
                        </div>

                        <!-- Success / Error message -->
                        <div class="col-12">
                            <div id="qePopupMsg" class="qe-popup-msg d-none"></div>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>

    {{-- Footer year (only if element exists) --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var yearEl = document.getElementById('year');
            if (yearEl) yearEl.textContent = new Date().getFullYear();
        });
    </script>

    <!-- Bootstrap JS (Modal needs this) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JS -->
    <script src="{{ asset('frontend/assets/js/main.js') }}"></script>

    {{-- ✅ Allow page-specific JS (YOUR modal image script is here) --}}
    @stack('scripts')

<script>
window.addEventListener('load', () => {
    const loader = document.getElementById('premium-preloader');
    if (!loader) return;

    setTimeout(() => loader.classList.add('hide'), 350);
    setTimeout(() => loader.remove(), 900);
});
</script>



</body>
</html>
