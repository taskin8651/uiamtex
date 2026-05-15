@extends('web_master')
@section('main')

<main>

    <!-- =================== Pages HERO =================== -->
    <section class="privacy-hero">
        <div class="container">
            <div class="privacy-breadcrumb">
                <a href="{{ url('/') }}">Home</a> <span>•</span> {{ $page->title }}
            </div>

            <h1 class="privacy-title">{{ $page->title }}</h1>

            @if(!empty($page->seo_description))
                <p class="privacy-intro">
                    {{ $page->seo_description }}
                </p>
            @endif
        </div>
    </section>

    <!-- =================== Pages CONTENT =================== -->
    <section class="privacy-content section-padding">
        <div class="container">
            <div class="privacy-card">

                {{-- If "content" is saved as HTML from admin, render it like this: --}}
                {!! $page->content !!}

                <div class="privacy-footer-note">
                    Last updated:
                    <strong>{{ optional($page->updated_at)->format('F Y') }}</strong>
                </div>

            </div>
        </div>
    </section>

</main>

@endsection
