@extends('layouts.admin')
@section('content')

<div class="amtex-page">

    <div class="amtex-header">
        <div>
            <h2 class="amtex-title">Testimonials</h2>
            <p class="amtex-subtitle">Manage testimonials (name, designation, photo and review).</p>
        </div>

        <div class="amtex-actions d-flex flex-wrap gap-2">
            @if(session('message'))
                <div class="amtex-alert">{{ session('message') }}</div>
            @endif

            @can('testimonial_create')
                <a class="btn amtex-btn" href="{{ route('admin.testimonials.create') }}">
                    <i class="fas fa-plus"></i> Add Testimonial
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
            <form method="GET" action="{{ route('admin.testimonials.index') }}" class="row g-2 align-items-end">

                <div class="col-md-5">
                    <label class="amtex-label">Search</label>
                    <input type="text" name="q" value="{{ $filters['q'] ?? '' }}" class="form-control"
                           placeholder="Search by name, designation, review or ID" />
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
                    <a class="btn btn-light" href="{{ route('admin.testimonials.index') }}">Reset</a>
                </div>

            </form>
        </div>
    </div>

    @if($testimonials->count() === 0)
        <div class="amtex-empty">
            <div class="amtex-empty-card">
                <div class="amtex-badge">No Data</div>
                <h3>No testimonials found</h3>
                <p>Add testimonials to show on your website.</p>
                @can('testimonial_create')
                    <a class="btn amtex-btn mt-2" href="{{ route('admin.testimonials.create') }}">Add First Testimonial</a>
                @endcan
            </div>
        </div>
    @else

        <div class="row g-3">
            @foreach($testimonials as $t)
                <div class="col-md-6 col-lg-4">
                    <div class="amtex-card h-100">

                        <div class="amtex-card-head d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">{{ $t->name }}</h4>
                            @if((string)$t->is_active === 'yes')
                                <span class="amtex-chip">Active</span>
                            @else
                                <span class="amtex-chip amtex-chip-warn">Inactive</span>
                            @endif
                        </div>

                        <div class="amtex-card-body">
                            <div class="d-flex gap-2 align-items-center mb-2">
                                @if($t->photo)
                                    <img src="{{ $t->photo->preview }}" alt="{{ $t->name }}"
                                         style="width:52px;height:52px;border-radius:999px;object-fit:cover;border:1px solid rgba(0,0,0,.08);" />
                                @else
                                    <div style="width:52px;height:52px;border-radius:999px;display:flex;align-items:center;justify-content:center;border:1px dashed rgba(0,0,0,.2);opacity:.7;">
                                        <i class="fas fa-user"></i>
                                    </div>
                                @endif

                                <div>
                                    <div class="small text-muted">Designation</div>
                                    <div class="fw-semibold">{{ $t->company_designation ?? '-' }}</div>
                                </div>
                            </div>

                            <div class="small text-muted">Review</div>
                            <div style="opacity:.9;">
                                {{ \Illuminate\Support\Str::limit(strip_tags($t->review), 140) }}
                            </div>

                            <div class="small text-muted mt-2">
                                Sort Order: <strong>{{ $t->sort_order ?? 0 }}</strong> • ID: <strong>#{{ $t->id }}</strong>
                            </div>

                            <div class="small text-muted mt-1">
                                Updated: <strong>{{ optional($t->updated_at)->format('d M Y') }}</strong>
                            </div>
                        </div>

                        <div class="amtex-card-footer d-flex justify-content-end gap-1">
                            @can('testimonial_show')
                                <a href="{{ route('admin.testimonials.show', $t->id) }}" class="btn btn-sm btn-outline-secondary">View</a>
                            @endcan

                            @can('testimonial_edit')
                                <a href="{{ route('admin.testimonials.edit', $t->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                            @endcan

                            @can('testimonial_delete')
                                <form action="{{ route('admin.testimonials.destroy', $t->id) }}" method="POST"
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
            {{ $testimonials->onEachSide(1)->links() }}
        </div>

    @endif

</div>

@endsection
