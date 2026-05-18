@extends('web_master')
@section('main')

@php
  $formatMoney = function ($amount) {
      return '&#8377;' . number_format((float) $amount);
  };

  $statusClass = function ($status) {
      return match ($status) {
          'shipped' => 'udb-status-ship',
          'delivered' => 'udb-status-ok',
          default => 'udb-status-hold',
      };
  };
@endphp

<!-- =================== MAIN =================== -->
<main id="udb-main">

  <!-- =================== DASHBOARD HERO STRIP =================== -->
  <section id="udb-hero" class="section-padding">
    <div class="container">
      <div class="udb-hero-card">
        <div class="row g-3 align-items-center">

          <div class="col-lg-8">
            <div class="udb-hero-top d-flex flex-wrap align-items-center gap-2 mb-2">
              <span class="udb-hero-pill">
                <i class="bi bi-person-check me-1"></i> My Account
              </span>
              <span class="udb-hero-pill udb-hero-pill-dark">
                <i class="bi bi-shield-check me-1"></i> ISO &amp; ISI trusted products
              </span>
            </div>

            <h1 class="udb-hero-title mb-1">
              Welcome back, <span>{{ $user->name }}</span>
            </h1>
            <p class="udb-hero-subtitle mb-0">
              Track orders, manage addresses, request AMC service and keep your premises fire-safe - all in one place.
            </p>
          </div>

          <div class="col-lg-4">
            <div class="udb-hero-actions">
              <a href="{{ route('frontend.products.index') }}" class="btn btn-amtex udb-hero-btn">
                <i class="bi bi-bag-check me-1"></i> Shop Products
              </a>
              <a href="{{ route('frontend.amc') }}" class="btn btn-outline-dark udb-hero-btn-outline">
                <i class="bi bi-tools me-1"></i> Request AMC
              </a>
            </div>
          </div>

        </div>
      </div>
    </div>
  </section>

  <!-- =================== DASHBOARD GRID =================== -->
  <section id="udb-content" class="udb-section-pad-bottom">
    <div class="container">
      <div class="row g-3 g-lg-4">

        <!-- LEFT: PROFILE + MENU -->
        <div class="col-lg-4">

          <!-- Profile card -->
          <div class="udb-card udb-profile">
            <div class="udb-profile-top">
              <div class="udb-avatar">
                <i class="bi bi-person"></i>
              </div>
              <div>
                <div class="udb-name">{{ $user->name }}</div>
                <div class="udb-meta">
                  <span><i class="bi bi-telephone me-1"></i> {{ $endUser->phone ?: 'Phone not added' }}</span>
                  <span class="dot"></span>
                  <span><i class="bi bi-envelope me-1"></i> {{ $user->email }}</span>
                </div>
              </div>
            </div>

            <div class="udb-profile-strip">
              <div class="udb-strip-item">
                <div class="udb-strip-number">{{ str_pad($activeOrders, 2, '0', STR_PAD_LEFT) }}</div>
                <div class="udb-strip-label">Active Orders</div>
              </div>
              <div class="udb-strip-item">
                <div class="udb-strip-number">00</div>
                <div class="udb-strip-label">AMC Requests</div>
              </div>
              <div class="udb-strip-item">
                <div class="udb-strip-number">{!! $formatMoney($totalSpend) !!}</div>
                <div class="udb-strip-label">Total Spend*</div>
              </div>
            </div>

            <div class="udb-quick-actions">
              <a class="udb-action" href="{{ route('profile.password.edit') }}">
                <div class="udb-action-ic"><i class="bi bi-person-gear"></i></div>
                <div>
                  <div class="udb-action-title">Profile Settings</div>
                  <div class="udb-action-text">Update name, email &amp; phone</div>
                </div>
                <i class="bi bi-arrow-right-short udb-action-arrow"></i>
              </a>

              <a class="udb-action" href="#saved-addresses">
                <div class="udb-action-ic"><i class="bi bi-geo-alt"></i></div>
                <div>
                  <div class="udb-action-title">Manage Addresses</div>
                  <div class="udb-action-text">Billing &amp; delivery locations</div>
                </div>
                <i class="bi bi-arrow-right-short udb-action-arrow"></i>
              </a>

              <a class="udb-action" href="{{ route('frontend.amc') }}">
                <div class="udb-action-ic"><i class="bi bi-tools"></i></div>
                <div>
                  <div class="udb-action-title">Support &amp; AMC</div>
                  <div class="udb-action-text">Refilling, audits &amp; maintenance</div>
                </div>
                <i class="bi bi-arrow-right-short udb-action-arrow"></i>
              </a>

              <a class="udb-action udb-action-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('frontend-logoutform').submit();">
                <div class="udb-action-ic"><i class="bi bi-box-arrow-right"></i></div>
                <div>
                  <div class="udb-action-title">Logout</div>
                  <div class="udb-action-text">Sign out from this device</div>
                </div>
                <i class="bi bi-arrow-right-short udb-action-arrow"></i>
              </a>
              <form id="frontend-logoutform" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
              </form>
            </div>

            <div class="udb-mini-note">
              <i class="bi bi-lock-fill me-1"></i>
              Your account data is protected.
            </div>
          </div>

          <!-- Support card -->
          <div class="udb-card udb-support mt-3">
            <div class="udb-support-head">
              <span class="udb-support-pill">
                <i class="bi bi-headset me-1"></i> Priority Help
              </span>
              <span class="udb-support-badge">
                <i class="bi bi-lightning-charge-fill me-1"></i> Fast response
              </span>
            </div>

            <div class="udb-support-title">Need expert guidance?</div>
            <div class="udb-support-text">
              Talk to our fire safety team for product selection, installation guidance and compliance help.
            </div>

            <div class="udb-support-links">
              <a href="tel:+919973113905" class="udb-support-link">
                <i class="bi bi-telephone-fill"></i> Call Now
              </a>
              <a href="mailto:info@amtexsafety.com" class="udb-support-link">
                <i class="bi bi-envelope-fill"></i> Email
              </a>
            </div>
          </div>

        </div>

        <!-- RIGHT: STATS + TABLES -->
        <div class="col-lg-8">

          <!-- Stats row -->
          <div class="row g-3">
            <div class="col-md-4">
              <div class="udb-stat udb-card">
                <div class="udb-stat-top">
                  <span class="udb-stat-ic"><i class="bi bi-bag-check"></i></span>
                  <span class="udb-stat-tag">Orders</span>
                </div>
                <div class="udb-stat-number">{{ str_pad($totalOrders, 2, '0', STR_PAD_LEFT) }}</div>
                <div class="udb-stat-label">Total orders placed</div>
              </div>
            </div>

            <div class="col-md-4">
              <div class="udb-stat udb-card">
                <div class="udb-stat-top">
                  <span class="udb-stat-ic"><i class="bi bi-truck"></i></span>
                  <span class="udb-stat-tag">In Transit</span>
                </div>
                <div class="udb-stat-number">{{ str_pad($inTransitOrders, 2, '0', STR_PAD_LEFT) }}</div>
                <div class="udb-stat-label">Currently shipping</div>
              </div>
            </div>

            <div class="col-md-4">
              <div class="udb-stat udb-card">
                <div class="udb-stat-top">
                  <span class="udb-stat-ic"><i class="bi bi-shield-check"></i></span>
                  <span class="udb-stat-tag">Compliance</span>
                </div>
                <div class="udb-stat-number">Ready</div>
                <div class="udb-stat-label">Support for audits &amp; AMC</div>
              </div>
            </div>
          </div>

          <!-- Recent Orders -->
          <div class="udb-card mt-3">
            <div class="udb-card-head">
              <div>
                <div class="udb-card-title">Recent Orders</div>
                <div class="udb-card-subtitle">Track delivery &amp; download invoices</div>
              </div>
              <a href="{{ route('frontend.products.index') }}" class="udb-card-link">
                View all <i class="bi bi-arrow-right-short"></i>
              </a>
            </div>

            <div class="table-responsive udb-table-wrap">
              <table class="table udb-table align-middle mb-0">
                <thead>
                  <tr>
                    <th>Order</th>
                    <th>Product</th>
                    <th>Status</th>
                    <th class="text-end">Amount</th>
                    <th class="text-end">Action</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($recentOrders as $order)
                    @php
                      $firstItem = $order->items->first();
                      $meta = $firstItem && $firstItem->meta_snapshot ? json_decode($firstItem->meta_snapshot, true) : [];
                      $productName = $firstItem?->product?->name ?? ($meta['name'] ?? 'Order item');
                      $qty = $firstItem?->qty ?? 1;
                      $status = $order->status ?? 'processing';
                    @endphp
                    <tr>
                      <td>
                        <div class="udb-order-id">#{{ $order->order_no }}</div>
                        <div class="udb-order-date">{{ optional($order->created_at)->format('M d, Y') }}</div>
                      </td>
                      <td>
                        <div class="udb-prod">{{ $productName }}</div>
                        <div class="udb-prod-meta">Qty: {{ $qty }} - {{ $order->items->count() }} item(s)</div>
                      </td>
                      <td><span class="udb-status {{ $statusClass($status) }}"><i class="bi bi-truck me-1"></i> {{ ucfirst($status) }}</span></td>
                      <td class="text-end fw-bold">{!! $formatMoney($order->total) !!}</td>
                      <td class="text-end">
                        <a href="{{ route('frontend.products.index') }}" class="btn btn-sm btn-outline-dark udb-mini-btn">Shop</a>
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="5" class="text-center py-4">
                        <div class="udb-prod">No orders found</div>
                        <div class="udb-prod-meta">Your future orders will appear here.</div>
                      </td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>

            <div class="udb-table-note">
              <i class="bi bi-info-circle me-1"></i>
              For bulk/project orders, our team may share a separate BOQ &amp; invoice.
            </div>
          </div>

          <!-- Addresses + Wishlist -->
          <div class="row g-3 mt-1">
            <div class="col-md-6">
              <div class="udb-card h-100" id="saved-addresses">
                <div class="udb-card-head">
                  <div>
                    <div class="udb-card-title">Saved Addresses</div>
                    <div class="udb-card-subtitle">Fast checkout &amp; delivery</div>
                  </div>
                  <a href="#saved-addresses" class="udb-card-link">
                    Manage <i class="bi bi-arrow-right-short"></i>
                  </a>
                </div>

                @forelse($addresses as $address)
                  <div class="udb-address">
                    <div class="udb-address-badge"><i class="bi {{ strtolower($address->label) === 'office' ? 'bi-building' : 'bi-house-door' }}"></i></div>
                    <div class="udb-address-body">
                      <div class="udb-address-title">{{ $address->label ?: 'Address' }}</div>
                      <div class="udb-address-text">{{ collect([$address->line_1, $address->line_2, $address->city, $address->state, $address->pincode])->filter()->implode(', ') }}</div>
                    </div>
                  </div>
                @empty
                  <div class="udb-address">
                    <div class="udb-address-badge"><i class="bi bi-geo-alt"></i></div>
                    <div class="udb-address-body">
                      <div class="udb-address-title">No saved address</div>
                      <div class="udb-address-text">Use checkout once and your delivery details can be saved here.</div>
                    </div>
                  </div>
                @endforelse

                <a href="{{ route('cart.index') }}" class="btn btn-outline-dark w-100 udb-soft-btn">
                  <i class="bi bi-plus-circle me-1"></i> Add new address
                </a>
              </div>
            </div>

            <div class="col-md-6">
              <div class="udb-card h-100">
                <div class="udb-card-head">
                  <div>
                    <div class="udb-card-title">Wishlist Preview</div>
                    <div class="udb-card-subtitle">Saved items for later</div>
                  </div>
                  <a href="{{ route('frontend.products.index') }}" class="udb-card-link">
                    Explore <i class="bi bi-arrow-right-short"></i>
                  </a>
                </div>

                @forelse($wishlists as $wishlist)
                  @php
                    $product = $wishlist->product;
                    $image = $product?->main_image?->url ?? asset('frontend/assets/img/product/product-1.png');
                  @endphp
                  <div class="udb-wish">
                    <div class="udb-wish-img">
                      <img src="{{ $image }}" alt="{{ $product->name ?? 'Saved product' }}" />
                    </div>
                    <div class="udb-wish-body">
                      <div class="udb-wish-title">{{ $product->name ?? 'Saved product' }}</div>
                      <div class="udb-wish-text">{{ $product->short_desc ?? 'Saved for later' }}</div>
                    </div>
                    <a href="{{ $product ? route('frontend.products.show', $product->slug) : route('frontend.products.index') }}" class="btn btn-sm btn-outline-dark udb-mini-btn">View</a>
                  </div>
                @empty
                  <div class="udb-wish">
                    <div class="udb-wish-img">
                      <img src="{{ asset('frontend/assets/img/product/product-1.png') }}" alt="Products" />
                    </div>
                    <div class="udb-wish-body">
                      <div class="udb-wish-title">No wishlist items</div>
                      <div class="udb-wish-text">Explore products and save items for later.</div>
                    </div>
                    <a href="{{ route('frontend.products.index') }}" class="btn btn-sm btn-outline-dark udb-mini-btn">View</a>
                  </div>
                @endforelse

                <a href="{{ route('frontend.products.index') }}" class="btn btn-amtex w-100 udb-soft-btn udb-soft-btn-primary">
                  <i class="bi bi-bag-check me-1"></i> Add items to cart
                </a>
              </div>
            </div>
          </div>

        </div>

      </div>
    </div>
  </section>

</main>
@endsection
