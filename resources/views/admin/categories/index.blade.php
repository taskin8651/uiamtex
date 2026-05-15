@extends('layouts.admin')
@section('content')

<div class="amtex-cat-page">

    {{-- Top Header --}}
    <div class="amtex-cat-top">
        <div class="amtex-cat-top-left">
            <div class="amtex-cat-kicker">Catalog</div>
            <h2 class="amtex-cat-title">{{ trans('cruds.category.title') }}</h2>
            <p class="amtex-cat-subtitle">
                Manage product categories with fast filters, clean cards, and quick actions.
            </p>
        </div>

        <div class="amtex-cat-top-right">
            @can('category_create')
                <a class="btn amtex-cat-btn amtex-cat-btn-primary" href="{{ route('admin.categories.create') }}">
                    <i class="fas fa-plus"></i>
                    {{ trans('global.add') }} {{ trans('cruds.category.title_singular') }}
                </a>

                <button class="btn amtex-cat-btn amtex-cat-btn-ghost" data-toggle="modal" data-target="#csvImportModal">
                    <i class="fas fa-file-csv"></i>
                    {{ trans('global.app_csvImport') }}
                </button>

                @include('csvImport.modal', ['model' => 'Category', 'route' => 'admin.categories.parseCsvImport'])
            @endcan
        </div>
    </div>

    {{-- Toolbar --}}
    <div class="amtex-cat-toolbar">
        <div class="amtex-cat-searchbox">
            <i class="fas fa-search amtex-cat-searchicon"></i>
            <input id="amtexCatSearch" type="text" class="amtex-cat-searchinput"
                placeholder="Search by name or slug..." autocomplete="off" />
        </div>

        <div class="amtex-cat-filters">
            <select id="amtexCatStatus" class="amtex-cat-select">
                <option value="">All Status</option>
                <option value="1">Active</option>
                <option value="0">Inactive</option>
            </select>

            <select id="amtexCatSort" class="amtex-cat-select">
                <option value="desc">Newest First</option>
                <option value="asc">Oldest First</option>
            </select>
        </div>
    </div>

    {{-- KPI mini bar --}}
    <div class="amtex-cat-kpis">
        <div class="amtex-cat-kpi">
            <div class="amtex-cat-kpi-label">Showing</div>
            <div class="amtex-cat-kpi-value" id="amtexCatKpiShowing">0</div>
        </div>
        <div class="amtex-cat-kpi">
            <div class="amtex-cat-kpi-label">Page</div>
            <div class="amtex-cat-kpi-value" id="amtexCatKpiPage">1</div>
        </div>
        <div class="amtex-cat-kpi">
            <div class="amtex-cat-kpi-label">Status</div>
            <div class="amtex-cat-kpi-value" id="amtexCatKpiStatus">All</div>
        </div>
    </div>

    {{-- Grid --}}
    <div id="amtexCatGrid" class="amtex-cat-grid"></div>

    {{-- Empty --}}
    <div id="amtexCatEmpty" class="amtex-cat-empty" style="display:none;">
        <div class="amtex-cat-empty-card">
            <div class="amtex-cat-empty-ico">
                <i class="fas fa-layer-group"></i>
            </div>
            <h3>No categories found</h3>
            <p>Try changing your search, status, or sort order.</p>
        </div>
    </div>

    {{-- Pagination --}}
    <div class="amtex-cat-pager">
        <div id="amtexCatInfo" class="amtex-cat-info"></div>
        <div id="amtexCatPaginate" class="amtex-cat-paginate"></div>
    </div>

    {{-- Hidden DataTable --}}
    <div class="amtex-cat-hidden">
        <table class="table ajaxTable datatable datatable-Category" id="amtexCatTable">
            <thead>
                <tr>
                    <th></th>
                    <th>{{ trans('cruds.category.fields.id') }}</th>
                    <th>{{ trans('cruds.category.fields.name') }}</th>
                    <th>{{ trans('cruds.category.fields.slug') }}</th>
                    <th>{{ trans('cruds.category.fields.image') }}</th>
                    <th>{{ trans('cruds.category.fields.sort_order') }}</th>
                    <th>{{ trans('cruds.category.fields.is_active') }}</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
        </table>
    </div>

</div>

@endsection

@section('scripts')
@parent
<script>
$(function () {

    let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons);

    let dtOverrideGlobals = {
        buttons: dtButtons,
        processing: true,
        serverSide: true,
        retrieve: true,
        aaSorting: [],
        ajax: {
            url: "{{ route('admin.categories.index') }}",
            data: function (d) {
                d.amtex_status = $('#amtexCatStatus').val() ?? '';
            }
        },
        columns: [
            { data: 'placeholder', name: 'placeholder' },
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'slug', name: 'slug' },
            { data: 'image', name: 'image', sortable: false, searchable: false },
            { data: 'sort_order', name: 'sort_order' },
            { data: 'is_active', name: 'is_active' },
            { data: 'actions', name: '{{ trans('global.actions') }}' }
        ],
        orderCellsTop: true,
        order: [[ 1, 'desc' ]],
        pageLength: 12,
        dom: 'rtip'
    };

    let table = $('#amtexCatTable').DataTable(dtOverrideGlobals);

    function extractBestImageUrl(html) {
        if (!html) return null;
        try {
            const div = document.createElement('div');
            div.innerHTML = html;

            const a = div.querySelector('a');
            const href = a ? a.getAttribute('href') : null;
            if (href && href !== '#' && href !== 'javascript:void(0)') return href;

            const img = div.querySelector('img');
            const src = img ? img.getAttribute('src') : null;
            return src || null;
        } catch (e) {
            return null;
        }
    }

    function cleanText(val) {
        if (val === null || val === undefined) return '-';
        return String(val);
    }

    function isActiveFromText(val) {
        const s = String(val || '').toLowerCase();
        return s.includes('active') && !s.includes('inactive');
    }

    function renderCards() {
        const grid = $('#amtexCatGrid');
        const empty = $('#amtexCatEmpty');

        grid.html('');

        const data = table.rows({ page: 'current' }).data().toArray();

        // KPIs
        $('#amtexCatKpiShowing').text(data.length);
        const pageInfo = table.page.info();
        $('#amtexCatKpiPage').text((pageInfo.page + 1) + ' / ' + pageInfo.pages);
        const statusVal = $('#amtexCatStatus').val();
        $('#amtexCatKpiStatus').text(statusVal === '' ? 'All' : (statusVal === '1' ? 'Active' : 'Inactive'));

        if (!data.length) {
            empty.show();
            $('#amtexCatInfo').html('');
            $('#amtexCatPaginate').html('');
            return;
        }

        empty.hide();

        data.forEach(row => {
            const bestImg = extractBestImageUrl(row.image);

            const imgHtml = bestImg
                ? `<img src="${bestImg}" alt="${cleanText(row.name)}" loading="lazy" />`
                : `<div class="amtex-cat-img-fallback"><span>No Image</span></div>`;

            const activeText = isActiveFromText(row.is_active) ? 'Active' : 'Inactive';
            const activeClass = activeText === 'Active' ? 'amtex-cat-badge-active' : 'amtex-cat-badge-inactive';

            const actionsHtml = row.actions ? `
                <div class="amtex-cat-actions-inner">
                    ${row.actions}
                </div>
            ` : '';

            const card = `
                <div class="amtex-cat-card">
                    <div class="amtex-cat-card-top">
                        <div class="amtex-cat-img">${imgHtml}</div>

                        <div class="amtex-cat-badges">
                            <span class="amtex-cat-badge ${activeClass}">${activeText}</span>
                            <span class="amtex-cat-badge amtex-cat-badge-soft">#${cleanText(row.id)}</span>
                        </div>
                    </div>

                    <div class="amtex-cat-card-body">
                        <div class="amtex-cat-name" title="${cleanText(row.name)}">${cleanText(row.name)}</div>

                        <div class="amtex-cat-meta">
                            <div class="amtex-cat-meta-row">
                                <span class="amtex-cat-meta-label">Slug</span>
                                <span class="amtex-cat-meta-value" title="${cleanText(row.slug)}">${cleanText(row.slug)}</span>
                            </div>
                            <div class="amtex-cat-meta-row">
                                <span class="amtex-cat-meta-label">Sort</span>
                                <span class="amtex-cat-meta-value">${cleanText(row.sort_order)}</span>
                            </div>
                        </div>
                    </div>

                    <div class="amtex-cat-card-actions">
                        ${actionsHtml}
                    </div>
                </div>
            `;

            grid.append(card);
        });

        $('#amtexCatInfo').html($('.dataTables_info').html() || '');
        $('#amtexCatPaginate').html($('.dataTables_paginate').html() || '');

        // style the actions buttons that come from partials.datatablesActions
        $('#amtexCatGrid .amtex-cat-actions-inner a.btn, #amtexCatGrid .amtex-cat-actions-inner button.btn').addClass('amtex-cat-actionbtn');
    }

    table.on('draw', function () {
        renderCards();
    });

    let searchTimer = null;
    $('#amtexCatSearch').on('input', function () {
        clearTimeout(searchTimer);
        const val = this.value;
        searchTimer = setTimeout(function () {
            table.search(val).draw();
        }, 250);
    });

    $('#amtexCatStatus').on('change', function () {
        table.draw();
    });

    $('#amtexCatSort').on('change', function () {
        const dir = $(this).val();
        table.order([1, dir]).draw();
    });

    $(document).on('click', '#amtexCatPaginate a', function (e) {
        e.preventDefault();
        const text = $(this).text().trim();
        const hidden = $('.dataTables_paginate');
        hidden.find('a').filter(function(){ return $(this).text().trim() === text; }).first().trigger('click');
    });

    renderCards();
});
</script>
@endsection
