@extends('layouts.admin')
@section('content')

<div class="amtex-page">

    <div class="amtex-header">
        <div>
            <h2 class="amtex-title">Service Features</h2>
            <p class="amtex-subtitle">Manage bullet-points shown inside each service.</p>
        </div>

        <div class="amtex-actions d-flex flex-wrap gap-2">
            @if(session('message'))
                <div class="amtex-alert">{{ session('message') }}</div>
            @endif

            @can('service_feature_create')
                <a class="btn amtex-btn" href="{{ route('admin.service-features.create') }}">
                    <i class="fas fa-plus"></i> Add Feature
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
            <form method="GET" action="{{ route('admin.service-features.index') }}" class="row g-2 align-items-end">

                <div class="col-md-5">
                    <label class="amtex-label">Search</label>
                    <input
                        type="text"
                        name="q"
                        value="{{ $filters['q'] ?? '' }}"
                        class="form-control"
                        placeholder="Search by feature text or ID"
                    />
                </div>

                <div class="col-md-3">
                    <label class="amtex-label">Service</label>
                    <select name="service_id" class="form-control">
                        <option value="">All</option>
                        @foreach($services as $id => $title)
                            <option value="{{ $id }}" {{ (string)($filters['service_id'] ?? '') === (string)$id ? 'selected' : '' }}>
                                {{ $title }}
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
                        <option value="service_id" {{ $sort === 'service_id' ? 'selected' : '' }}>Service</option>
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
                    <a class="btn btn-light" href="{{ route('admin.service-features.index') }}">Reset</a>
                </div>

            </form>
        </div>
    </div>

    @if($serviceFeatures->count() === 0)
        <div class="amtex-empty">
            <div class="amtex-empty-card">
                <div class="amtex-badge">No Data</div>
                <h3>No service features found</h3>
                <p>Add features to show as bullet points under services.</p>

                @can('service_feature_create')
                    <a class="btn amtex-btn mt-2" href="{{ route('admin.service-features.create') }}">
                        Add First Feature
                    </a>
                @endcan
            </div>
        </div>
    @else
        <div class="row g-3">
            @foreach($serviceFeatures as $feature)
                <div class="col-md-6 col-lg-4">
                    <div class="amtex-card h-100">
                        <div class="amtex-card-head d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">#{{ $feature->id }}</h4>
                            <span class="amtex-chip">{{ $feature->service->title ?? 'Service' }}</span>
                        </div>

                        <div class="amtex-card-body">
                            <div class="mb-2" style="font-weight:600;">
                                {{ $feature->feature_text }}
                            </div>

                            <div class="small text-muted">
                                Sort Order: <strong>{{ $feature->sort_order ?? 0 }}</strong>
                            </div>

                            <div class="small text-muted mt-1">
                                Updated: <strong>{{ optional($feature->updated_at)->format('d M Y') }}</strong>
                            </div>
                        </div>

                        <div class="amtex-card-footer d-flex justify-content-end gap-1">

                            @can('service_feature_show')
                                <a href="{{ route('admin.service-features.show', $feature->id) }}" class="btn btn-sm btn-outline-secondary">
                                    View
                                </a>
                            @endcan

                            @can('service_feature_edit')
                                <a href="{{ route('admin.service-features.edit', $feature->id) }}" class="btn btn-sm btn-outline-primary">
                                    Edit
                                </a>
                            @endcan

                            @can('service_feature_delete')
                                <form action="{{ route('admin.service-features.destroy', $feature->id) }}" method="POST"
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
            {{ $serviceFeatures->links() }}
        </div>
    @endif

</div>

@endsection
