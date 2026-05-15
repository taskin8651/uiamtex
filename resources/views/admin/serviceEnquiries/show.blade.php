@extends('layouts.admin')
@section('content')

<div class="amtex-page">

    <div class="amtex-header">
        <div>
            <h2 class="amtex-title">View Service Enquiry</h2>
            <p class="amtex-subtitle">Complete enquiry details.</p>
        </div>

        <div class="amtex-actions d-flex gap-2">
            <a class="btn btn-light" href="{{ route('admin.service-enquiries.index') }}">
                <i class="fas fa-arrow-left"></i> Back
            </a>

            @can('service_enquiry_edit')
                <a class="btn btn-primary" href="{{ route('admin.service-enquiries.edit', $serviceEnquiry->id) }}">
                    <i class="fas fa-pen"></i> Update Status
                </a>
            @endcan
        </div>
    </div>

    <div class="amtex-card">
        <div class="amtex-card-head d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Enquiry #{{ $serviceEnquiry->id }}</h4>
            <span class="amtex-chip">
                {{ \App\Models\ServiceEnquiry::STATUS_SELECT[$serviceEnquiry->status] ?? ucfirst($serviceEnquiry->status) }}
            </span>
        </div>

        <div class="amtex-card-body">
            <div class="row g-3">

                <div class="col-md-6">
                    <div class="small text-muted">Name</div>
                    <div class="fw-bold">{{ $serviceEnquiry->name }}</div>
                </div>

                <div class="col-md-6">
                    <div class="small text-muted">Phone</div>
                    <div class="fw-bold">{{ $serviceEnquiry->phone }}</div>
                </div>

                <div class="col-md-6">
                    <div class="small text-muted">Email</div>
                    <div class="fw-bold">{{ $serviceEnquiry->email ?? '-' }}</div>
                </div>

                <div class="col-md-6">
                    <div class="small text-muted">City</div>
                    <div class="fw-bold">{{ $serviceEnquiry->city ?? '-' }}</div>
                </div>

                <div class="col-md-6">
                    <div class="small text-muted">Premises Type</div>
                    <div class="fw-bold">{{ $serviceEnquiry->premises_type ?? '-' }}</div>
                </div>

                <div class="col-md-6">
                    <div class="small text-muted">Service Required</div>
                    <div class="fw-bold">{{ $serviceEnquiry->service_required ?? '-' }}</div>
                </div>

                <div class="col-12">
                    <div class="small text-muted">Message</div>
                    <div class="fw-bold" style="white-space:pre-wrap;">{{ $serviceEnquiry->message ?? '-' }}</div>
                </div>

                <div class="col-md-6">
                    <div class="small text-muted">Created At</div>
                    <div class="fw-bold">{{ optional($serviceEnquiry->created_at)->format('d M Y, h:i A') }}</div>
                </div>

                <div class="col-md-6">
                    <div class="small text-muted">Last Updated</div>
                    <div class="fw-bold">{{ optional($serviceEnquiry->updated_at)->format('d M Y, h:i A') }}</div>
                </div>

            </div>
        </div>
    </div>

</div>

@endsection
