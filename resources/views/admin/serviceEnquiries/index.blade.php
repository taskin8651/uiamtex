@extends('layouts.admin')
@section('content')

<div class="amtex-page">

    <div class="amtex-header">
        <div>
            <h2 class="amtex-title">Service Enquiries</h2>
            <p class="amtex-subtitle">Leads captured from the Services page.</p>
        </div>

        <div class="amtex-actions d-flex flex-wrap gap-2">
            @if(session('message'))
                <div class="amtex-alert">{{ session('message') }}</div>
            @endif

            @can('service_enquiry_create')
                <a class="btn amtex-btn" href="{{ route('admin.service-enquiries.create') }}">
                    <i class="fas fa-plus"></i> Add Enquiry
                </a>
            @endcan
        </div>
    </div>

    <div class="amtex-card mb-3">
        <div class="amtex-card-head">
            <h4 class="mb-0">Filters</h4>
        </div>
        <div class="amtex-card-body">
            <form method="GET" action="{{ route('admin.service-enquiries.index') }}" class="row g-2 align-items-end">

                <div class="col-md-6">
                    <label class="amtex-label">Search</label>
                    <input type="text" name="q" value="{{ $filters['q'] ?? '' }}" class="form-control"
                           placeholder="Name, phone, email, city, premises, service or ID" />
                </div>

                <div class="col-md-2">
                    <label class="amtex-label">Status</label>
                    <select name="status" class="form-control">
                        <option value="">All</option>
                        @foreach($statusOptions as $key => $label)
                            <option value="{{ $key }}" {{ (string)($filters['status'] ?? '') === (string)$key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="amtex-label">Sort</label>
                    @php $sort = $filters['sort'] ?? 'created_at'; @endphp
                    <select name="sort" class="form-control">
                        <option value="created_at" {{ $sort === 'created_at' ? 'selected' : '' }}>Created</option>
                        <option value="id" {{ $sort === 'id' ? 'selected' : '' }}>ID</option>
                        <option value="name" {{ $sort === 'name' ? 'selected' : '' }}>Name</option>
                        <option value="status" {{ $sort === 'status' ? 'selected' : '' }}>Status</option>
                        <option value="updated_at" {{ $sort === 'updated_at' ? 'selected' : '' }}>Updated</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="amtex-label">Direction</label>
                    @php $dir = $filters['dir'] ?? 'desc'; @endphp
                    <select name="dir" class="form-control">
                        <option value="desc" {{ $dir === 'desc' ? 'selected' : '' }}>DESC</option>
                        <option value="asc" {{ $dir === 'asc' ? 'selected' : '' }}>ASC</option>
                    </select>
                </div>

                <div class="col-12 d-flex gap-2 mt-1">
                    <button class="btn btn-danger" type="submit">Apply</button>
                    <a class="btn btn-light" href="{{ route('admin.service-enquiries.index') }}">Reset</a>
                </div>

            </form>
        </div>
    </div>

    @if($serviceEnquiries->count() === 0)
        <div class="amtex-empty">
            <div class="amtex-empty-card">
                <div class="amtex-badge">No Data</div>
                <h3>No enquiries found</h3>
                <p>Once users submit the service enquiry form, leads will appear here.</p>
            </div>
        </div>
    @else
        <div class="row g-3">
            @foreach($serviceEnquiries as $enquiry)
                <div class="col-md-6 col-lg-4">
                    <div class="amtex-card h-100">

                        <div class="amtex-card-head d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">#{{ $enquiry->id }} — {{ $enquiry->name }}</h4>

                            @php $st = $enquiry->status ?? 'new'; @endphp
                            <span class="amtex-chip {{ $st === 'closed' ? 'amtex-chip-warn' : '' }}">
                                {{ \App\Models\ServiceEnquiry::STATUS_SELECT[$st] ?? ucfirst($st) }}
                            </span>
                        </div>

                        <div class="amtex-card-body">
                            <div class="small text-muted">
                                Phone: <strong>{{ $enquiry->phone }}</strong>
                            </div>

                            @if($enquiry->email)
                                <div class="small text-muted mt-1">
                                    Email: <strong>{{ $enquiry->email }}</strong>
                                </div>
                            @endif

                            @if($enquiry->city)
                                <div class="small text-muted mt-1">
                                    City: <strong>{{ $enquiry->city }}</strong>
                                </div>
                            @endif

                            @if($enquiry->premises_type)
                                <div class="small text-muted mt-1">
                                    Premises: <strong>{{ $enquiry->premises_type }}</strong>
                                </div>
                            @endif

                            @if($enquiry->service_required)
                                <div class="small text-muted mt-1">
                                    Service: <strong>{{ $enquiry->service_required }}</strong>
                                </div>
                            @endif

                            @if($enquiry->message)
                                <div class="mt-2 small" style="opacity:.85;">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($enquiry->message), 90) }}
                                </div>
                            @endif

                            <div class="small text-muted mt-2">
                                Created: <strong>{{ optional($enquiry->created_at)->format('d M Y, h:i A') }}</strong>
                            </div>
                        </div>

                        <div class="amtex-card-footer d-flex justify-content-end gap-1">
                            @can('service_enquiry_show')
                                <a href="{{ route('admin.service-enquiries.show', $enquiry->id) }}" class="btn btn-sm btn-outline-secondary">
                                    View
                                </a>
                            @endcan

                            @can('service_enquiry_edit')
                                <a href="{{ route('admin.service-enquiries.edit', $enquiry->id) }}" class="btn btn-sm btn-outline-primary">
                                    Update Status
                                </a>
                            @endcan

                            @can('service_enquiry_delete')
                                <form action="{{ route('admin.service-enquiries.destroy', $enquiry->id) }}" method="POST"
                                      onsubmit="return confirm('{{ trans('global.areYouSure') }}');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                </form>
                            @endcan
                        </div>

                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4 d-flex justify-content-center">
            {{ $serviceEnquiries->links() }}
        </div>
    @endif

</div>

@endsection

