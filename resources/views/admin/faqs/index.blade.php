@extends('layouts.admin')
@section('content')

<div class="amtex-faq">

@can('faq_delete')
<form id="bulkDeleteFormFaq" method="POST" action="{{ route('admin.faqs.massDestroy') }}" style="display:none;">
    @csrf
    <input type="hidden" name="_method" value="DELETE">
    <input type="hidden" name="ids" id="bulkDeleteIdsFaq" value="">
</form>
@endcan

<div class="bulkbar" id="bulkbarFaq">
    <div class="bulk-left">
        <strong><span id="selectedCountFaq">0</span> selected</strong>
        <span style="opacity:.8;">Bulk actions available</span>
    </div>
    <div class="bulk-right">
        <button type="button" class="btn btn-light btn-sm" id="clearSelectionFaq">Clear</button>

        @can('faq_delete')
            <button type="button" class="btn btn-danger btn-sm" id="bulkDeleteBtnFaq">
                Delete Selected
            </button>
        @endcan
    </div>
</div>

@can('faq_create')
    <div class="faq-toolbar">
        <div class="left">
            <a class="btn btn-success" href="{{ route('admin.faqs.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.faq.title_singular') }}
            </a>

            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'Faq', 'route' => 'admin.faqs.parseCsvImport'])
        </div>

        <div class="right">
            <form method="GET" action="{{ route('admin.faqs.index') }}" class="faq-filters">
                <div class="input-group" style="min-width:260px;">
                    <input
                        type="text"
                        name="q"
                        value="{{ $q ?? '' }}"
                        class="form-control"
                        placeholder="Search question..."
                    >
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">Search</button>
                    </div>
                </div>

                <select name="category_id" class="form-control" onchange="this.form.submit()">
                    <option value="">All Categories</option>
                    @foreach($categories as $c)
                        <option value="{{ $c->id }}" {{ (string)($cat ?? '') === (string)$c->id ? 'selected' : '' }}>
                            {{ $c->name }}
                        </option>
                    @endforeach
                </select>

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
                    <option value="question_asc" {{ ($sort ?? '') === 'question_asc' ? 'selected' : '' }}>Question A→Z</option>
                    <option value="question_desc" {{ ($sort ?? '') === 'question_desc' ? 'selected' : '' }}>Question Z→A</option>
                </select>

                <select name="per_page" class="form-control" onchange="this.form.submit()">
                    <option value="12" {{ ($perPage ?? 12) == 12 ? 'selected' : '' }}>12 / page</option>
                    <option value="24" {{ ($perPage ?? 12) == 24 ? 'selected' : '' }}>24 / page</option>
                    <option value="48" {{ ($perPage ?? 12) == 48 ? 'selected' : '' }}>48 / page</option>
                </select>

                @if(($q ?? '') !== '' || ($cat ?? '') !== '' || ($status ?? '') !== '' || ($sort ?? '') !== 'sort_order_asc' || ($perPage ?? 12) != 12)
                    <a href="{{ route('admin.faqs.index') }}" class="btn btn-outline-secondary">
                        Reset
                    </a>
                @endif
            </form>
        </div>
    </div>
@endcan

<div class="card">
    <div class="card-header">
        {{ trans('cruds.faq.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        @if($faqs->count() === 0)
            <div class="alert alert-info mb-0">
                No FAQs found.
            </div>
        @else
            <div class="row">
                @foreach($faqs as $faq)
                    @php
                        $catName = optional($faq->select_category)->name ?: '-';
                        $isActiveText = $faq->is_active ? (\App\Models\Faq::IS_ACTIVE_SELECT[$faq->is_active] ?? 'Active') : 'Inactive';
                        $isActiveBool = (int) $faq->is_active === 1;
                        $qText = strip_tags($faq->question ?? '');
                    @endphp

                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="faq-card">
                            <div class="faq-card-top">
                                <div style="display:flex; gap:.65rem; align-items:flex-start;">
                                    <div>
                                        <input
                                            type="checkbox"
                                            class="faq-check"
                                            value="{{ $faq->id }}"
                                            style="margin-top:.15rem;"
                                        >
                                    </div>

                                    <div>
                                        <h5 class="faq-title">{{ $qText }}</h5>

                                        <div class="faq-meta">
                                            <span class="faq-badge">#{{ $faq->id }}</span>
                                            <span class="faq-badge">{{ $catName }}</span>
                                            <span class="faq-badge">Sort: {{ $faq->sort_order ?? '-' }}</span>

                                            @if($isActiveBool)
                                                <span class="faq-badge active">● {{ $isActiveText }}</span>
                                            @else
                                                <span class="faq-badge inactive">● {{ $isActiveText }}</span>
                                            @endif
                                        </div>

                                        <div class="faq-snippet">
                                            {{ \Illuminate\Support\Str::limit($qText, 120) }}
                                        </div>
                                    </div>
                                </div>

                                <div class="faq-actions dropdown">
                                    <button class="btn btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
                                        Actions
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        @can('faq_show')
                                            <a class="dropdown-item" href="{{ route('admin.faqs.show', $faq->id) }}">
                                                View
                                            </a>
                                        @endcan

                                        @can('faq_edit')
                                            <a class="dropdown-item" href="{{ route('admin.faqs.edit', $faq->id) }}">
                                                Edit
                                            </a>
                                        @endcan

                                        @can('faq_delete')
                                            <div class="dropdown-divider"></div>
                                            <form action="{{ route('admin.faqs.destroy', $faq->id) }}" method="POST"
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

                            <div class="faq-card-body">
                                <div style="display:flex; justify-content:space-between; align-items:center; gap:.75rem;">
                                    <div style="color:#6b7280; font-size:.9rem;">
                                        Category: <strong>{{ $catName }}</strong>
                                    </div>

                                    @can('faq_edit')
                                        <a class="btn btn-outline-primary btn-sm" href="{{ route('admin.faqs.edit', $faq->id) }}">
                                            Quick Edit
                                        </a>
                                    @endcan
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="faq-pagination-wrap">
                <div style="color:#6b7280;">
                    Showing <strong>{{ $faqs->firstItem() }}</strong> to <strong>{{ $faqs->lastItem() }}</strong>
                    of <strong>{{ $faqs->total() }}</strong> results
                </div>

                <div>
                    {{ $faqs->links() }}
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
    const scope = document.querySelector('.amtex-faq');
    if (!scope) return;

    const checks = scope.querySelectorAll('.faq-check');
    const bulkbar = scope.querySelector('#bulkbarFaq');
    const selectedCount = scope.querySelector('#selectedCountFaq');
    const clearSelection = scope.querySelector('#clearSelectionFaq');

    const bulkDeleteBtn = scope.querySelector('#bulkDeleteBtnFaq');
    const bulkDeleteForm = scope.querySelector('#bulkDeleteFormFaq');
    const bulkDeleteIds = scope.querySelector('#bulkDeleteIdsFaq');

    function getSelectedIds() {
        return Array.from(checks).filter(c => c.checked).map(c => c.value);
    }

    function updateBulkUI() {
        const ids = getSelectedIds();
        if (selectedCount) selectedCount.textContent = ids.length;
        if (bulkbar) bulkbar.style.display = ids.length > 0 ? 'flex' : 'none';
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
