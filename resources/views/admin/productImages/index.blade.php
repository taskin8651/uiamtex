@extends('layouts.admin')
@section('content')

<div class="amtex-pimg-page">

    {{-- Header --}}
    <div class="amtex-pimg-header">
        <div class="amtex-pimg-header-left">
            <h2 class="amtex-pimg-title">{{ trans('cruds.productImage.title') }}</h2>
            <p class="amtex-pimg-subtitle">Manage product gallery images in a premium, clean and non-tabular view.</p>
        </div>

        <div class="amtex-pimg-header-right">
            @can('product_image_create')
                <a class="btn amtex-pimg-btn amtex-pimg-btn-primary" href="{{ route('admin.product-images.create') }}">
                    <i class="fas fa-plus"></i> {{ trans('global.add') }} {{ trans('cruds.productImage.title_singular') }}
                </a>

                <button class="btn amtex-pimg-btn amtex-pimg-btn-light" data-toggle="modal" data-target="#csvImportModal">
                    <i class="fas fa-file-csv"></i> {{ trans('global.app_csvImport') }}
                </button>

                @include('csvImport.modal', ['model' => 'ProductImage', 'route' => 'admin.product-images.parseCsvImport'])
            @endcan
        </div>
    </div>

    {{-- Controls --}}
    <div class="amtex-pimg-controls">
        <div class="amtex-pimg-search">
            <i class="fas fa-search"></i>
            <input id="amtexPimgSearch" type="text" class="amtex-pimg-search-input" placeholder="Search by product name or ID..." />
        </div>

        <div class="amtex-pimg-filter">
            <select id="amtexPimgProduct" class="amtex-pimg-select">
                @foreach(($select_products ?? []) as $id => $entry)
                    <option value="{{ $id }}">{{ $entry }}</option>
                @endforeach
            </select>

            <select id="amtexPimgSort" class="amtex-pimg-select">
                <option value="desc">Newest First</option>
                <option value="asc">Oldest First</option>
            </select>
        </div>
    </div>

    {{-- Grid --}}
    <div id="amtexPimgGrid" class="amtex-pimg-grid"></div>

    {{-- Empty --}}
    <div id="amtexPimgEmpty" class="amtex-pimg-empty" style="display:none;">
        <div class="amtex-pimg-empty-card">
            <h3>No product images found</h3>
            <p>Try changing your search or product filter.</p>
        </div>
    </div>

    {{-- Pagination --}}
    <div class="amtex-pimg-pager">
        <div id="amtexPimgInfo" class="amtex-pimg-info"></div>
        <div id="amtexPimgPaginate" class="amtex-pimg-paginate"></div>
    </div>

    {{-- Hidden DataTable --}}
    <div class="amtex-pimg-hidden">
        <table class="table ajaxTable datatable datatable-ProductImage" id="amtexPimgTable">
            <thead>
            <tr>
                <th></th>
                <th>{{ trans('cruds.productImage.fields.id') }}</th>
                <th>{{ trans('cruds.productImage.fields.select_product') }}</th>
                <th>{{ trans('cruds.productImage.fields.image') }}</th>
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

@can('product_image_delete')
    // Keep mass delete in hidden datatable buttons (optional)
    let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
    let deleteButton = {
        text: deleteButtonTrans,
        url: "{{ route('admin.product-images.massDestroy') }}",
        className: 'btn-danger',
        action: function (e, dt, node, config) {
            var ids = $.map(dt.rows({ selected: true }).data(), function (entry) { return entry.id });

            if (ids.length === 0) {
                alert('{{ trans('global.datatables.zero_selected') }}');
                return;
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
    dtButtons.push(deleteButton);
@endcan

    let dtOverrideGlobals = {
        buttons: dtButtons,
        processing: true,
        serverSide: true,
        retrieve: true,
        aaSorting: [],
        ajax: {
            url: "{{ route('admin.product-images.index') }}",
            data: function (d) {
                d.amtex_product = $('#amtexPimgProduct').val() ?? '';
            }
        },
        columns: [
            { data: 'placeholder', name: 'placeholder' },
            { data: 'id', name: 'id' },
            { data: 'select_product_name', name: 'select_product.name' },
            { data: 'image', name: 'image', sortable: false, searchable: false },
            { data: 'actions', name: '{{ trans('global.actions') }}' }
        ],
        orderCellsTop: true,
        order: [[ 1, 'desc' ]],
        pageLength: 12,
        dom: 'rtip'
    };

    let table = $('#amtexPimgTable').DataTable(dtOverrideGlobals);

    // Parse multiple image links from HTML
    function extractImageUrls(html) {
        if (!html) return [];
        try {
            const div = document.createElement('div');
            div.innerHTML = html;

            // Prefer anchor hrefs (full image)
            const anchors = Array.from(div.querySelectorAll('a'));
            const hrefs = anchors
                .map(a => a.getAttribute('href'))
                .filter(u => u && u !== '#' && u !== 'javascript:void(0)');

            if (hrefs.length) return hrefs;

            // fallback to img srcs
            const imgs = Array.from(div.querySelectorAll('img'));
            return imgs.map(img => img.getAttribute('src')).filter(Boolean);
        } catch (e) {
            return [];
        }
    }

    function renderCards() {
        const grid = $('#amtexPimgGrid');
        const empty = $('#amtexPimgEmpty');

        grid.html('');

        const data = table.rows({ page: 'current' }).data().toArray();

        if (!data.length) {
            empty.show();
            $('#amtexPimgInfo').html('');
            $('#amtexPimgPaginate').html('');
            return;
        }

        empty.hide();

        data.forEach(row => {

            const urls = extractImageUrls(row.image);
            const cover = urls[0] || null;
            const count = urls.length;

            const coverHtml = cover
                ? `<a href="${cover}" target="_blank" class="amtex-pimg-cover">
                        <img src="${cover}" alt="Product Image" loading="lazy" />
                   </a>`
                : `<div class="amtex-pimg-cover amtex-pimg-cover-fallback">
                        <div class="amtex-pimg-fallbacktext">No Image</div>
                   </div>`;

            // small thumbs (max 3)
            let thumbsHtml = '';
            if (urls.length > 1) {
                const thumbs = urls.slice(0, 4); // show up to 4
                thumbsHtml = `
                    <div class="amtex-pimg-thumbs">
                        ${thumbs.map((u, idx) => `
                            <a href="${u}" target="_blank" class="amtex-pimg-thumb" title="Open image ${idx+1}">
                                <img src="${u}" alt="Thumb ${idx+1}" loading="lazy" />
                            </a>
                        `).join('')}
                        ${urls.length > 4 ? `<div class="amtex-pimg-more">+${urls.length - 4}</div>` : ``}
                    </div>
                `;
            }

            const card = `
                <div class="amtex-pimg-card">
                    <div class="amtex-pimg-top">
                        ${coverHtml}
                        <div class="amtex-pimg-badges">
                            <span class="amtex-pimg-badge amtex-pimg-badge-soft">#${row.id ?? '-'}</span>
                            <span class="amtex-pimg-badge amtex-pimg-badge-count">
                                <i class="fas fa-images"></i> ${count} file${count === 1 ? '' : 's'}
                            </span>
                        </div>
                    </div>

                    <div class="amtex-pimg-body">
                        <div class="amtex-pimg-prodname">
                            ${row.select_product_name ?? '—'}
                        </div>

                        ${thumbsHtml}
                    </div>

                    <div class="amtex-pimg-actions">
                        ${row.actions ?? ''}
                    </div>
                </div>
            `;

            grid.append(card);
        });

        $('#amtexPimgInfo').html($('.dataTables_info').html() || '');
        $('#amtexPimgPaginate').html($('.dataTables_paginate').html() || '');
    }

    table.on('draw', function () {
        renderCards();
    });

    // Search (global)
    let searchTimer = null;
    $('#amtexPimgSearch').on('input', function () {
        clearTimeout(searchTimer);
        const val = this.value;
        searchTimer = setTimeout(function () {
            table.search(val).draw();
        }, 250);
    });

    // Filter + sort
    $('#amtexPimgProduct').on('change', function () {
        table.draw();
    });

    $('#amtexPimgSort').on('change', function () {
        const dir = $(this).val();
        table.order([1, dir]).draw();
    });

    // Pagination mapping (our custom area -> hidden datatable)
    $(document).on('click', '#amtexPimgPaginate a', function (e) {
        e.preventDefault();
        const text = $(this).text().trim();
        const hidden = $('.dataTables_paginate');
        hidden.find('a').filter(function(){ return $(this).text().trim() === text; }).first().trigger('click');
    });

    renderCards();

});
</script>
@endsection
