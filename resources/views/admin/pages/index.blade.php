@extends('layouts.admin')
@section('content')

@can('page_create')
<div style="margin-bottom: 10px;" class="row">
    <div class="col-lg-12 d-flex gap-2 flex-wrap">
        <a class="btn btn-success" href="{{ route('admin.pages.create') }}">
            {{ trans('global.add') }} {{ trans('cruds.page.title_singular') }}
        </a>

        <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
            {{ trans('global.app_csvImport') }}
        </button>
        @include('csvImport.modal', ['model' => 'Page', 'route' => 'admin.pages.parseCsvImport'])
    </div>
</div>
@endcan

<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
        <div>
            <strong>{{ trans('cruds.page.title_singular') }} {{ trans('global.list') }}</strong>
            <div class="text-muted small mt-1">Browse, search, filter, and manage pages in a readable format.</div>
        </div>

        <div class="d-flex align-items-center gap-2 flex-wrap">
            <div class="badge badge-light p-2">
                Total on this page: {{ $pages->count() }}
            </div>
            <div class="badge badge-light p-2">
                Total results: {{ $pages->total() }}
            </div>
        </div>
    </div>

    <div class="card-body">

        {{-- Filters --}}
        <form method="GET" action="{{ route('admin.pages.index') }}" class="page-filter-bar mb-3">
            <div class="row g-2">
                <div class="col-12 col-md-5">
                    <label class="mb-1 small text-muted">Search</label>
                    <input
                        type="text"
                        name="q"
                        value="{{ $filters['q'] ?? '' }}"
                        class="form-control"
                        placeholder="Search by title, slug, or SEO title..."
                    />
                </div>

                <div class="col-12 col-md-3">
                    <label class="mb-1 small text-muted">Status</label>
                    <select name="status" class="form-control">
                        <option value="">All</option>
                        @foreach($isActiveOptions as $key => $label)
                            <option value="{{ $key }}" {{ ($filters['status'] ?? '') === (string)$key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12 col-md-3">
                    <label class="mb-1 small text-muted">Sort</label>
                    <div class="d-flex gap-2">
                        <select name="sort" class="form-control">
                            <option value="id" {{ ($filters['sort'] ?? '') === 'id' ? 'selected' : '' }}>ID</option>
                            <option value="title" {{ ($filters['sort'] ?? '') === 'title' ? 'selected' : '' }}>Title</option>
                            <option value="slug" {{ ($filters['sort'] ?? '') === 'slug' ? 'selected' : '' }}>Slug</option>
                            <option value="seo_title" {{ ($filters['sort'] ?? '') === 'seo_title' ? 'selected' : '' }}>SEO Title</option>
                            <option value="is_active" {{ ($filters['sort'] ?? '') === 'is_active' ? 'selected' : '' }}>Status</option>
                            <option value="created_at" {{ ($filters['sort'] ?? '') === 'created_at' ? 'selected' : '' }}>Created</option>
                            <option value="updated_at" {{ ($filters['sort'] ?? '') === 'updated_at' ? 'selected' : '' }}>Updated</option>
                        </select>

                        <select name="dir" class="form-control" style="max-width: 130px;">
                            <option value="desc" {{ ($filters['dir'] ?? '') === 'desc' ? 'selected' : '' }}>Desc</option>
                            <option value="asc" {{ ($filters['dir'] ?? '') === 'asc' ? 'selected' : '' }}>Asc</option>
                        </select>
                    </div>
                </div>

                <div class="col-12 col-md-1 d-flex align-items-end">
                    <button class="btn btn-primary w-100" type="submit">Apply</button>
                </div>

                <div class="col-12 d-flex justify-content-between align-items-center mt-2">
                    <div class="small text-muted">
                        Tip: Keep slugs consistent for SEO and routing stability.
                    </div>
                    <div>
                        <a href="{{ route('admin.pages.index') }}" class="btn btn-link p-0">Reset</a>
                    </div>
                </div>
            </div>
        </form>

        {{-- Cards --}}
        @if($pages->count() === 0)
            <div class="alert alert-info mb-0">
                No pages found matching your filters.
            </div>
        @else
            <div class="row">
                @foreach($pages as $page)
                    <div class="col-12 col-md-6 col-xl-4 mb-3">
                        <div class="page-card card h-100">
                            <div class="card-body d-flex flex-column">
                                <div class="d-flex justify-content-between align-items-start gap-2">
                                    <div class="page-title-wrap">
                                        <div class="page-title text-truncate" title="{{ $page->title }}">
                                            {{ $page->title }}
                                        </div>
                                        <div class="page-meta text-muted small mt-1">
                                            <span class="mr-2">#{{ $page->id }}</span>
                                            <span class="mr-2">Slug:</span>
                                            <span class="font-monospace" title="{{ $page->slug }}">
                                                {{ $page->slug }}
                                            </span>
                                        </div>
                                    </div>

                                    @php
                                        $statusKey = $page->is_active;
                                        $statusLabel = $isActiveOptions[$statusKey] ?? $statusKey;
                                        $isActive = in_array(strtolower((string)$statusLabel), ['active', 'enabled', 'yes', '1'], true)
                                                    || (string)$statusKey === '1';
                                    @endphp

                                    <span class="badge {{ $isActive ? 'badge-success' : 'badge-secondary' }} badge-pill">
                                        {{ $statusLabel }}
                                    </span>
                                </div>

                                <hr class="my-3">

                                <div class="mb-3">
                                    <div class="small text-muted mb-1">SEO Title</div>
                                    <div class="text-truncate" title="{{ $page->seo_title }}">
                                        {{ $page->seo_title ?: '—' }}
                                    </div>
                                </div>

                                <div class="mt-auto d-flex justify-content-between align-items-center flex-wrap gap-2">
                                    <div class="small text-muted">
                                        Updated: {{ optional($page->updated_at)->format('d M Y, h:i A') }}
                                    </div>

                                    <div class="btn-group">
                                        @can('page_show')
                                            <a class="btn btn-sm btn-primary" href="{{ route('admin.pages.show', $page->id) }}">
                                                {{ trans('global.view') }}
                                            </a>
                                        @endcan

                                        @can('page_edit')
                                            <a class="btn btn-sm btn-info" href="{{ route('admin.pages.edit', $page->id) }}">
                                                {{ trans('global.edit') }}
                                            </a>
                                        @endcan

                                        @can('page_delete')
                                            <form action="{{ route('admin.pages.destroy', $page->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display:inline;">
                                                @method('DELETE')
                                                @csrf
                                                <button class="btn btn-sm btn-danger" type="submit">
                                                    {{ trans('global.delete') }}
                                                </button>
                                            </form>
                                        @endcan
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap gap-2">
                <div class="small text-muted">
                    Showing {{ $pages->firstItem() }} to {{ $pages->lastItem() }} of {{ $pages->total() }} results
                </div>
                <div>
                    {{ $pages->links() }}
                </div>
            </div>
        @endif

    </div>
</div>

@endsection

@section('styles')
@parent
<style>
    .page-filter-bar .form-control { height: calc(1.5em + .75rem + 6px); }
    .page-card { border: 1px solid rgba(0,0,0,.08); transition: transform .12s ease, box-shadow .12s ease; }
    .page-card:hover { transform: translateY(-2px); box-shadow: 0 10px 24px rgba(0,0,0,.08); }
    .page-title { font-weight: 700; font-size: 1.05rem; line-height: 1.2; }
    .page-meta .font-monospace { font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace; }
    .page-title-wrap { min-width: 0; }
</style>
@endsection
