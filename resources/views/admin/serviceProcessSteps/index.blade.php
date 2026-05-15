@extends('layouts.admin')
@section('content')

<div class="amtex-page">

    <div class="amtex-header">
        <div>
            <h2 class="amtex-title">Service Process Steps</h2>
            <p class="amtex-subtitle">Control “Step 01/02/03/04” boxes on the Services page.</p>
        </div>

        <div class="amtex-actions d-flex flex-wrap gap-2">
            @if(session('message'))
                <div class="amtex-alert">{{ session('message') }}</div>
            @endif

            @can('service_process_step_create')
                <a class="btn amtex-btn" href="{{ route('admin.service-process-steps.create') }}">
                    <i class="fas fa-plus"></i> Add Step
                </a>
            @endcan
        </div>
    </div>

    <div class="amtex-card mb-3">
        <div class="amtex-card-head">
            <h4 class="mb-0">Filters</h4>
        </div>

        <div class="amtex-card-body">
            <form method="GET" action="{{ route('admin.service-process-steps.index') }}" class="row g-2 align-items-end">

                <div class="col-md-5">
                    <label class="amtex-label">Search</label>
                    <input type="text" name="q" value="{{ $filters['q'] ?? '' }}" class="form-control"
                           placeholder="Search by title, step no or ID" />
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
                        <option value="step_no" {{ $sort === 'step_no' ? 'selected' : '' }}>Step No</option>
                        <option value="title" {{ $sort === 'title' ? 'selected' : '' }}>Title</option>
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
                    <a class="btn btn-light" href="{{ route('admin.service-process-steps.index') }}">Reset</a>
                </div>

            </form>
        </div>
    </div>

    @if($steps->count() === 0)
        <div class="amtex-empty">
            <div class="amtex-empty-card">
                <div class="amtex-badge">No Data</div>
                <h3>No steps found</h3>
                <p>Add steps like “Assess requirements”, “Define solutions”, etc.</p>

                @can('service_process_step_create')
                    <a class="btn amtex-btn mt-2" href="{{ route('admin.service-process-steps.create') }}">
                        Add First Step
                    </a>
                @endcan
            </div>
        </div>
    @else

        <div class="row g-3">
            @foreach($steps as $step)
                <div class="col-md-6 col-lg-4">
                    <div class="amtex-card h-100">

                        <div class="amtex-card-head d-flex justify-content-between align-items-center">
                            <div>
                                <div class="small text-muted">Step {{ str_pad((int)$step->step_no, 2, '0', STR_PAD_LEFT) }}</div>
                                <h4 class="mb-0">{{ $step->title }}</h4>
                            </div>

                            @if((string)$step->is_active === 'yes')
                                <span class="amtex-chip">Active</span>
                            @else
                                <span class="amtex-chip amtex-chip-warn">Inactive</span>
                            @endif
                        </div>

                        <div class="amtex-card-body">
                            <div class="text-muted" style="font-size: 13px;">
                                {{ \Illuminate\Support\Str::limit($step->description ?? '', 150) ?: '—' }}
                            </div>

                            <div class="small text-muted mt-2">
                                Sort: <strong>{{ $step->sort_order ?? 0 }}</strong>
                                <span class="mx-2">•</span>
                                Updated: <strong>{{ optional($step->updated_at)->format('d M Y') }}</strong>
                            </div>
                        </div>

                        <div class="amtex-card-footer d-flex justify-content-end gap-1">
                            @can('service_process_step_show')
                                <a href="{{ route('admin.service-process-steps.show', $step->id) }}" class="btn btn-sm btn-outline-secondary">View</a>
                            @endcan
                            @can('service_process_step_edit')
                                <a href="{{ route('admin.service-process-steps.edit', $step->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                            @endcan
                            @can('service_process_step_delete')
                                <form action="{{ route('admin.service-process-steps.destroy', $step->id) }}" method="POST"
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
            <div class="d-flex justify-content-center">
                {{ $steps->links() }}
            </div>
        </div>

    @endif

</div>

@endsection
