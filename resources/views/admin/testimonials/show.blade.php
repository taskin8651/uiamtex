@extends('layouts.admin')
@section('content')

<div class="amtex-page">
    <div class="amtex-header">
        <div>
            <h2 class="amtex-title">Testimonial Details</h2>
            <p class="amtex-subtitle">View testimonial information.</p>
        </div>
        <div class="amtex-actions">
            <a href="{{ route('admin.testimonials.index') }}" class="btn amtex-btn-outline">
                <i class="fas fa-arrow-left"></i> Back
            </a>
            @can('testimonial_edit')
                <a href="{{ route('admin.testimonials.edit', $testimonial->id) }}" class="btn amtex-btn">
                    <i class="fas fa-edit"></i> Edit
                </a>
            @endcan
        </div>
    </div>

    <div class="amtex-card">
        <div class="amtex-card-body">
            <div class="row g-3">

                <div class="col-md-4">
                    <div class="amtex-card" style="border:1px solid rgba(0,0,0,.06);">
                        <div class="amtex-card-body text-center">
                            @if($testimonial->photo)
                                <img src="{{ $testimonial->photo->url }}" alt="{{ $testimonial->name }}"
                                     style="width:140px;height:140px;border-radius:999px;object-fit:cover;border:1px solid rgba(0,0,0,.08);">
                                <div class="mt-2">
                                    <a href="{{ $testimonial->photo->url }}" target="_blank" class="btn btn-sm btn-outline-secondary">
                                        View Photo
                                    </a>
                                </div>
                            @else
                                <div style="width:140px;height:140px;margin:0 auto;border-radius:999px;display:flex;align-items:center;justify-content:center;border:1px dashed rgba(0,0,0,.2);opacity:.7;">
                                    <i class="fas fa-user fa-2x"></i>
                                </div>
                                <div class="small text-muted mt-2">No photo uploaded</div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="row g-2">
                        <div class="col-12">
                            <div class="small text-muted">Name</div>
                            <div class="h5 mb-0">{{ $testimonial->name }}</div>
                        </div>

                        <div class="col-12">
                            <div class="small text-muted">Company / Designation</div>
                            <div class="fw-semibold">{{ $testimonial->company_designation ?? '-' }}</div>
                        </div>

                        <div class="col-md-6">
                            <div class="small text-muted">Status</div>
                            <div class="fw-semibold">{{ \App\Models\Testimonial::IS_ACTIVE_SELECT[$testimonial->is_active] ?? $testimonial->is_active }}</div>
                        </div>

                        <div class="col-md-6">
                            <div class="small text-muted">Sort Order</div>
                            <div class="fw-semibold">{{ $testimonial->sort_order ?? 0 }}</div>
                        </div>

                        <div class="col-12 mt-2">
                            <div class="small text-muted">Review</div>
                            <div style="white-space:pre-wrap;">{{ $testimonial->review }}</div>
                        </div>

                        <div class="col-12 mt-2 small text-muted">
                            Updated: {{ optional($testimonial->updated_at)->format('d M Y, h:i A') }}
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection
