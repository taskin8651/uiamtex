@extends('layouts.admin')
@section('content')

<div class="amtex-page">

    {{-- Header --}}
    <div class="amtex-header">
        <div>
            <h2 class="amtex-title">{{ trans('cruds.download.title') ?? 'Downloads' }}</h2>
            <p class="amtex-subtitle">Manage downloadable PDFs/docs, visibility and sorting.</p>
        </div>

        <div class="amtex-actions d-flex flex-wrap gap-2">

            @if(session('message'))
                <div class="amtex-alert">{{ session('message') }}</div>
            @endif

            @can('download_create')
                <a class="btn amtex-btn" href="{{ route('admin.downloads.create') }}">
                    <i class="fas fa-plus"></i> Add Download
                </a>

                <button class="btn amtex-btn-outline" data-toggle="modal" data-target="#csvImportModal">
                    <i class="fas fa-file-upload"></i> CSV Import
                </button>

                @include('csvImport.modal', ['model' => 'Download', 'route' => 'admin.downloads.parseCsvImport'])
            @endcan

        </div>
    </div>

    {{-- Filters --}}
    <div class="amtex-card mb-3">
        <div class="amtex-card-head">
            <h4 class="mb-0">Filters</h4>
        </div>

        <div class="amtex-card-body">
            <form method="GET" action="{{ route('admin.downloads.index') }}" class="row g-2 align-items-end">

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
                    @php $sort = $filters['sort'] ?? 'id'; @endphp
                    <select name="sort" class="form-control">
                        <option value="id" {{ $sort === 'id' ? 'selected' : '' }}>ID</option>
                        <option value="title" {{ $sort === 'title' ? 'selected' : '' }}>Title</option>
                        <option value="is_active" {{ $sort === 'is_active' ? 'selected' : '' }}>Status</option>
                        <option value="updated_at" {{ $sort === 'updated_at' ? 'selected' : '' }}>Updated</option>
                        <option value="created_at" {{ $sort === 'created_at' ? 'selected' : '' }}>Created</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="amtex-label">Direction</label>
                    @php $dir = $filters['dir'] ?? 'desc'; @endphp
                    <select name="dir" class="form-control">
                        <option value="asc" {{ $dir === 'asc' ? 'selected' : '' }}>ASC</option>
                        <option value="desc" {{ $dir === 'desc' ? 'selected' : '' }}>DESC</option>
                    </select>
                </div>

                <div class="col-12 d-flex gap-2 mt-1">
                    <button class="btn btn-danger" type="submit">Apply</button>
                    <a class="btn btn-light" href="{{ route('admin.downloads.index') }}">Reset</a>
                </div>

            </form>
        </div>
    </div>

    {{-- Empty State --}}
    @if($downloads->count() === 0)
        <div class="amtex-empty">
            <div class="amtex-empty-card">
                <div class="amtex-badge">No Data</div>
                <h3>No downloads found</h3>
                <p>Add brochure/company profile/other documents for frontend download section.</p>

                @can('download_create')
                    <a class="btn amtex-btn mt-2" href="{{ route('admin.downloads.create') }}">
                        Add First Download
                    </a>
                @endcan
            </div>
        </div>
    @else

        {{-- Grid --}}
        <div class="row g-3">
            @foreach($downloads as $download)
                <div class="col-md-6 col-lg-4">
                    <div class="amtex-card h-100">

                        <div class="amtex-card-head d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">
                                {{ $download->title ?? 'Download' }}
                            </h4>

                            @if((string)$download->is_active === 'yes')
                                <span class="amtex-chip">Active</span>
                            @else
                                <span class="amtex-chip amtex-chip-warn">Inactive</span>
                            @endif
                        </div>

                        <div class="amtex-card-body">

                            <div class="small text-muted">
                                ID: <strong>#{{ $download->id }}</strong>
                            </div>

                            <div class="small text-muted mt-1">
                                Updated: <strong>{{ optional($download->updated_at)->format('d M Y') }}</strong>
                            </div>

                            <div class="mt-3">
                                @if($download->file)
                                    <a class="btn btn-sm btn-outline-dark" href="{{ $download->file->getUrl() }}" target="_blank" rel="noopener">
                                        <i class="fas fa-file-download"></i> Open File
                                    </a>
                                @else
                                    <div class="amtex-muted">No file uploaded</div>
                                @endif
                            </div>

                        </div>

                        {{-- Actions --}}
                        <div class="amtex-card-footer d-flex justify-content-end gap-1">

                            @can('download_show')
                                <a href="{{ route('admin.downloads.show', $download->id) }}" class="btn btn-sm btn-outline-secondary">
                                    View
                                </a>
                            @endcan

                            @can('download_edit')
                                <a href="{{ route('admin.downloads.edit', $download->id) }}" class="btn btn-sm btn-outline-primary">
                                    Edit
                                </a>
                            @endcan

                            @can('download_delete')
                                <form
                                    action="{{ route('admin.downloads.destroy', $download->id) }}"
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
            {{ $downloads->links() }}
        </div>

    @endif

</div>

@endsection
