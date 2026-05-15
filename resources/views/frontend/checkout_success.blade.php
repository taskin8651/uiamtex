@extends('layouts.app')

@section('content')

<main>
    <section class="section-padding">
        <div class="container">
            <div class="text-center" style="max-width: 650px; margin: 0 auto;">
                <div style="width: 82px; height: 82px; border-radius: 50%; margin: 0 auto 22px; display: flex; align-items: center; justify-content: center; background: #ecfdf5; color: #059669; font-size: 38px;">
                    <i class="bi bi-check2-circle"></i>
                </div>

                <h1 style="font-weight: 900; color: #0f172a;">Order placed successfully</h1>

                <p class="text-muted mt-2">
                    Your order number is <strong>{{ $order_no }}</strong>. Our team will contact you shortly for confirmation and dispatch details.
                </p>

                <div class="mt-4">
                    <a href="{{ url('/') }}" class="btn btn-amtex">
                        Back to Home
                    </a>
                </div>
            </div>
        </div>
    </section>
</main>

@endsection