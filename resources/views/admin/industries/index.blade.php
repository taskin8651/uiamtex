@extends('layouts.admin')
@section('content')

<div class="amtex-page">

    {{-- Header --}}
    <div class="amtex-header">
        <div>
            <h2 class="amtex-title">{{ trans('cruds.industry.title') ?? 'Industries' }}</h2>
            <p class="amtex-subtitle">Manage industries shown on the Services page.</p>
        </div>

        <div class="amtex-actions d-flex flex-wrap gap-2">
            @if(session('message'))
                <div class="amtex-alert">{{ session('message') }}</div>
            @endif

            @can('industry_create')
                <a class="btn amtex-btn" href="{{ route('admin.industries.create') }}">
                    <i class="fas fa-plus"></i> Add Industry
                </a>

                <button class="btn amtex-btn-outline" data-toggle="modal" data-target="#csvImportModal">
                    <i class="fas fa-file-upload"></i> CSV Import
                </button>

                {{-- IMPORTANT:
                    This route must exist, otherwise you'll get:
                    "Route [admin.industries.parseCsvImport] not defined."
                    If you are NOT using CSV import for Industries, remove the button + include below.
                --}}
                @include('csvImport.modal', ['model' => 'Industry', 'route' => 'admin.industries.parseCsvImport'])
            @endcan
        </div>
    </div>

    {{-- Filters --}}
    <div class="amtex-card mb-3">
        <div class="amtex-card-head">
            <h4 class="mb-0">Filters</h4>
        </div>

        <div class="amtex-card-body">
            <form method="GET" action="{{ route('admin.industries.index') }}" class="row g-2 align-items-end">

                <div class="col-md-5">
                    <label class="amtex-label">Search</label>
                    <input
                        type="text"
                        name="q"
                        value="{{ $filters['q'] ?? '' }}"
                        class="form-control"
                        placeholder="Search by title or ID"
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
                        <option value="title" {{ $sort === 'title' ? 'selected' : '' }}>Title</option>
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
                    <a class="btn btn-light" href="{{ route('admin.industries.index') }}">Reset</a>
                </div>

            </form>
        </div>
    </div>

    {{-- Empty State --}}
    @if($industries->count() === 0)
        <div class="amtex-empty">
            <div class="amtex-empty-card">
                <div class="amtex-badge">No Data</div>
                <h3>No industries found</h3>
                <p>Add industries to show on the Services page.</p>

                @can('industry_create')
                    <a class="btn amtex-btn mt-2" href="{{ route('admin.industries.create') }}">
                        Add First Industry
                    </a>
                @endcan
            </div>
        </div>
    @else

        {{-- Grid --}}
        <div class="row g-3">
            @foreach($industries as $industry)
                <div class="col-md-6 col-lg-4">
                    <div class="amtex-card h-100">

                        <div class="amtex-card-head d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center gap-2">
                                {{-- Icon (Bootstrap icon class) --}}
                                <span class="d-inline-flex align-items-center justify-content-center"
                                      style="width:34px;height:34px;border:1px solid #e5e7eb;border-radius:10px;">
                                    <i class="{{ $industry->icon ?? 'bi bi-grid' }}"></i>
                                </span>

                                <h4 class="mb-0">{{ $industry->title ?? 'Industry' }}</h4>
                            </div>

                            @if((string)$industry->is_active === 'yes' || (string)$industry->is_active === '1')
                                <span class="amtex-chip">Active</span>
                            @else
                                <span class="amtex-chip amtex-chip-warn">Inactive</span>
                            @endif
                        </div>

                        <div class="amtex-card-body">
                            <div class="small text-muted">
                                ID: <strong>#{{ $industry->id }}</strong>
                            </div>

                            <div class="small text-muted mt-1">
                                Icon: <strong>{{ $industry->icon ?? '-' }}</strong>
                            </div>

                            <div class="small text-muted mt-1">
                                Sort Order: <strong>{{ $industry->sort_order ?? 0 }}</strong>
                            </div>

                            <div class="small text-muted mt-1">
                                Updated: <strong>{{ optional($industry->updated_at)->format('d M Y') }}</strong>
                            </div>
                        </div>

                        {{-- Actions --}}
                        <div class="amtex-card-footer d-flex justify-content-end gap-1">

                            @can('industry_show')
                                <a href="{{ route('admin.industries.show', $industry->id) }}" class="btn btn-sm btn-outline-secondary">
                                    View
                                </a>
                            @endcan

                            @can('industry_edit')
                                <a href="{{ route('admin.industries.edit', $industry->id) }}" class="btn btn-sm btn-outline-primary">
                                    Edit
                                </a>
                            @endcan

                            @can('industry_delete')
                                <form
                                    action="{{ route('admin.industries.destroy', $industry->id) }}"
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
        <div class="mt-4 d-flex justify-content-center">
            {{ $industries->appends(request()->query())->links() }}
        </div>

    @endif

</div>

@endsection
