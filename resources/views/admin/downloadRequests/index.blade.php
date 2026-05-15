@extends('layouts.admin')
@section('content')

<div class="amtex-page">

    {{-- Header --}}
    <div class="amtex-header">
        <div>
            <h2 class="amtex-title">{{ trans('cruds.downloadRequest.title') ?? 'Download Requests' }}</h2>
            <p class="amtex-subtitle">View and manage download leads captured from the website.</p>
        </div>

        <div class="amtex-actions d-flex flex-wrap gap-2">

            @if(session('message'))
                <div class="amtex-alert">{{ session('message') }}</div>
            @endif

            @can('download_request_create')
                <a class="btn amtex-btn" href="{{ route('admin.download-requests.create') }}">
                    <i class="fas fa-plus"></i> Add Request
                </a>

                <button class="btn amtex-btn-outline" data-toggle="modal" data-target="#csvImportModal">
                    <i class="fas fa-file-upload"></i> CSV Import
                </button>

                @include('csvImport.modal', ['model' => 'DownloadRequest', 'route' => 'admin.download-requests.parseCsvImport'])
            @endcan

        </div>
    </div>

    {{-- Filters --}}
    <div class="amtex-card mb-3">
        <div class="amtex-card-head d-flex align-items-center justify-content-between">
            <h4 class="mb-0">Filters</h4>
        </div>

        <div class="amtex-card-body">
            <form method="GET" action="{{ route('admin.download-requests.index') }}" class="row g-2 align-items-end">

                <div class="col-md-5">
                    <label class="amtex-label">Search</label>
                    <input
                        type="text"
                        name="q"
                        value="{{ $filters['q'] ?? '' }}"
                        class="form-control"
                        placeholder="Search by name, phone, email, company, purpose, download..."
                    />
                </div>

                <div class="col-md-2">
                    <label class="amtex-label">From</label>
                    <input type="date" name="from" value="{{ $filters['from'] ?? '' }}" class="form-control" />
                </div>

                <div class="col-md-2">
                    <label class="amtex-label">To</label>
                    <input type="date" name="to" value="{{ $filters['to'] ?? '' }}" class="form-control" />
                </div>

                <div class="col-md-2">
                    <label class="amtex-label">Sort</label>
                    @php $sort = $filters['sort'] ?? 'id'; @endphp
                    <select name="sort" class="form-control">
                        <option value="id" {{ $sort === 'id' ? 'selected' : '' }}>ID</option>
                        <option value="created_at" {{ $sort === 'created_at' ? 'selected' : '' }}>Created</option>
                        <option value="name" {{ $sort === 'name' ? 'selected' : '' }}>Name</option>
                        <option value="phone" {{ $sort === 'phone' ? 'selected' : '' }}>Phone</option>
                        <option value="email" {{ $sort === 'email' ? 'selected' : '' }}>Email</option>
                        <option value="company" {{ $sort === 'company' ? 'selected' : '' }}>Company</option>
                        <option value="city" {{ $sort === 'city' ? 'selected' : '' }}>City</option>
                        <option value="purpose" {{ $sort === 'purpose' ? 'selected' : '' }}>Purpose</option>
                    </select>
                </div>

                <div class="col-md-1">
                    <label class="amtex-label">Dir</label>
                    @php $dir = $filters['dir'] ?? 'desc'; @endphp
                    <select name="dir" class="form-control">
                        <option value="asc" {{ $dir === 'asc' ? 'selected' : '' }}>ASC</option>
                        <option value="desc" {{ $dir === 'desc' ? 'selected' : '' }}>DESC</option>
                    </select>
                </div>

                <div class="col-12 d-flex gap-2 mt-1">
                    <button class="btn btn-danger" type="submit">Apply</button>
                    <a class="btn btn-light" href="{{ route('admin.download-requests.index') }}">Reset</a>
                </div>

            </form>
        </div>
    </div>

    {{-- Empty State --}}
    @if($downloadRequests->count() === 0)
        <div class="amtex-empty">
            <div class="amtex-empty-card">
                <div class="amtex-badge">No Data</div>
                <h3>No download requests found</h3>
                <p>When visitors unlock downloads on the website, requests will appear here.</p>
            </div>
        </div>
    @else

        {{-- Grid --}}
        <div class="row g-3">
            @foreach($downloadRequests as $req)
                @php
                    $downloadTitle = optional($req->downloadRelation)->title ?: ($req->download ?? '—');
                @endphp

                <div class="col-md-6 col-lg-4">
                    <div class="amtex-card h-100">

                        <div class="amtex-card-head d-flex justify-content-between align-items-start">
                            <div>
                                <h4 class="mb-1">{{ $req->name ?? '—' }}</h4>
                                <div class="small text-muted">
                                    <span class="me-2">#{{ $req->id }}</span>
                                    <span>{{ optional($req->created_at)->format('d M Y, h:i A') }}</span>
                                </div>
                            </div>

                            <span class="amtex-chip">
                                {{ $downloadTitle }}
                            </span>
                        </div>

                        <div class="amtex-card-body">

                            <div class="small text-muted mb-2">
                                <div><strong>Phone:</strong> {{ $req->phone ?? '—' }}</div>
                                <div><strong>Email:</strong> {{ $req->email ?? '—' }}</div>
                                <div><strong>Company:</strong> {{ $req->company ?? '—' }}</div>
                                <div><strong>City:</strong> {{ $req->city ?? '—' }}</div>
                                <div><strong>Purpose:</strong> {{ $req->purpose ?? '—' }}</div>
                            </div>

                            @if(!empty($req->message))
                                <div class="p-2 rounded" style="background:#f8fafc; border:1px solid rgba(0,0,0,.06);">
                                    <div class="small fw-semibold mb-1">Message</div>
                                    <div class="small" style="white-space: pre-wrap;">{{ $req->message }}</div>
                                </div>
                            @endif

                        </div>

                        {{-- Actions --}}
                        <div class="amtex-card-footer d-flex justify-content-end gap-1">

                            @can('download_request_show')
                                <a href="{{ route('admin.download-requests.show', $req->id) }}" class="btn btn-sm btn-outline-secondary">
                                    View
                                </a>
                            @endcan

                            @can('download_request_edit')
                                <a href="{{ route('admin.download-requests.edit', $req->id) }}" class="btn btn-sm btn-outline-primary">
                                    Edit
                                </a>
                            @endcan

                            @can('download_request_delete')
                                <form
                                    action="{{ route('admin.download-requests.destroy', $req->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
                                >
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        Delete
                                    </button>
                                </form>
                            @endcan

                        </div>

                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-4">
            {{ $downloadRequests->onEachSide(1)->links() }}
        </div>

    @endif

</div>

@endsection
