@extends('layouts.admin')
@section('content')

@php
    // Safety fallback (prevents undefined variable crash)
    $heroes = $heroes ?? collect();
@endphp

<div class="amtex-page">

    {{-- Header --}}
    <div class="amtex-header">
        <div>
            <h2 class="amtex-title">Home Hero Banner</h2>
            <p class="amtex-subtitle">
                Manage homepage hero slides (order, visibility, content & images).
            </p>
        </div>

        <div class="amtex-actions">
            @if(session('message'))
                <div class="amtex-alert">{{ session('message') }}</div>
            @endif

            @can('home_hero_create')
                <a href="{{ route('admin.home-heroes.create') }}" class="btn amtex-btn">
                    <i class="fas fa-plus"></i> Add Hero
                </a>
            @endcan
        </div>
    </div>

    {{-- Empty State --}}
    @if($heroes->count() === 0)
        <div class="amtex-empty">
            <div class="amtex-empty-card">
                <div class="amtex-badge">No Slides</div>
                <h3>No hero banners added yet</h3>
                <p>
                    Create hero slides to display on the homepage carousel.
                    Each slide supports desktop & mobile images, CTA, and ordering.
                </p>

                @can('home_hero_create')
                    <a href="{{ route('admin.home-heroes.create') }}" class="btn amtex-btn mt-2">
                        Add First Hero
                    </a>
                @endcan
            </div>
        </div>
    @else

        {{-- Listing --}}
        <div class="row g-3">
            @foreach($heroes as $hero)
                <div class="col-lg-4 col-md-6">
                    <div class="amtex-card h-100">

                        {{-- Card Header --}}
                        <div class="amtex-card-head d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">
                                {{ $hero->title_line_1 ?? 'Hero Slide' }}
                                @if($hero->title_highlight)
                                    <span class="d-block small text-muted">
                                        {{ $hero->title_highlight }}
                                    </span>
                                @endif
                            </h4>

                            @if($hero->is_active)
                                <span class="amtex-chip">Active</span>
                            @else
                                <span class="amtex-chip amtex-chip-warn">Inactive</span>
                            @endif
                        </div>

                        {{-- Card Body --}}
                        <div class="amtex-card-body">

                            {{-- Desktop Image --}}
                            @if($hero->desktop_image)
                                <img
                                    src="{{ asset('storage/'.$hero->desktop_image) }}"
                                    class="img-fluid rounded mb-2"
                                    style="width:100%; height:160px; object-fit:cover;"
                                    alt="Hero Image"
                                >
                            @else
                                <div class="amtex-muted mb-2">No desktop image</div>
                            @endif

                            {{-- Meta --}}
                            <div class="small text-muted">
                                Sort Order: <strong>{{ $hero->sort_order ?? 0 }}</strong>
                            </div>

                            <div class="small text-muted mt-1">
                                CTA: <strong>{{ $hero->cta_text ?? '-' }}</strong>
                            </div>
                        </div>

                        {{-- Actions --}}
                        <div class="amtex-card-footer d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                Updated: {{ optional($hero->updated_at)->format('d M Y') }}
                            </small>

                            <div class="d-flex gap-1">

                                {{-- View --}}
                                @can('home_hero_show')
                                    <a
                                        href="{{ route('admin.home-heroes.show', $hero->id) }}"
                                        class="btn btn-sm btn-outline-secondary"
                                    >
                                        View
                                    </a>
                                @endcan

                                {{-- Edit --}}
                                @can('home_hero_edit')
                                    <a
                                        href="{{ route('admin.home-heroes.edit', $hero->id) }}"
                                        class="btn btn-sm btn-outline-primary"
                                    >
                                        Edit
                                    </a>
                                @endcan

                                {{-- Delete --}}
                                @can('home_hero_delete')
                                    <form
                                        action="{{ route('admin.home-heroes.destroy', $hero->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this slide?');"
                                    >
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger">
                                            Delete
                                        </button>
                                    </form>
                                @endcan

                            </div>
                        </div>

                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        @if(method_exists($heroes, 'links'))
            <div class="mt-4">
                {{ $heroes->links() }}
            </div>
        @endif

    @endif

</div>

@endsection
