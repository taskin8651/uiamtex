@extends('layouts.admin')
@section('content')

<div class="amtex-page">

    {{-- Header --}}
    <div class="amtex-header">
        <div>
            <h2 class="amtex-title">{{ trans('cruds.client.title') ?? 'Clients' }}</h2>
            <p class="amtex-subtitle">Manage client logos, sort order and visibility.</p>
        </div>

        <div class="amtex-actions d-flex flex-wrap gap-2">

            @if(session('message'))
                <div class="amtex-alert">{{ session('message') }}</div>
            @endif

            @can('client_create')
                <a class="btn amtex-btn" href="{{ route('admin.clients.create') }}">
                    <i class="fas fa-plus"></i> Add Client
                </a>

                <button class="btn amtex-btn-outline" data-toggle="modal" data-target="#csvImportModal">
                    <i class="fas fa-file-upload"></i> CSV Import
                </button>

                @include('csvImport.modal', ['model' => 'Client', 'route' => 'admin.clients.parseCsvImport'])
            @endcan

        </div>
    </div>

    {{-- Filters --}}
    <div class="amtex-card mb-3">
        <div class="amtex-card-head">
            <h4 class="mb-0">Filters</h4>
        </div>

        <div class="amtex-card-body">
            <form method="GET" action="{{ route('admin.clients.index') }}" class="row g-2 align-items-end">

                <div class="col-md-5">
                    <label class="amtex-label">Search</label>
                    <input
                        type="text"
                        name="q"
                        value="{{ $filters['q'] ?? '' }}"
                        class="form-control"
                        placeholder="Search by name or ID"
                    />
                </div>

                <div class="col-md-3">
                    <label class="amtex-label">Status</label>
                    <select name="status" class="form-control">
                        <option value="">All</option>
                        @foreach($isActiveOptions as $key => $label)
                            <option value="{{ $key }}" {{ (string)($filters['status'] ?? '') === (string)$key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="amtex-label">Sort</label>
                    @php $sort = $filters['sort'] ?? 'sort_order'; @endphp
                    <select name="sort" class="form-control">
                        <option value="sort_order" {{ $sort === 'sort_order' ? 'selected' : '' }}>Sort Order</option>
                        <option value="id" {{ $sort === 'id' ? 'selected' : '' }}>ID</option>
                        <option value="name" {{ $sort === 'name' ? 'selected' : '' }}>Name</option>
                        <option value="is_active" {{ $sort === 'is_active' ? 'selected' : '' }}>Status</option>
                        <option value="updated_at" {{ $sort === 'updated_at' ? 'selected' : '' }}>Updated</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="amtex-label">Direction</label>
                    @php $dir = $filters['dir'] ?? 'asc'; @endphp
                    <select name="dir" class="form-control">
                        <option value="asc" {{ $dir === 'asc' ? 'selected' : '' }}>ASC</option>
                        <option value="desc" {{ $dir === 'desc' ? 'selected' : '' }}>DESC</option>
                    </select>
                </div>

                <div class="col-12 d-flex gap-2 mt-1">
                    <button class="btn btn-danger" type="submit">Apply</button>
                    <a class="btn btn-light" href="{{ route('admin.clients.index') }}">Reset</a>
                </div>

            </form>
        </div>
    </div>

    {{-- Empty State --}}
    @if($clients->count() === 0)
        <div class="amtex-empty">
            <div class="amtex-empty-card">
                <div class="amtex-badge">No Data</div>
                <h3>No clients found</h3>
                <p>Add client logos to display on the website in the Clients section.</p>

                @can('client_create')
                    <a class="btn amtex-btn mt-2" href="{{ route('admin.clients.create') }}">
                        Add First Client
                    </a>
                @endcan
            </div>
        </div>
    @else

        {{-- Grid --}}
        <div class="row g-3">
            @foreach($clients as $client)
                <div class="col-md-6 col-lg-4">
                    <div class="amtex-card h-100">

                        <div class="amtex-card-head d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">
                                {{ $client->name ?? 'Client' }}
                            </h4>

                            @if((string)$client->is_active === 'yes')
                                <span class="amtex-chip">Active</span>
                            @else
                                <span class="amtex-chip amtex-chip-warn">Inactive</span>
                            @endif
                        </div>

                        <div class="amtex-card-body">

                            {{-- Logo --}}
                            @if($client->logo)
                                <a href="{{ $client->logo->url }}" target="_blank" rel="noopener">
                                    <img
                                        src="{{ $client->logo->url }}"
                                        alt="{{ $client->name }}"
                                        class="img-fluid rounded mb-2"
                                        style="width:100%; height:180px; object-fit:contain; background:#fff; border:1px solid rgba(0,0,0,.06); padding:10px;"
                                    >
                                </a>
                            @else
                                <div class="amtex-muted mb-2">No logo uploaded</div>
                            @endif

                            <div class="small text-muted">
                                ID: <strong>#{{ $client->id }}</strong>
                            </div>

                            <div class="small text-muted mt-1">
                                Sort Order: <strong>{{ $client->sort_order ?? 0 }}</strong>
                            </div>

                            <div class="small text-muted mt-1">
                                Updated: <strong>{{ optional($client->updated_at)->format('d M Y') }}</strong>
                            </div>

                        </div>

                        {{-- Actions --}}
                        <div class="amtex-card-footer d-flex justify-content-end gap-1">

                            @can('client_show')
                                <a href="{{ route('admin.clients.show', $client->id) }}" class="btn btn-sm btn-outline-secondary">
                                    View
                                </a>
                            @endcan

                            @can('client_edit')
                                <a href="{{ route('admin.clients.edit', $client->id) }}" class="btn btn-sm btn-outline-primary">
                                    Edit
                                </a>
                            @endcan

                            @can('client_delete')
                                <form
                                    action="{{ route('admin.clients.destroy', $client->id) }}"
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

        {{-- Pagination (Bootstrap view to avoid huge SVG arrows) --}}
        <div class="d-flex flex-wrap justify-content-between align-items-center mt-4">
            <div class="small text-muted mb-2 mb-md-0">
                Showing {{ $clients->firstItem() }} to {{ $clients->lastItem() }} of {{ $clients->total() }} results
            </div>

            <div>
                {{ $clients->appends(request()->query())->links('pagination::bootstrap-5') }}
            </div>
        </div>

    @endif

</div>

{{-- Safety fallback: if any SVG leaks into pagination, constrain it --}}
<style>
    .pagination svg { width: 16px !important; height: 16px !important; }
</style>

@endsection
