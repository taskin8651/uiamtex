@extends('layouts.admin')
@section('content')

<div class="amtex-page">

    {{-- Header --}}
    <div class="amtex-header">
        <div>
            <h2 class="amtex-title">Services</h2>
            <p class="amtex-subtitle">Manage service cards, features, visibility & ordering.</p>
        </div>

        <div class="amtex-actions d-flex flex-wrap gap-2">
            @if(session('message'))
                <div class="amtex-alert">{{ session('message') }}</div>
            @endif

            @can('service_create')
                <a class="btn amtex-btn" href="{{ route('admin.services.create') }}">
                    <i class="fas fa-plus"></i> Add Service
                </a>
            @endcan
        </div>
    </div>

    {{-- Filters --}}
    <div class="amtex-card mb-3">
        <div class="amtex-card-head">
            <h4 class="mb-0">Filters</h4>
        </div>
        <div class="amtex-card-body">
            <form method="GET" action="{{ route('admin.services.index') }}" class="row g-2 align-items-end">

                <div class="col-md-5">
                    <label class="amtex-label">Search</label>
                    <input type="text" name="q" value="{{ $filters['q'] ?? '' }}" class="form-control"
                           placeholder="Search by title, category or ID" />
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
                        <option value="category" {{ $sort === 'category' ? 'selected' : '' }}>Category</option>
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
                    <a class="btn btn-light" href="{{ route('admin.services.index') }}">Reset</a>
                </div>

            </form>
        </div>
    </div>

    {{-- Empty --}}
    @if($services->count() === 0)
        <div class="amtex-empty">
            <div class="amtex-empty-card">
                <div class="amtex-badge">No Data</div>
                <h3>No services found</h3>
                <p>Create services to render the Services page dynamically.</p>

                @can('service_create')
                    <a class="btn amtex-btn mt-2" href="{{ route('admin.services.create') }}">
                        Add First Service
                    </a>
                @endcan
            </div>
        </div>
    @else

        {{-- Grid --}}
        <div class="row g-3">
            @foreach($services as $service)
                <div class="col-md-6 col-lg-4">
                    <div class="amtex-card h-100">

                        <div class="amtex-card-head d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="mb-0">{{ $service->title }}</h4>
                                @if(!empty($service->category))
                                    <div class="small text-muted mt-1">{{ $service->category }}</div>
                                @endif
                            </div>

                            @if((string)$service->is_active === 'yes')
                                <span class="amtex-chip">Active</span>
                            @else
                                <span class="amtex-chip amtex-chip-warn">Inactive</span>
                            @endif
                        </div>

                        <div class="amtex-card-body">
                            @if(!empty($service->short_description))
                                <div class="text-muted" style="font-size: 13px;">
                                    {{ \Illuminate\Support\Str::limit($service->short_description, 140) }}
                                </div>
                            @else
                                <div class="text-muted" style="font-size: 13px;">No short description.</div>
                            @endif

                            <div class="small text-muted mt-2">
                                ID: <strong>#{{ $service->id }}</strong>
                                <span class="mx-2">•</span>
                                Sort: <strong>{{ $service->sort_order ?? 0 }}</strong>
                            </div>

                            <div class="small text-muted mt-1">
                                Features: <strong>{{ $service->features()->count() }}</strong>
                            </div>

                            <div class="small text-muted mt-1">
                                Updated: <strong>{{ optional($service->updated_at)->format('d M Y') }}</strong>
                            </div>
                        </div>

                        <div class="amtex-card-footer d-flex justify-content-end gap-1">
                            @can('service_show')
                                <a href="{{ route('admin.services.show', $service->id) }}" class="btn btn-sm btn-outline-secondary">View</a>
                            @endcan
                            @can('service_edit')
                                <a href="{{ route('admin.services.edit', $service->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                            @endcan
                            @can('service_delete')
                                <form action="{{ route('admin.services.destroy', $service->id) }}" method="POST"
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

        <div class="mt-4">
            {{-- FIX pagination UI (proper alignment & clickable) --}}
            <div class="d-flex justify-content-center">
                {{ $services->links() }}
            </div>
        </div>

    @endif

</div>

@endsection
