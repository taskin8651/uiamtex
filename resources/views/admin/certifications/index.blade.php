@extends('layouts.admin')
@section('content')

<div class="amtex-page">

    {{-- Header --}}
    <div class="amtex-header">
        <div>
            <h2 class="amtex-title">{{ trans('cruds.certification.title') ?? 'Certifications' }}</h2>
            <p class="amtex-subtitle">Manage certification documents, sort order and visibility.</p>
        </div>

        <div class="amtex-actions d-flex flex-wrap gap-2">

            @if(session('message'))
                <div class="amtex-alert">{{ session('message') }}</div>
            @endif

            @can('certification_create')
                <a class="btn amtex-btn" href="{{ route('admin.certifications.create') }}">
                    <i class="fas fa-plus"></i> Add Certification
                </a>

                <button class="btn amtex-btn-outline" data-toggle="modal" data-target="#csvImportModal">
                    <i class="fas fa-file-upload"></i> CSV Import
                </button>

                @include('csvImport.modal', ['model' => 'Certification', 'route' => 'admin.certifications.parseCsvImport'])
            @endcan
        </div>
    </div>

    {{-- Filters --}}
    <div class="amtex-card mb-3">
        <div class="amtex-card-head">
            <h4 class="mb-0">Filters</h4>
        </div>

        <div class="amtex-card-body">
            <form method="GET" action="{{ route('admin.certifications.index') }}" class="row g-2 align-items-end">

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
                    <select name="sort" class="form-control">
                        @php $sort = $filters['sort'] ?? 'sort_order'; @endphp
                        <option value="sort_order" {{ $sort === 'sort_order' ? 'selected' : '' }}>Sort Order</option>
                        <option value="id" {{ $sort === 'id' ? 'selected' : '' }}>ID</option>
                        <option value="title" {{ $sort === 'title' ? 'selected' : '' }}>Title</option>
                        <option value="is_active" {{ $sort === 'is_active' ? 'selected' : '' }}>Status</option>
                        <option value="updated_at" {{ $sort === 'updated_at' ? 'selected' : '' }}>Updated</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="amtex-label">Direction</label>
                    <select name="dir" class="form-control">
                        @php $dir = $filters['dir'] ?? 'asc'; @endphp
                        <option value="asc" {{ $dir === 'asc' ? 'selected' : '' }}>ASC</option>
                        <option value="desc" {{ $dir === 'desc' ? 'selected' : '' }}>DESC</option>
                    </select>
                </div>

                <div class="col-12 d-flex gap-2 mt-1">
                    <button class="btn btn-danger" type="submit">Apply</button>
                    <a class="btn btn-light" href="{{ route('admin.certifications.index') }}">Reset</a>
                </div>

            </form>
        </div>
    </div>

    {{-- Empty State --}}
    @if($certifications->count() === 0)
        <div class="amtex-empty">
            <div class="amtex-empty-card">
                <div class="amtex-badge">No Data</div>
                <h3>No certifications found</h3>
                <p>Add certifications to display across the website and compliance pages.</p>

                @can('certification_create')
                    <a class="btn amtex-btn mt-2" href="{{ route('admin.certifications.create') }}">
                        Add First Certification
                    </a>
                @endcan
            </div>
        </div>
    @else

        {{-- Grid --}}
        <div class="row g-3">
            @foreach($certifications as $certification)
                <div class="col-md-6 col-lg-4">
                    <div class="amtex-card h-100">

                        <div class="amtex-card-head d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">
                                {{ $certification->title ?? 'Certification' }}
                            </h4>

                            @if((string)$certification->is_active === '1')
                                <span class="amtex-chip">Active</span>
                            @else
                                <span class="amtex-chip amtex-chip-warn">Inactive</span>
                            @endif
                        </div>

                        <div class="amtex-card-body">

                            {{-- Image (ORIGINAL to avoid blur) --}}
                            @if($certification->image)
                                <a href="{{ $certification->image->getUrl() }}" target="_blank" rel="noopener">
                                    <img
                                        src="{{ $certification->image->getUrl() }}"
                                        alt="{{ $certification->title }}"
                                        class="img-fluid rounded mb-2"
                                        style="width:100%; height:180px; object-fit:cover;"
                                        loading="lazy"
                                    >
                                </a>
                            @else
                                <div class="amtex-muted mb-2">No image uploaded</div>
                            @endif

                            <div class="small text-muted">
                                ID: <strong>#{{ $certification->id }}</strong>
                            </div>

                            <div class="small text-muted mt-1">
                                Sort Order: <strong>{{ $certification->sort_order ?? 0 }}</strong>
                            </div>

                            <div class="small text-muted mt-1">
                                Updated: <strong>{{ optional($certification->updated_at)->format('d M Y') }}</strong>
                            </div>

                        </div>

                        {{-- Actions --}}
                        <div class="amtex-card-footer d-flex justify-content-end gap-1">

                            @can('certification_show')
                                <a href="{{ route('admin.certifications.show', $certification->id) }}" class="btn btn-sm btn-outline-secondary">
                                    View
                                </a>
                            @endcan

                            @can('certification_edit')
                                <a href="{{ route('admin.certifications.edit', $certification->id) }}" class="btn btn-sm btn-outline-primary">
                                    Edit
                                </a>
                            @endcan

                            @can('certification_delete')
                                <form
                                    action="{{ route('admin.certifications.destroy', $certification->id) }}"
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
            {{ $certifications->links() }}
        </div>

    @endif

</div>

@endsection
