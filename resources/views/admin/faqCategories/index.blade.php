@extends('layouts.admin')

@section('content')
<div class="amtex-faqcat">

@can('faq_category_delete')
<form id="bulkDeleteForm" method="POST" action="{{ route('admin.faq-categories.massDestroy') }}" style="display:none;">
    @csrf
    <input type="hidden" name="_method" value="DELETE">
    <input type="hidden" name="ids" id="bulkDeleteIds" value="">
</form>
@endcan

<div class="bulkbar" id="bulkbar">
    <div class="bulk-left">
        <strong><span id="selectedCount">0</span> selected</strong>
        <span style="opacity:.8;">Bulk actions available</span>
    </div>
    <div class="bulk-right">
        <button type="button" class="btn btn-light btn-sm" id="clearSelection">Clear</button>

        @can('faq_category_delete')
            <button type="button" class="btn btn-danger btn-sm" id="bulkDeleteBtn">
                Delete Selected
            </button>
        @endcan
    </div>
</div>

<div class="card">
    <div class="card-header">
        {{ trans('cruds.faqCategory.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">

        <div class="fc-toolbar">
            <div class="left">
                @can('faq_category_create')
                    <a class="btn btn-success" href="{{ route('admin.faq-categories.create') }}">
                        {{ trans('global.add') }} {{ trans('cruds.faqCategory.title_singular') }}
                    </a>
                @endcan

                <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                    {{ trans('global.app_csvImport') }}
                </button>
                @include('csvImport.modal', ['model' => 'FaqCategory', 'route' => 'admin.faq-categories.parseCsvImport'])
            </div>

            <div class="right">
                <form method="GET" action="{{ route('admin.faq-categories.index') }}" class="fc-filters">
                    <div class="input-group" style="min-width:260px;">
                        <input
                            type="text"
                            name="q"
                            value="{{ $q ?? '' }}"
                            class="form-control"
                            placeholder="Search category name..."
                        >
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">Search</button>
                        </div>
                    </div>

                    <select name="status" class="form-control" onchange="this.form.submit()">
                        <option value="" {{ ($status ?? '') === '' ? 'selected' : '' }}>All Status</option>
                        <option value="active" {{ ($status ?? '') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ ($status ?? '') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>

                    <select name="sort" class="form-control" onchange="this.form.submit()">
                        <option value="sort_order_asc" {{ ($sort ?? '') === 'sort_order_asc' ? 'selected' : '' }}>Sort Order ↑</option>
                        <option value="sort_order_desc" {{ ($sort ?? '') === 'sort_order_desc' ? 'selected' : '' }}>Sort Order ↓</option>
                        <option value="newest" {{ ($sort ?? '') === 'newest' ? 'selected' : '' }}>Newest</option>
                        <option value="oldest" {{ ($sort ?? '') === 'oldest' ? 'selected' : '' }}>Oldest</option>
                        <option value="name_asc" {{ ($sort ?? '') === 'name_asc' ? 'selected' : '' }}>Name A→Z</option>
                        <option value="name_desc" {{ ($sort ?? '') === 'name_desc' ? 'selected' : '' }}>Name Z→A</option>
                    </select>

                    <select name="per_page" class="form-control" onchange="this.form.submit()">
                        <option value="12" {{ ($perPage ?? 12) == 12 ? 'selected' : '' }}>12 / page</option>
                        <option value="24" {{ ($perPage ?? 12) == 24 ? 'selected' : '' }}>24 / page</option>
                        <option value="48" {{ ($perPage ?? 12) == 48 ? 'selected' : '' }}>48 / page</option>
                    </select>

                    @if(($q ?? '') !== '' || ($status ?? '') !== '' || ($sort ?? '') !== 'sort_order_asc' || ($perPage ?? 12) != 12)
                        <a href="{{ route('admin.faq-categories.index') }}" class="btn btn-outline-secondary">
                            Reset
                        </a>
                    @endif
                </form>
            </div>
        </div>

        @if($faqCategories->count() === 0)
            <div class="alert alert-info mb-0">
                No FAQ categories found.
            </div>
        @else
            <div class="row">
                @foreach($faqCategories as $cat)
                    @php
                        $isActiveText = $cat->is_active ? (\App\Models\FaqCategory::IS_ACTIVE_SELECT[$cat->is_active] ?? 'Active') : 'Inactive';
                        $isActiveBool = (int) $cat->is_active === 1;
                    @endphp

                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="fc-card">
                            <div class="fc-card-top">
                                <div style="display:flex; gap:.65rem; align-items:flex-start;">
                                    <div>
                                        <input
                                            type="checkbox"
                                            class="fc-check"
                                            value="{{ $cat->id }}"
                                            style="margin-top:.15rem;"
                                        >
                                    </div>

                                    <div>
                                        <h5 class="fc-title">{{ $cat->name }}</h5>
                                        <div class="fc-meta">
                                            <span class="fc-badge">#{{ $cat->id }}</span>
                                            <span class="fc-badge">Sort: {{ $cat->sort_order ?? '-' }}</span>

                                            @if($isActiveBool)
                                                <span class="fc-badge active">● {{ $isActiveText }}</span>
                                            @else
                                                <span class="fc-badge inactive">● {{ $isActiveText }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="fc-actions dropdown">
                                    <button class="btn btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
                                        Actions
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        @can('faq_category_show')
                                            <a class="dropdown-item" href="{{ route('admin.faq-categories.show', $cat->id) }}">
                                                View
                                            </a>
                                        @endcan
                                        @can('faq_category_edit')
                                            <a class="dropdown-item" href="{{ route('admin.faq-categories.edit', $cat->id) }}">
                                                Edit
                                            </a>
                                        @endcan

                                        @can('faq_category_delete')
                                            <div class="dropdown-divider"></div>
                                            <form action="{{ route('admin.faq-categories.destroy', $cat->id) }}" method="POST"
                                                  onsubmit="return confirm('{{ trans('global.areYouSure') }}');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger">
                                                    Delete
                                                </button>
                                            </form>
                                        @endcan
                                    </div>
                                </div>
                            </div>

                            <div class="fc-card-body">
                                <div style="display:flex; justify-content:space-between; align-items:center; gap:.75rem;">
                                    <div style="color:#6b7280; font-size:.9rem;">
                                        Premium card layout (no tables)
                                    </div>

                                    @can('faq_category_edit')
                                        <a class="btn btn-outline-primary btn-sm" href="{{ route('admin.faq-categories.edit', $cat->id) }}">
                                            Quick Edit
                                        </a>
                                    @endcan
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="fc-pagination-wrap">
                <div style="color:#6b7280;">
                    Showing <strong>{{ $faqCategories->firstItem() }}</strong> to <strong>{{ $faqCategories->lastItem() }}</strong>
                    of <strong>{{ $faqCategories->total() }}</strong> results
                </div>

                <div>
                    {{ $faqCategories->links() }}
                </div>
            </div>
        @endif

    </div>
</div>

</div>
@endsection

@section('scripts')
@parent
<script>
(function () {
    const scope = document.querySelector('.amtex-faqcat');
    if (!scope) return;

    const checks = scope.querySelectorAll('.fc-check');
    const bulkbar = scope.querySelector('#bulkbar');
    const selectedCount = scope.querySelector('#selectedCount');
    const clearSelection = scope.querySelector('#clearSelection');

    const bulkDeleteBtn = scope.querySelector('#bulkDeleteBtn');
    const bulkDeleteForm = scope.querySelector('#bulkDeleteForm');
    const bulkDeleteIds = scope.querySelector('#bulkDeleteIds');

    function getSelectedIds() {
        return Array.from(checks).filter(c => c.checked).map(c => c.value);
    }

    function updateBulkUI() {
        const ids = getSelectedIds();
        if (selectedCount) selectedCount.textContent = ids.length;

        if (bulkbar) {
            bulkbar.style.display = ids.length > 0 ? 'flex' : 'none';
        }
    }

    checks.forEach(c => c.addEventListener('change', updateBulkUI));

    if (clearSelection) {
        clearSelection.addEventListener('click', function () {
            checks.forEach(c => c.checked = false);
            updateBulkUI();
        });
    }

    if (bulkDeleteBtn && bulkDeleteForm && bulkDeleteIds) {
        bulkDeleteBtn.addEventListener('click', function () {
            const ids = getSelectedIds();
            if (ids.length === 0) return;
            if (!confirm("{{ trans('global.areYouSure') }}")) return;

            bulkDeleteIds.value = JSON.stringify(ids);
            bulkDeleteForm.submit();
        });
    }

    updateBulkUI();
})();
</script>
@endsection
