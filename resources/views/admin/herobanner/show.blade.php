@extends('layouts.admin')
@section('content')

<div class="card hero-show-card">

    {{-- Header --}}
    <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
        <div>
            <strong>View Home Hero Slide</strong>
            <div class="text-muted small mt-1">
                Preview slide content, images and configuration.
            </div>
        </div>

        <div class="d-flex gap-2">
            @can('home_hero_edit')
                <a href="{{ route('admin.home-heroes.edit', $hero->id) }}" class="btn btn-outline-primary">
                    Edit
                </a>
            @endcan

            <a href="{{ route('admin.home-heroes.index') }}" class="btn btn-light">
                Back to list
            </a>
        </div>
    </div>

    <div class="card-body">

        <div class="row g-3">

            {{-- LEFT: Text Content --}}
            <div class="col-lg-8">

                <div class="card inner-card mb-3">
                    <div class="card-header">
                        <strong>Slide Content</strong>
                    </div>
                    <div class="card-body">

                        <div class="row g-3">

                            <div class="col-md-6">
                                <div class="show-field">
                                    <div class="show-label">Badge Text</div>
                                    <div class="show-value">{{ $hero->badge_text ?? '-' }}</div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="show-field">
                                    <div class="show-label">Badge Icon</div>
                                    <div class="show-value">{{ $hero->badge_icon ?? '-' }}</div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="show-field">
                                    <div class="show-label">Title Line 1</div>
                                    <div class="show-value">{{ $hero->title_line_1 ?? '-' }}</div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="show-field">
                                    <div class="show-label">Title Highlight</div>
                                    <div class="show-value">{{ $hero->title_highlight ?? '-' }}</div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="show-field">
                                    <div class="show-label">Subtitle</div>
                                    <div class="show-value">
                                        {{ $hero->subtitle ?? '-' }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="show-field">
                                    <div class="show-label">Meta Text</div>
                                    <div class="show-value">{{ $hero->meta_text ?? '-' }}</div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="show-field">
                                    <div class="show-label">CTA Text</div>
                                    <div class="show-value">{{ $hero->cta_text ?? '-' }}</div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="show-field">
                                    <div class="show-label">CTA URL</div>
                                    <div class="show-value">{{ $hero->cta_url ?? '-' }}</div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>

            </div>

            {{-- RIGHT: Images & Settings --}}
            <div class="col-lg-4">

                <div class="card inner-card mb-3">
                    <div class="card-header">
                        <strong>Images</strong>
                    </div>
                    <div class="card-body">

                        {{-- Desktop Image --}}
                        <div class="mb-3">
                            <div class="show-label">Desktop Image</div>
                            @if($hero->desktop_image)
                                <img
                                    src="{{ asset('storage/'.$hero->desktop_image) }}"
                                    class="img-fluid rounded border"
                                    style="width:100%; height:150px; object-fit:cover;"
                                    alt="Desktop Hero Image"
                                >
                            @else
                                <div class="text-muted">Not uploaded</div>
                            @endif
                        </div>

                        {{-- Mobile Image --}}
                        <div>
                            <div class="show-label">Mobile Image</div>
                            @if($hero->mobile_image)
                                <img
                                    src="{{ asset('storage/'.$hero->mobile_image) }}"
                                    class="img-fluid rounded border"
                                    style="width:100%; height:200px; object-fit:cover;"
                                    alt="Mobile Hero Image"
                                >
                            @else
                                <div class="text-muted">Not uploaded</div>
                            @endif
                        </div>

                    </div>
                </div>

                <div class="card inner-card">
                    <div class="card-header">
                        <strong>Settings</strong>
                    </div>
                    <div class="card-body">

                        <div class="show-field">
                            <div class="show-label">Sort Order</div>
                            <div class="show-value">{{ $hero->sort_order ?? 0 }}</div>
                        </div>

                        <div class="show-field mt-2">
                            <div class="show-label">Status</div>
                            @if($hero->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </div>

                        <hr>

                        <div class="show-field">
                            <div class="show-label">Created At</div>
                            <div class="show-value">
                                {{ optional($hero->created_at)->format('d M Y, h:i A') }}
                            </div>
                        </div>

                        <div class="show-field mt-1">
                            <div class="show-label">Last Updated</div>
                            <div class="show-value">
                                {{ optional($hero->updated_at)->format('d M Y, h:i A') }}
                            </div>
                        </div>

                        <div class="show-field mt-1">
                            <div class="show-label">Slide ID</div>
                            <div class="show-value">#{{ $hero->id }}</div>
                        </div>

                    </div>
                </div>

            </div>

        </div>

    </div>
</div>

@endsection

@section('styles')
@parent
<style>
.hero-show-card .inner-card {
    border: 1px solid rgba(0,0,0,.08);
}
.show-label {
    font-size: 12px;
    text-transform: uppercase;
    color: #777;
    margin-bottom: 4px;
    font-weight: 600;
}
.show-value {
    font-size: 14px;
    color: #222;
}
</style>
@endsection
