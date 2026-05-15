@extends('web_master')
@section('main')

@php
    $cart = $cart ?? session('cart', []);

    $subtotal = collect($cart)->sum(function ($item) {
        return (float) ($item['price'] ?? 0) * (int) ($item['quantity'] ?? 1);
    });

    $totalItems = collect($cart)->sum(function ($item) {
        return (int) ($item['quantity'] ?? 1);
    });

    function cartPrice($amount) {
        return '₹' . number_format((float) $amount);
    }
@endphp

<main>

  <!-- =================== CART HERO =================== -->
  <section id="cart-hero">
    <div class="container">
      <div class="row align-items-center g-3 cart-hero-row">

        <div class="col-lg-7">
          <div class="cart-hero-eyebrow-row d-flex flex-wrap align-items-center gap-2 mb-2">
            <span class="cart-hero-eyebrow">
              <i class="bi bi-cart-check me-1"></i>
              Your cart
            </span>
            <span class="cart-hero-badge">
              <i class="bi bi-shield-lock me-1"></i>
              100% secure checkout
            </span>
          </div>

          <h1 class="cart-hero-title">
            Mist extinguishers and safety products
            <span>ready for your premises.</span>
          </h1>

          <p class="cart-hero-subtitle mb-2">
            Review your selection, adjust quantities and proceed to secure payment. Our team can
            help with placement and installation after your order.
          </p>

          <div class="cart-hero-stats d-flex flex-wrap gap-2">
            <span class="cart-hero-stat">
              <i class="bi bi-box-seam me-1"></i>
              <strong>{{ $totalItems }} {{ $totalItems == 1 ? 'item' : 'items' }}</strong> in your cart
            </span>
            <span class="cart-hero-stat">
              <i class="bi bi-cash-coin me-1"></i>
              <strong>Est. total:</strong> {{ cartPrice($subtotal) }}
            </span>
          </div>

          <div class="cart-hero-meta-strip">
            <span>
              <i class="bi bi-info-circle me-1"></i>
              GST &amp; shipping shown on the next step based on your location.
            </span>
          </div>
        </div>

        <div class="col-lg-5">
          <div class="cart-hero-panel">
            <div class="cart-hero-panel-header d-flex justify-content-between align-items-center">
              <div>
                <div class="cart-hero-panel-label">Why buy directly from Amtex?</div>
                <div class="cart-hero-panel-title">Official product guarantee</div>
              </div>
              <span class="cart-hero-panel-chip">
                <i class="bi bi-patch-check-fill me-1"></i>
                Genuine units
              </span>
            </div>

            <ul class="cart-hero-panel-list">
              <li>
                <i class="bi bi-shield-check"></i>
                <span>ISI / ISO-compliant extinguishers with fresh manufacturing.</span>
              </li>
              <li>
                <i class="bi bi-tools"></i>
                <span>Option to add installation &amp; AMC after checkout.</span>
              </li>
              <li>
                <i class="bi bi-geo-alt"></i>
                <span>Pan-India dispatch through trusted logistics partners.</span>
              </li>
            </ul>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- =================== CART CONTENT =================== -->
  <section id="cart-main" class="section-padding">
    <div class="container">
      <div class="row g-4">

        <!-- Left: Cart items -->
        <div class="col-lg-8">
          <div class="cart-items-card">

            <div class="cart-items-header d-flex justify-content-between align-items-center">
              <div>
                <div class="cart-items-title">Items in your cart</div>
                <div class="cart-items-subtitle">Update quantities or remove items before checkout.</div>
              </div>

              @if(count($cart))
                <form method="POST" action="{{ route('cart.clear') }}">
                  @csrf
                  <button type="submit" class="cart-items-clear-btn">
                    <i class="bi bi-trash3 me-1"></i>
                    Clear cart
                  </button>
                </form>
              @endif
            </div>

            <div class="cart-items-list">

              @forelse($cart as $cartKey => $item)

                @php
                    $qty = (int) ($item['quantity'] ?? 1);
                    $price = (float) ($item['price'] ?? 0);
                    $oldPrice = $item['compare_price'] ?? null;
                    $lineTotal = $price * $qty;
                @endphp

                <article class="cart-item">
                  <div class="cart-item-main">
                    <div class="cart-item-image-wrap">
                      <img src="{{ $item['image'] ?? asset('assets/img/product/product-1.png') }}" alt="{{ $item['name'] ?? 'Product' }}" class="cart-item-image" />
                    </div>

                    <div class="cart-item-info">
                      <div class="cart-item-tag-row">
                        <span class="cart-item-tag">{{ $item['category'] ?? 'Safety Product' }}</span>
                        <span class="cart-item-label">{{ $item['variant_text'] ?? 'Genuine Amtex product' }}</span>
                      </div>
                      <h3 class="cart-item-name">{{ $item['name'] ?? 'Product' }}</h3>
                      <div class="cart-item-meta">
                        @if(!empty($item['variant_text']))
                          <span><i class="bi bi-bezier me-1"></i>{{ $item['variant_text'] }}</span>
                        @endif
                        <span><i class="bi bi-award me-1"></i>ISI Marked</span>
                        <span><i class="bi bi-fire me-1"></i>Class A / B</span>
                      </div>
                      <div class="cart-item-actions">
                        <form method="POST" action="{{ route('cart.remove') }}" class="d-inline">
                          @csrf
                          <input type="hidden" name="cart_key" value="{{ $cartKey }}">
                          <button type="submit" class="cart-item-remove">
                            <i class="bi bi-x-circle me-1"></i> Remove
                          </button>
                        </form>

                        <button type="button" class="cart-item-save">
                          <i class="bi bi-heart me-1"></i> Move to wishlist
                        </button>
                      </div>
                    </div>
                  </div>

                  <div class="cart-item-side">
                    <div class="cart-item-price-block">
                      <div class="cart-item-price">{{ cartPrice($price) }}</div>

                      @if(!empty($oldPrice) && (float) $oldPrice > $price)
                        <div class="cart-item-price-old">{{ cartPrice($oldPrice) }}</div>
                      @endif

                      <div class="cart-item-price-note">Incl. basic extinguisher unit</div>
                    </div>

                    <div class="cart-item-qty-block">
                      <div class="cart-qty-label">Quantity</div>

                      <form method="POST" action="{{ route('cart.update') }}">
                        @csrf
                        <input type="hidden" name="cart_key" value="{{ $cartKey }}">

                        <div class="cart-qty-control" data-price="{{ $price }}">
                          <button type="button" class="cart-qty-btn cart-qty-minus" aria-label="Decrease quantity">
                            <i class="bi bi-dash"></i>
                          </button>
                          <input
                            type="number"
                            name="quantity"
                            class="cart-qty-input"
                            value="{{ $qty }}"
                            min="1"
                          />
                          <button type="button" class="cart-qty-btn cart-qty-plus" aria-label="Increase quantity">
                            <i class="bi bi-plus"></i>
                          </button>
                        </div>

                        <button type="submit" class="cart-item-remove mt-2">
                          Update
                        </button>
                      </form>

                      <div class="cart-item-line-total">
                        <span>Line total</span>
                        <strong>{{ cartPrice($lineTotal) }}</strong>
                      </div>
                    </div>
                  </div>
                </article>

              @empty

                <article class="cart-item">
                  <div class="cart-item-main">
                    <div class="cart-item-info">
                      <h3 class="cart-item-name">Your cart is empty</h3>
                      <div class="cart-item-meta">
                        <span><i class="bi bi-cart-x me-1"></i>No products added yet.</span>
                      </div>
                    </div>
                  </div>
                </article>

              @endforelse

            </div>

            <div class="cart-items-footer d-flex flex-wrap justify-content-between align-items-center">
              <a href="{{ url('/products') }}" class="cart-continue-link">
                <i class="bi bi-arrow-left me-1"></i>
                Continue shopping
              </a>
              <div class="cart-items-note">
                <i class="bi bi-exclamation-circle me-1"></i>
                Installation, refilling and AMC can be added after your order is confirmed.
              </div>
            </div>

          </div>
        </div>

        <!-- Right: summary -->
        <div class="col-lg-4">
          <aside class="cart-summary-card">
            <div class="cart-summary-header">
              <div class="cart-summary-title">Order summary</div>
              <div class="cart-summary-subtitle">Taxes &amp; shipping calculated at checkout.</div>
            </div>

            <div class="cart-summary-body">
              <div class="cart-summary-row">
                <span>Merchandise total</span>
                <span class="cart-summary-value">{{ cartPrice($subtotal) }}</span>
              </div>
              <div class="cart-summary-row">
                <span>Estimated GST</span>
                <span class="cart-summary-value muted">To be added</span>
              </div>
              <div class="cart-summary-row">
                <span>Shipping</span>
                <span class="cart-summary-value muted">Based on pincode</span>
              </div>

              <hr class="cart-summary-divider" />

              <div class="cart-summary-row cart-summary-row-total">
                <span>Payable (estimate)</span>
                <span class="cart-summary-value-strong">{{ cartPrice($subtotal) }} + GST</span>
              </div>

              <a href="{{ url('/checkout') }}" class="btn cart-summary-btn">
                Proceed to secure checkout
              </a>

              <p class="cart-summary-safe-text mb-1">
                <i class="bi bi-lock-fill me-1"></i>
                Payments secured via trusted gateways.
              </p>
              <p class="cart-summary-safe-text mb-2">
                <i class="bi bi-credit-card me-1"></i>
                UPI, net banking, cards &amp; COD (where available).
              </p>

              <div class="cart-summary-tags">
                <span><i class="bi bi-shield-check me-1"></i>Amtex certified products</span>
                <span><i class="bi bi-geo-alt me-1"></i>Pan-India dispatch</span>
              </div>
            </div>
          </aside>

          <!-- reassurance strip -->
          <div class="cart-reassure">
            <div class="cart-reassure-item">
              <i class="bi bi-arrow-repeat"></i>
              Easy assistance for wrong orders
            </div>
            <div class="cart-reassure-item">
              <i class="bi bi-headset"></i>
              Pre- &amp; post-sales support
            </div>
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
  document.querySelectorAll('.cart-qty-control').forEach(function (control) {
    const minus = control.querySelector('.cart-qty-minus');
    const plus = control.querySelector('.cart-qty-plus');
    const input = control.querySelector('.cart-qty-input');

    if (!input) return;

    if (minus) {
      minus.addEventListener('click', function () {
        let qty = parseInt(input.value || '1', 10);
        qty = Math.max(1, qty - 1);
        input.value = qty;
      });
    }

    if (plus) {
      plus.addEventListener('click', function () {
        let qty = parseInt(input.value || '1', 10);
        input.value = qty + 1;
      });
    }
  });
});
</script>

@endsection