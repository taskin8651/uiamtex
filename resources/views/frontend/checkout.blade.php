@extends('web_master')
@section('main')

@php
    $cart = $cart ?? session('cart', []);

    $subtotal = $subtotal ?? collect($cart)->sum(function ($item) {
        return (float) ($item['price'] ?? 0) * (int) ($item['quantity'] ?? 1);
    });

    $shipping = $shipping ?? 0;
    $tax = $tax ?? 0;
    $total = $total ?? ($subtotal + $shipping + $tax);

    function checkoutPrice($amount) {
        return '₹' . number_format((float) $amount);
    }

    $authUser = auth()->user();
@endphp

<style>
    /* ================= CHECKOUT PAGE ================= */

#checkout-hero {
    position: relative;
    overflow: hidden;
    padding: 82px 0 60px;
    background:
        radial-gradient(circle at 12% 20%, rgba(220, 38, 38, 0.13), transparent 34%),
        radial-gradient(circle at 90% 10%, rgba(15, 23, 42, 0.10), transparent 32%),
        linear-gradient(135deg, #ffffff 0%, #f8fafc 50%, #fff5f5 100%);
}

.checkout-hero-row {
    position: relative;
    z-index: 2;
}

.checkout-hero-eyebrow-row {
    gap: 10px;
}

.checkout-hero-eyebrow,
.checkout-hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 9px 14px;
    border-radius: 999px;
    font-size: 13px;
    font-weight: 800;
}

.checkout-hero-eyebrow {
    color: #991b1b;
    background: rgba(254, 226, 226, 0.8);
    border: 1px solid rgba(248, 113, 113, 0.25);
}

.checkout-hero-badge {
    color: #0f172a;
    background: rgba(255, 255, 255, 0.86);
    border: 1px solid rgba(15, 23, 42, 0.08);
    box-shadow: 0 14px 36px rgba(15, 23, 42, 0.06);
}

.checkout-hero-title {
    max-width: 760px;
    margin: 0 0 16px;
    color: #0f172a;
    font-size: clamp(36px, 5vw, 62px);
    line-height: 1.04;
    font-weight: 900;
    letter-spacing: -0.055em;
}

.checkout-hero-title span {
    display: block;
    color: #dc2626;
}

.checkout-hero-subtitle {
    max-width: 660px;
    color: #475569;
    font-size: 16px;
    line-height: 1.8;
    font-weight: 500;
}

.checkout-hero-stats {
    margin-top: 18px;
}

.checkout-hero-stat {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 10px 14px;
    border-radius: 999px;
    color: #334155;
    font-size: 14px;
    font-weight: 800;
    background: rgba(255, 255, 255, 0.82);
    border: 1px solid rgba(15, 23, 42, 0.08);
    box-shadow: 0 12px 30px rgba(15, 23, 42, 0.05);
}

.checkout-hero-stat i {
    color: #dc2626;
}

.checkout-hero-meta-strip {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-top: 18px;
}

.checkout-hero-meta-strip span {
    display: inline-flex;
    align-items: center;
    padding: 10px 14px;
    border-radius: 18px;
    color: #475569;
    font-size: 13px;
    font-weight: 700;
    background: rgba(15, 23, 42, 0.04);
    border: 1px solid rgba(15, 23, 42, 0.06);
}

.checkout-hero-panel {
    padding: 26px;
    border-radius: 30px;
    background: rgba(255, 255, 255, 0.88);
    border: 1px solid rgba(15, 23, 42, 0.08);
    box-shadow: 0 26px 70px rgba(15, 23, 42, 0.11);
    backdrop-filter: blur(20px);
}

.checkout-hero-panel-header {
    gap: 15px;
    margin-bottom: 18px;
}

.checkout-hero-panel-label {
    color: #dc2626;
    font-size: 12px;
    font-weight: 900;
    text-transform: uppercase;
    letter-spacing: 0.10em;
}

.checkout-hero-panel-title {
    color: #0f172a;
    font-size: 22px;
    font-weight: 900;
    letter-spacing: -0.03em;
}

.checkout-hero-panel-chip {
    flex: 0 0 auto;
    display: inline-flex;
    align-items: center;
    padding: 8px 12px;
    border-radius: 999px;
    color: #065f46;
    font-size: 12px;
    font-weight: 900;
    background: #ecfdf5;
    border: 1px solid rgba(16, 185, 129, 0.18);
}

.checkout-hero-panel-list {
    list-style: none;
    padding: 0;
    margin: 0;
    display: grid;
    gap: 12px;
}

.checkout-hero-panel-list li {
    display: flex;
    gap: 12px;
    color: #475569;
    font-size: 14px;
    line-height: 1.6;
    font-weight: 700;
}

.checkout-hero-panel-list i {
    width: 34px;
    height: 34px;
    flex: 0 0 auto;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    color: #ffffff;
    border-radius: 13px;
    background: linear-gradient(135deg, #ef4444, #991b1b);
}

/* Main */

#checkout-main {
    background: #ffffff;
}

.section-padding {
    padding: 76px 0;
}

.checkout-form-card,
.checkout-summary-card {
    border-radius: 30px;
    background: #ffffff;
    border: 1px solid rgba(15, 23, 42, 0.08);
    box-shadow: 0 24px 70px rgba(15, 23, 42, 0.08);
}

.checkout-form-card {
    padding: 30px;
}

.checkout-form-header {
    gap: 15px;
    padding-bottom: 22px;
    margin-bottom: 24px;
    border-bottom: 1px solid rgba(15, 23, 42, 0.08);
}

.checkout-form-title {
    color: #0f172a;
    font-size: 24px;
    font-weight: 900;
    letter-spacing: -0.035em;
}

.checkout-form-subtitle {
    margin-top: 4px;
    color: #64748b;
    font-size: 14px;
    font-weight: 600;
}

.checkout-form-chip {
    flex: 0 0 auto;
    display: inline-flex;
    align-items: center;
    padding: 8px 12px;
    border-radius: 999px;
    color: #991b1b;
    background: #fee2e2;
    font-size: 12px;
    font-weight: 900;
}

.checkout-field-group {
    height: 100%;
}

.checkout-field-label {
    display: block;
    margin-bottom: 8px;
    color: #0f172a;
    font-size: 13px;
    font-weight: 900;
}

.checkout-input-wrap {
    position: relative;
}

.checkout-input-icon {
    position: absolute;
    left: 16px;
    top: 50%;
    transform: translateY(-50%);
    color: #dc2626;
    font-size: 15px;
    z-index: 2;
}

.checkout-textarea-wrap .checkout-input-icon {
    top: 20px;
    transform: none;
}

.checkout-input {
    width: 100%;
    min-height: 54px;
    padding: 12px 16px 12px 46px;
    border-radius: 17px;
    color: #0f172a;
    font-size: 14px;
    font-weight: 700;
    background: #ffffff;
    border: 1px solid rgba(15, 23, 42, 0.11);
    box-shadow: 0 12px 30px rgba(15, 23, 42, 0.04);
    transition: 0.25s ease;
}

.checkout-input:focus {
    border-color: rgba(220, 38, 38, 0.45);
    box-shadow:
        0 0 0 4px rgba(220, 38, 38, 0.08),
        0 14px 34px rgba(15, 23, 42, 0.06);
}

.checkout-input::placeholder {
    color: #94a3b8;
    font-weight: 600;
}

.checkout-textarea {
    min-height: 118px;
    resize: vertical;
}

.checkout-input-select {
    cursor: pointer;
}

/* Summary */

.checkout-summary-card {
    position: sticky;
    top: 100px;
    overflow: hidden;
}

.checkout-summary-header {
    padding: 25px 25px 18px;
    background:
        radial-gradient(circle at 20% 10%, rgba(220, 38, 38, 0.11), transparent 30%),
        linear-gradient(135deg, #ffffff, #fff7f7);
    border-bottom: 1px solid rgba(15, 23, 42, 0.08);
}

.checkout-summary-title {
    color: #0f172a;
    font-size: 23px;
    font-weight: 900;
    letter-spacing: -0.035em;
}

.checkout-summary-subtitle {
    margin-top: 4px;
    color: #64748b;
    font-size: 13px;
    font-weight: 700;
}

.checkout-summary-products {
    padding: 18px 20px;
    display: grid;
    gap: 14px;
    border-bottom: 1px solid rgba(15, 23, 42, 0.08);
}

.checkout-summary-product {
    display: grid;
    grid-template-columns: 58px minmax(0, 1fr) auto;
    gap: 12px;
    align-items: center;
}

.checkout-summary-product-img {
    width: 58px;
    height: 58px;
    border-radius: 18px;
    overflow: hidden;
    background: #f8fafc;
    border: 1px solid rgba(15, 23, 42, 0.08);
}

.checkout-summary-product-img img {
    width: 100%;
    height: 100%;
    object-fit: contain;
}

.checkout-summary-product-name {
    color: #0f172a;
    font-size: 14px;
    font-weight: 900;
    line-height: 1.35;
}

.checkout-summary-product-meta {
    color: #64748b;
    font-size: 12px;
    font-weight: 700;
    margin-top: 3px;
}

.checkout-summary-product-price {
    color: #0f172a;
    font-size: 14px;
    font-weight: 900;
    white-space: nowrap;
}

.checkout-summary-body {
    padding: 24px 25px 25px;
}

.checkout-summary-row {
    display: flex;
    justify-content: space-between;
    gap: 16px;
    margin-bottom: 14px;
    color: #475569;
    font-size: 14px;
    font-weight: 700;
}

.checkout-summary-value {
    color: #0f172a;
    font-weight: 900;
}

.checkout-summary-value.muted {
    color: #64748b;
}

.checkout-summary-divider {
    margin: 18px 0;
    border-color: rgba(15, 23, 42, 0.10);
}

.checkout-summary-row-total {
    align-items: center;
    margin-bottom: 20px;
    color: #0f172a;
    font-size: 16px;
    font-weight: 900;
}

.checkout-summary-value-strong {
    color: #dc2626;
    font-size: 20px;
    font-weight: 950;
    white-space: nowrap;
}

.checkout-summary-btn {
    width: 100%;
    min-height: 54px;
    border: 0;
    border-radius: 18px;
    color: #ffffff;
    font-size: 15px;
    font-weight: 900;
    background:
        radial-gradient(circle at 25% 20%, rgba(255,255,255,0.28), transparent 26%),
        linear-gradient(135deg, #ef4444, #b91c1c 48%, #7f1d1d);
    box-shadow: 0 18px 42px rgba(220, 38, 38, 0.28);
    transition: 0.25s ease;
}

.checkout-summary-btn:hover {
    color: #ffffff;
    transform: translateY(-2px);
    box-shadow: 0 25px 54px rgba(220, 38, 38, 0.34);
}

.checkout-summary-safe-text {
    color: #64748b;
    font-size: 12px;
    line-height: 1.5;
    font-weight: 700;
}

.checkout-summary-safe-text:first-of-type {
    margin-top: 18px;
}

.checkout-summary-safe-text i {
    color: #dc2626;
}

.checkout-summary-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-top: 14px;
}

.checkout-summary-tags span {
    display: inline-flex;
    align-items: center;
    padding: 8px 10px;
    border-radius: 999px;
    color: #334155;
    font-size: 11px;
    font-weight: 900;
    background: #f8fafc;
    border: 1px solid rgba(15, 23, 42, 0.08);
}

/* Responsive */

@media (max-width: 991px) {
    #checkout-hero {
        padding: 62px 0 46px;
    }

    .section-padding {
        padding: 56px 0;
    }

    .checkout-summary-card {
        position: relative;
        top: auto;
    }
}

@media (max-width: 767px) {
    .checkout-hero-title {
        font-size: 36px;
        letter-spacing: -0.04em;
    }

    .checkout-hero-subtitle {
        font-size: 15px;
    }

    .checkout-hero-panel,
    .checkout-form-card {
        padding: 22px;
        border-radius: 24px;
    }

    .checkout-form-header {
        align-items: flex-start !important;
        flex-direction: column;
    }

    .checkout-summary-product {
        grid-template-columns: 52px minmax(0, 1fr);
    }

    .checkout-summary-product-price {
        grid-column: 2;
        justify-self: start;
    }
}

@media (max-width: 575px) {
    #checkout-hero {
        padding: 44px 0 36px;
    }

    .section-padding {
        padding: 42px 0;
    }

    .checkout-hero-title {
        font-size: 31px;
    }

    .checkout-hero-stat,
    .checkout-hero-meta-strip span {
        font-size: 12px;
    }

    .checkout-form-card {
        padding: 18px;
    }

    .checkout-form-title,
    .checkout-summary-title {
        font-size: 21px;
    }

    .checkout-input {
        min-height: 52px;
        font-size: 13px;
    }

    .checkout-summary-header,
    .checkout-summary-body {
        padding-left: 18px;
        padding-right: 18px;
    }

    .checkout-summary-value-strong {
        font-size: 17px;
    }
}
</style>

<main>

  <!-- =================== CHECKOUT HERO =================== -->
  <section id="checkout-hero">
    <div class="container">
      <div class="row align-items-center g-3 checkout-hero-row">

        <div class="col-lg-7">
          <div class="checkout-hero-eyebrow-row d-flex flex-wrap align-items-center gap-2 mb-2">
            <span class="checkout-hero-eyebrow">
              <i class="bi bi-shield-lock me-1"></i>
              Secure checkout
            </span>
            <span class="checkout-hero-badge">
              <i class="bi bi-cart-check me-1"></i>
              Review &amp; place order
            </span>
          </div>

          <h1 class="checkout-hero-title">
            Complete your order for
            <span>fire safety products.</span>
          </h1>

          <p class="checkout-hero-subtitle mb-2">
            Fill your billing and delivery details. Our team will verify your order and assist
            with dispatch, installation and AMC requirements.
          </p>

          <div class="checkout-hero-stats d-flex flex-wrap gap-2">
            <span class="checkout-hero-stat">
              <i class="bi bi-box-seam me-1"></i>
              <strong>{{ collect($cart)->sum('quantity') }} items</strong> selected
            </span>
            <span class="checkout-hero-stat">
              <i class="bi bi-cash-coin me-1"></i>
              <strong>Payable:</strong> {{ checkoutPrice($total) }}
            </span>
          </div>

          <div class="checkout-hero-meta-strip">
            <span>
              <i class="bi bi-info-circle me-1"></i>
              GST, shipping and payment status can be updated after order confirmation.
            </span>
          </div>
        </div>

        <div class="col-lg-5">
          <div class="checkout-hero-panel">
            <div class="checkout-hero-panel-header d-flex justify-content-between align-items-center">
              <div>
                <div class="checkout-hero-panel-label">Amtex Safety Systems</div>
                <div class="checkout-hero-panel-title">Official product support</div>
              </div>
              <span class="checkout-hero-panel-chip">
                <i class="bi bi-patch-check-fill me-1"></i>
                Verified order
              </span>
            </div>

            <ul class="checkout-hero-panel-list">
              <li>
                <i class="bi bi-shield-check"></i>
                <span>Genuine fire safety products with proper invoice support.</span>
              </li>
              <li>
                <i class="bi bi-truck"></i>
                <span>Dispatch coordination based on your address and quantity.</span>
              </li>
              <li>
                <i class="bi bi-headset"></i>
                <span>Support team assistance for bulk and project orders.</span>
              </li>
            </ul>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- =================== CHECKOUT CONTENT =================== -->
  <section id="checkout-main" class="section-padding">
    <div class="container">

      @if(session('message'))
        <div class="alert alert-info mb-4">
          {{ session('message') }}
        </div>
      @endif

      @if($errors->has('order'))
        <div class="alert alert-danger mb-4">
          {{ $errors->first('order') }}
        </div>
      @endif

      <form method="POST" action="{{ route('checkout.placeOrder') }}">
        @csrf

        <div class="row g-4">

          <!-- Left: Billing Form -->
          <div class="col-lg-8">
            <div class="checkout-form-card">

              <div class="checkout-form-header d-flex justify-content-between align-items-center">
                <div>
                  <div class="checkout-form-title">Billing &amp; delivery details</div>
                  <div class="checkout-form-subtitle">Please enter correct details for invoice and dispatch.</div>
                </div>
                <span class="checkout-form-chip">
                  <i class="bi bi-lock-fill me-1"></i>
                  Protected
                </span>
              </div>

              <div class="row g-3">

                <div class="col-md-6">
                  <div class="checkout-field-group">
                    <label class="checkout-field-label" for="name">Full Name</label>
                    <div class="checkout-input-wrap">
                      <i class="bi bi-person checkout-input-icon"></i>
                      <input
                        id="name"
                        name="name"
                        type="text"
                        class="form-control checkout-input{{ $errors->has('name') ? ' is-invalid' : '' }}"
                        placeholder="Enter full name"
                        value="{{ old('name', $authUser->name ?? '') }}"
                        required
                      />
                    </div>
                    @if($errors->has('name'))
                      <div class="invalid-feedback d-block">{{ $errors->first('name') }}</div>
                    @endif
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="checkout-field-group">
                    <label class="checkout-field-label" for="phone">Mobile Number</label>
                    <div class="checkout-input-wrap">
                      <i class="bi bi-phone checkout-input-icon"></i>
                      <input
                        id="phone"
                        name="phone"
                        type="text"
                        class="form-control checkout-input{{ $errors->has('phone') ? ' is-invalid' : '' }}"
                        placeholder="10-digit mobile number"
                        value="{{ old('phone', $authUser->phone ?? $authUser->mobile ?? '') }}"
                        required
                      />
                    </div>
                    @if($errors->has('phone'))
                      <div class="invalid-feedback d-block">{{ $errors->first('phone') }}</div>
                    @endif
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="checkout-field-group">
                    <label class="checkout-field-label" for="email">Email Address</label>
                    <div class="checkout-input-wrap">
                      <i class="bi bi-envelope checkout-input-icon"></i>
                      <input
                        id="email"
                        name="email"
                        type="email"
                        class="form-control checkout-input{{ $errors->has('email') ? ' is-invalid' : '' }}"
                        placeholder="name@example.com"
                        value="{{ old('email', $authUser->email ?? '') }}"
                        required
                      />
                    </div>
                    @if($errors->has('email'))
                      <div class="invalid-feedback d-block">{{ $errors->first('email') }}</div>
                    @endif
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="checkout-field-group">
                    <label class="checkout-field-label" for="company">Company / Organisation</label>
                    <div class="checkout-input-wrap">
                      <i class="bi bi-building checkout-input-icon"></i>
                      <input
                        id="company"
                        name="company"
                        type="text"
                        class="form-control checkout-input"
                        placeholder="Company name optional"
                        value="{{ old('company') }}"
                      />
                    </div>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="checkout-field-group">
                    <label class="checkout-field-label" for="gst_no">GST Number</label>
                    <div class="checkout-input-wrap">
                      <i class="bi bi-receipt checkout-input-icon"></i>
                      <input
                        id="gst_no"
                        name="gst_no"
                        type="text"
                        class="form-control checkout-input"
                        placeholder="GST number optional"
                        value="{{ old('gst_no') }}"
                      />
                    </div>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="checkout-field-group">
                    <label class="checkout-field-label" for="payment_gateway">Payment Method</label>
                    <div class="checkout-input-wrap checkout-input-wrap-select">
                      <i class="bi bi-credit-card checkout-input-icon"></i>
                      <select
                        id="payment_gateway"
                        name="payment_gateway"
                        class="form-select checkout-input checkout-input-select{{ $errors->has('payment_gateway') ? ' is-invalid' : '' }}"
                        required
                      >
                        <option value="">Choose payment method</option>
                        <option value="cod" {{ old('payment_gateway') == 'cod' ? 'selected' : '' }}>Cash on Delivery / Pay Later</option>
                        <option value="upi" {{ old('payment_gateway') == 'upi' ? 'selected' : '' }}>UPI</option>
                        <option value="bank_transfer" {{ old('payment_gateway') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                      </select>
                    </div>
                    @if($errors->has('payment_gateway'))
                      <div class="invalid-feedback d-block">{{ $errors->first('payment_gateway') }}</div>
                    @endif
                  </div>
                </div>

                <div class="col-12">
                  <div class="checkout-field-group">
                    <label class="checkout-field-label" for="address">Full Address</label>
                    <div class="checkout-input-wrap checkout-textarea-wrap">
                      <i class="bi bi-geo-alt checkout-input-icon"></i>
                      <textarea
                        id="address"
                        name="address"
                        class="form-control checkout-input checkout-textarea{{ $errors->has('address') ? ' is-invalid' : '' }}"
                        placeholder="House no, street, area, landmark"
                        required
                      >{{ old('address') }}</textarea>
                    </div>
                    @if($errors->has('address'))
                      <div class="invalid-feedback d-block">{{ $errors->first('address') }}</div>
                    @endif
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="checkout-field-group">
                    <label class="checkout-field-label" for="city">City</label>
                    <div class="checkout-input-wrap">
                      <i class="bi bi-buildings checkout-input-icon"></i>
                      <input
                        id="city"
                        name="city"
                        type="text"
                        class="form-control checkout-input{{ $errors->has('city') ? ' is-invalid' : '' }}"
                        placeholder="City"
                        value="{{ old('city') }}"
                        required
                      />
                    </div>
                    @if($errors->has('city'))
                      <div class="invalid-feedback d-block">{{ $errors->first('city') }}</div>
                    @endif
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="checkout-field-group">
                    <label class="checkout-field-label" for="state">State</label>
                    <div class="checkout-input-wrap">
                      <i class="bi bi-map checkout-input-icon"></i>
                      <input
                        id="state"
                        name="state"
                        type="text"
                        class="form-control checkout-input{{ $errors->has('state') ? ' is-invalid' : '' }}"
                        placeholder="State"
                        value="{{ old('state') }}"
                        required
                      />
                    </div>
                    @if($errors->has('state'))
                      <div class="invalid-feedback d-block">{{ $errors->first('state') }}</div>
                    @endif
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="checkout-field-group">
                    <label class="checkout-field-label" for="pincode">Pincode</label>
                    <div class="checkout-input-wrap">
                      <i class="bi bi-pin-map checkout-input-icon"></i>
                      <input
                        id="pincode"
                        name="pincode"
                        type="text"
                        class="form-control checkout-input{{ $errors->has('pincode') ? ' is-invalid' : '' }}"
                        placeholder="Pincode"
                        value="{{ old('pincode') }}"
                        required
                      />
                    </div>
                    @if($errors->has('pincode'))
                      <div class="invalid-feedback d-block">{{ $errors->first('pincode') }}</div>
                    @endif
                  </div>
                </div>

                <div class="col-12">
                  <div class="checkout-field-group">
                    <label class="checkout-field-label" for="notes">Order Notes</label>
                    <div class="checkout-input-wrap checkout-textarea-wrap">
                      <i class="bi bi-chat-left-text checkout-input-icon"></i>
                      <textarea
                        id="notes"
                        name="notes"
                        class="form-control checkout-input checkout-textarea"
                        placeholder="Any installation, billing or delivery instruction optional"
                      >{{ old('notes') }}</textarea>
                    </div>
                  </div>
                </div>

              </div>

            </div>
          </div>

          <!-- Right: Order Summary -->
          <div class="col-lg-4">
            <aside class="checkout-summary-card">

              <div class="checkout-summary-header">
                <div class="checkout-summary-title">Order summary</div>
                <div class="checkout-summary-subtitle">Please review before placing order.</div>
              </div>

              <div class="checkout-summary-products">

                @foreach($cart as $cartKey => $item)
                  @php
                      $qty = (int) ($item['quantity'] ?? 1);
                      $price = (float) ($item['price'] ?? 0);
                      $lineTotal = $qty * $price;
                  @endphp

                  <div class="checkout-summary-product">
                    <div class="checkout-summary-product-img">
                      <img src="{{ $item['image'] ?? asset('assets/img/product/product-1.png') }}" alt="{{ $item['name'] ?? 'Product' }}">
                    </div>

                    <div class="checkout-summary-product-info">
                      <div class="checkout-summary-product-name">
                        {{ $item['name'] ?? 'Product' }}
                      </div>

                      @if(!empty($item['variant_text']))
                        <div class="checkout-summary-product-meta">
                          {{ $item['variant_text'] }}
                        </div>
                      @endif

                      <div class="checkout-summary-product-meta">
                        Qty: {{ $qty }} × {{ checkoutPrice($price) }}
                      </div>
                    </div>

                    <div class="checkout-summary-product-price">
                      {{ checkoutPrice($lineTotal) }}
                    </div>
                  </div>
                @endforeach

              </div>

              <div class="checkout-summary-body">
                <div class="checkout-summary-row">
                  <span>Merchandise total</span>
                  <span class="checkout-summary-value">{{ checkoutPrice($subtotal) }}</span>
                </div>

                <div class="checkout-summary-row">
                  <span>Estimated GST</span>
                  <span class="checkout-summary-value muted">
                    {{ $tax > 0 ? checkoutPrice($tax) : 'To be added' }}
                  </span>
                </div>

                <div class="checkout-summary-row">
                  <span>Shipping</span>
                  <span class="checkout-summary-value muted">
                    {{ $shipping > 0 ? checkoutPrice($shipping) : 'Based on pincode' }}
                  </span>
                </div>

                <hr class="checkout-summary-divider" />

                <div class="checkout-summary-row checkout-summary-row-total">
                  <span>Payable estimate</span>
                  <span class="checkout-summary-value-strong">
                    {{ checkoutPrice($total) }}{{ $tax <= 0 ? ' + GST' : '' }}
                  </span>
                </div>

                <button type="submit" class="btn checkout-summary-btn">
                  <i class="bi bi-lock-fill me-1"></i>
                  Place order securely
                </button>

                <p class="checkout-summary-safe-text mb-1">
                  <i class="bi bi-shield-lock me-1"></i>
                  Your details are securely processed.
                </p>

                <p class="checkout-summary-safe-text mb-2">
                  <i class="bi bi-receipt me-1"></i>
                  Invoice and order status will be generated after confirmation.
                </p>

                <div class="checkout-summary-tags">
                  <span><i class="bi bi-shield-check me-1"></i>Genuine products</span>
                  <span><i class="bi bi-headset me-1"></i>Order support</span>
                </div>
              </div>

            </aside>
          </div>

        </div>
      </form>

    </div>
  </section>

</main>

@endsection