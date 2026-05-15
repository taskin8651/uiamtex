@extends('layouts.admin')
@section('content')

@php
    // If you added relation downloadRelation (belongsTo Download via download_id)
    $downloadTitle = optional($downloadRequest->downloadRelation)->title ?: ($downloadRequest->download ?? '—');

    // Safe mailto + tel
    $phoneRaw = $downloadRequest->phone ?? '';
    $phoneTel = preg_replace('/\s+/', '', $phoneRaw);
    $email    = $downloadRequest->email ?? '';

    // Optional fields (if you added them)
    $city    = $downloadRequest->city ?? null;
    $purpose = $downloadRequest->purpose ?? null;
    $message = $downloadRequest->message ?? null;
@endphp

<div class="amtex-page">

    {{-- Header --}}
    <div class="amtex-header mb-3">
        <div>
            <h2 class="amtex-title">{{ trans('cruds.downloadRequest.title_singular') ?? 'Download Request' }}</h2>
            <p class="amtex-subtitle mb-0">View lead details submitted from the unlock download form.</p>
        </div>

        <div class="amtex-actions d-flex flex-wrap gap-2">
            <a class="btn btn-light" href="{{ route('admin.download-requests.index') }}">
                <i class="fas fa-arrow-left"></i> Back
            </a>

            @can('download_request_edit')
                <a class="btn btn-outline-primary" href="{{ route('admin.download-requests.edit', $downloadRequest->id) }}">
                    <i class="fas fa-pen"></i> Edit
                </a>
            @endcan

            @can('download_request_delete')
                <form
                    action="{{ route('admin.download-requests.destroy', $downloadRequest->id) }}"
                    method="POST"
                    onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
                    class="d-inline"
                >
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </form>
            @endcan
        </div>
    </div>

    <div class="row g-3">

        {{-- Main Details --}}
        <div class="col-lg-8">
            <div class="amtex-card">
                <div class="amtex-card-head d-flex justify-content-between align-items-start">
                    <div>
                        <h4 class="mb-1">{{ $downloadRequest->name ?? '—' }}</h4>
                        <div class="small text-muted">
                            <span class="me-2"><strong>ID:</strong> #{{ $downloadRequest->id }}</span>
                            <span><strong>Created:</strong> {{ optional($downloadRequest->created_at)->format('d M Y, h:i A') }}</span>
                        </div>
                    </div>
                    <span class="amtex-chip">{{ $downloadTitle }}</span>
                </div>

                <div class="amtex-card-body">
                    <div class="row g-2">
                        <div class="col-md-6">
                            <div class="small text-muted mb-1">Phone</div>
                            <div class="fw-semibold">
                                @if(!empty($phoneRaw))
                                    <a href="tel:{{ $phoneTel }}" class="text-decoration-none">{{ $phoneRaw }}</a>
                                @else
                                    —
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="small text-muted mb-1">Email</div>
                            <div class="fw-semibold">
                                @if(!empty($email))
                                    <a href="mailto:{{ $email }}" class="text-decoration-none">{{ $email }}</a>
                                @else
                                    —
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="small text-muted mb-1">Company</div>
                            <div class="fw-semibold">{{ $downloadRequest->company ?? '—' }}</div>
                        </div>

                        <div class="col-md-6">
                            <div class="small text-muted mb-1">Download</div>
                            <div class="fw-semibold">{{ $downloadTitle }}</div>
                        </div>

                        @if(!is_null($city) || !is_null($purpose))
                            <div class="col-md-6">
                                <div class="small text-muted mb-1">City</div>
                                <div class="fw-semibold">{{ $city ?: '—' }}</div>
                            </div>

                            <div class="col-md-6">
                                <div class="small text-muted mb-1">Purpose</div>
                                <div class="fw-semibold">{{ $purpose ?: '—' }}</div>
                            </div>
                        @endif

                        @if(!empty($message))
                            <div class="col-12">
                                <div class="small text-muted mb-1">Message</div>
                                <div class="p-3 rounded" style="background:#f8fafc; border:1px solid rgba(0,0,0,.06); white-space:pre-wrap;">
                                    {{ $message }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="amtex-card-footer d-flex justify-content-end gap-2">
                    <a class="btn btn-light" href="{{ route('admin.download-requests.index') }}">
                        Back to list
                    </a>
                </div>
            </div>
        </div>

        {{-- Quick Actions --}}
        <div class="col-lg-4">
            <div class="amtex-card">
                <div class="amtex-card-head">
                    <h4 class="mb-0">Quick Actions</h4>
                </div>

                <div class="amtex-card-body">
                    <div class="d-grid gap-2">
                        @if(!empty($phoneRaw))
                            <a class="btn btn-outline-success" href="tel:{{ $phoneTel }}">
                                <i class="fas fa-phone"></i> Call
                            </a>

                            @php
                                $waText = rawurlencode("Hi ".($downloadRequest->name ?? '').", regarding your download request: ".$downloadTitle);
                                $waPhone = preg_replace('/\D+/', '', $phoneRaw);
                            @endphp
                            <a class="btn btn-outline-success" target="_blank" rel="noopener"
                               href="https://wa.me/{{ $waPhone }}?text={{ $waText }}">
                                <i class="fab fa-whatsapp"></i> WhatsApp
                            </a>
                        @endif

                        @if(!empty($email))
                            <a class="btn btn-outline-primary" href="mailto:{{ $email }}?subject={{ rawurlencode('Regarding your download request') }}">
                                <i class="fas fa-envelope"></i> Email
                            </a>
                        @endif
                    </div>

                    <hr>

                    <div class="small text-muted">
                        <div><strong>Updated:</strong> {{ optional($downloadRequest->updated_at)->format('d M Y, h:i A') }}</div>
                        @if(!empty($downloadRequest->deleted_at))
                            <div class="text-danger mt-1"><strong>Deleted:</strong> {{ optional($downloadRequest->deleted_at)->format('d M Y, h:i A') }}</div>
                        @endif
                    </div>
                </div>

            </div>
        </div>

    </div>

</div>

@endsection
