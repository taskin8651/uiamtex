@extends('layouts.admin')
@section('content')

<div class="amtex-page">

    <div class="amtex-header">
        <div>
            <h2 class="amtex-title">View Service Feature</h2>
            <p class="amtex-subtitle">Feature details and mapping.</p>
        </div>

        <div class="amtex-actions d-flex gap-2">
            <a class="btn btn-light" href="{{ route('admin.service-features.index') }}">
                <i class="fas fa-arrow-left"></i> Back
            </a>

            @can('service_feature_edit')
                <a class="btn btn-primary" href="{{ route('admin.service-features.edit', $serviceFeature->id) }}">
                    <i class="fas fa-pen"></i> Edit
                </a>
            @endcan
        </div>
    </div>

    <div class="amtex-card">
        <div class="amtex-card-head">
            <h4 class="mb-0">Feature</h4>
        </div>

        <div class="amtex-card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="small text-muted">ID</div>
                    <div class="fw-bold">#{{ $serviceFeature->id }}</div>
                </div>

                <div class="col-md-6">
                    <div class="small text-muted">Service</div>
                    <div class="fw-bold">{{ $serviceFeature->service->title ?? '-' }}</div>
                </div>

                <div class="col-12">
                    <div class="small text-muted">Feature Text</div>
                    <div class="fw-bold">{{ $serviceFeature->feature_text }}</div>
                </div>

                <div class="col-md-4">
                    <div class="small text-muted">Sort Order</div>
                    <div class="fw-bold">{{ $serviceFeature->sort_order ?? 0 }}</div>
                </div>

                <div class="col-md-8">
                    <div class="small text-muted">Last Updated</div>
                    <div class="fw-bold">{{ optional($serviceFeature->updated_at)->format('d M Y, h:i A') }}</div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection
