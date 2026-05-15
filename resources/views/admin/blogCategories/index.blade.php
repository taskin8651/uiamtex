@extends('layouts.admin')
@section('content')

@can('blog_category_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.blog-categories.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.blogCategory.title_singular') }}
            </a>
            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'BlogCategory', 'route' => 'admin.blog-categories.parseCsvImport'])
        </div>
    </div>
@endcan

<div class="card">
    <div class="card-header">
        {{ trans('cruds.blogCategory.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body amtex-premium-bcat-wrap">

        {{-- Premium Header (search + stats) --}}
        <div class="amtex-premium-bcat-topbar">
            <div class="amtex-premium-bcat-titlebox">
                <div class="amtex-premium-bcat-title">{{ trans('cruds.blogCategory.title') ?? 'Blog Categories' }}</div>
                <div class="amtex-premium-bcat-subtitle">Manage categories, status, and quick actions.</div>
            </div>

            <div class="amtex-premium-bcat-controls">
                <div class="amtex-premium-bcat-search">
                    <span class="amtex-premium-bcat-search-ico">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" id="amtexBcatSearch" placeholder="Search categories..." autocomplete="off">
                </div>

                <div class="amtex-premium-bcat-meta">
                    <div class="amtex-premium-bcat-pill">
                        Total: <span id="amtexBcatTotal">0</span>
                    </div>
                    <div class="amtex-premium-bcat-pill amtex-premium-bcat-pill-active">
                        Active: <span id="amtexBcatActive">0</span>
                    </div>
                    <div class="amtex-premium-bcat-pill amtex-premium-bcat-pill-inactive">
                        Inactive: <span id="amtexBcatInactive">0</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Cards Grid (DataTable will render into this) --}}
        <div id="amtexBcatGrid" class="amtex-premium-bcat-grid"></div>

        {{-- Hidden DataTable (kept for server-side + permissions + existing actions partial) --}}
        <div class="amtex-premium-bcat-hidden-table">
            <table class="table table-bordered table-striped table-hover ajaxTable datatable datatable-BlogCategory">
                <thead>
                    <tr>
                        <th width="10"></th>
                        <th>{{ trans('cruds.blogCategory.fields.id') }}</th>
                        <th>{{ trans('cruds.blogCategory.fields.name') }}</th>
                        <th>{{ trans('cruds.blogCategory.fields.slug') }}</th>
                        <th>{{ trans('cruds.blogCategory.fields.is_active') }}</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
            </table>
        </div>

    </div>
</div>

@endsection

@section('scripts')
@parent
<script>
$(function () {

    let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)

@can('blog_category_delete')
    let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
    let deleteButton = {
        text: deleteButtonTrans,
        url: "{{ route('admin.blog-categories.massDestroy') }}",
        className: 'btn-danger',
        action: function (e, dt, node, config) {
            var ids = $.map(dt.rows({ selected: true }).data(), function (entry) {
                return entry.id
            });

            if (ids.length === 0) {
                alert('{{ trans('global.datatables.zero_selected') }}')
                return
            }

            if (confirm('{{ trans('global.areYouSure') }}')) {
                $.ajax({
                    headers: {'x-csrf-token': _token},
                    method: 'POST',
                    url: config.url,
                    data: { ids: ids, _method: 'DELETE' }
                }).done(function () { location.reload() })
            }
        }
    }
    dtButtons.push(deleteButton)
@endcan

    // Robust status classifier:
    // Your controller returns the *label* string for is_active (not the raw key).
    // In your project, raw keys seem to be 'yes'/'no' (create blade default old('is_active','yes')).
    // So label could be: "Yes/No", "Active/Inactive", "Enabled/Disabled", etc.
    function amtexIsActiveFromLabel(label) {
        const lower = (label || '').toString().trim().toLowerCase();

        // Exact matches first (most reliable)
        const ACTIVE_SET = new Set(['yes', 'active', 'enabled', 'enable', 'true', '1', 'on']);
        const INACTIVE_SET = new Set(['no', 'inactive', 'disabled', 'disable', 'false', '0', 'off']);

        if (ACTIVE_SET.has(lower)) return true;
        if (INACTIVE_SET.has(lower)) return false;

        // Then handle phrases safely
        // IMPORTANT: "inactive" contains "active" so check inactive first
        if (lower.includes('inactive') || lower.includes('disable') || lower.includes('false')) return false;
        if (lower.includes('active') || lower.includes('enable') || lower.includes('true')) return true;

        // Fallback: treat unknown as inactive (safer)
        return false;
    }

    let dtOverrideGlobals = {
        buttons: dtButtons,
        processing: true,
        serverSide: true,
        retrieve: true,
        aaSorting: [],
        ajax: "{{ route('admin.blog-categories.index') }}",
        columns: [
            { data: 'placeholder', name: 'placeholder' },
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'slug', name: 'slug' },
            { data: 'is_active', name: 'is_active' },
            { data: 'actions', name: '{{ trans('global.actions') }}' }
        ],
        orderCellsTop: true,
        order: [[ 1, 'desc' ]],
        pageLength: 100,

        // Render Premium Cards
        drawCallback: function(settings) {
            const api = this.api();
            const rows = api.rows({page:'current'}).data().toArray();

            let activeCount = 0;
            let inactiveCount = 0;

            let html = '';

            if (!rows.length) {
                html = `
                    <div class="amtex-premium-bcat-empty">
                        <div class="amtex-premium-bcat-empty-icon"><i class="far fa-folder-open"></i></div>
                        <div class="amtex-premium-bcat-empty-title">No categories found</div>
                        <div class="amtex-premium-bcat-empty-sub">Try adjusting search or add a new category.</div>
                    </div>
                `;
            } else {
                rows.forEach(function(row){
                    const isActiveText = (row.is_active || '').toString().trim();
                    const isActive = amtexIsActiveFromLabel(isActiveText);

                    if (isActive) activeCount++; else inactiveCount++;

                    const badgeClass = isActive ? 'amtex-premium-bcat-badge--active' : 'amtex-premium-bcat-badge--inactive';
                    const statusDotClass = isActive ? 'amtex-premium-bcat-dot--active' : 'amtex-premium-bcat-dot--inactive';

                    html += `
                        <div class="amtex-premium-bcat-card">
                            <div class="amtex-premium-bcat-card-top">
                                <div class="amtex-premium-bcat-id">#${row.id ?? ''}</div>
                                <div class="amtex-premium-bcat-badge ${badgeClass}">
                                    <span class="amtex-premium-bcat-dot ${statusDotClass}"></span>
                                    ${isActiveText || '-'}
                                </div>
                            </div>

                            <div class="amtex-premium-bcat-name">
                                ${(row.name ?? '').toString()}
                            </div>

                            <div class="amtex-premium-bcat-slug">
                                <span class="amtex-premium-bcat-slug-label">Slug</span>
                                <span class="amtex-premium-bcat-slug-value">${(row.slug ?? '').toString()}</span>
                            </div>

                            <div class="amtex-premium-bcat-actions">
                                <div class="amtex-premium-bcat-actions-inner">
                                    ${row.actions ?? ''}
                                </div>
                            </div>
                        </div>
                    `;
                });
            }

            $('#amtexBcatGrid').html(html);

            // Stats (server-side => per page stats; still useful)
            $('#amtexBcatTotal').text(rows.length);
            $('#amtexBcatActive').text(activeCount);
            $('#amtexBcatInactive').text(inactiveCount);

            // Make action buttons premium only inside this module
            $('#amtexBcatGrid .amtex-premium-bcat-actions-inner a.btn').addClass('amtex-premium-bcat-btnfix');
            $('#amtexBcatGrid .amtex-premium-bcat-actions-inner form button.btn').addClass('amtex-premium-bcat-btnfix');
        }
    };

    let table = $('.datatable-BlogCategory').DataTable(dtOverrideGlobals);

    // Premium search box => datatable global search
    $('#amtexBcatSearch').on('input', function () {
        table.search(this.value).draw();
    });

    $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
        $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
    });

});
</script>
@endsection
