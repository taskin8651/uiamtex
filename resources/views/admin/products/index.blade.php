@extends('layouts.admin')
@section('content')

<div class="amtex-prod-page">

  {{-- Header --}}
  <div class="amtex-prod-top">
    <div class="amtex-prod-top-left">
      <div class="amtex-prod-kicker">
        <span class="amtex-prod-kdot"></span>
        Catalog
      </div>
      <h2 class="amtex-prod-title">{{ trans('cruds.product.title') }}</h2>
      <p class="amtex-prod-subtitle">Manage products in a clean, premium and user-friendly view.</p>
    </div>

    <div class="amtex-prod-top-right">
      @can('product_create')
        <a class="btn amtex-prod-btn amtex-prod-btn-primary" href="{{ route('admin.products.create') }}">
          <i class="fas fa-plus"></i> {{ trans('global.add') }} {{ trans('cruds.product.title_singular') }}
        </a>

        <button class="btn amtex-prod-btn amtex-prod-btn-ghost" data-toggle="modal" data-target="#csvImportModal">
          <i class="fas fa-file-csv"></i> {{ trans('global.app_csvImport') }}
        </button>

        @include('csvImport.modal', ['model' => 'Product', 'route' => 'admin.products.parseCsvImport'])
      @endcan
    </div>
  </div>

  {{-- Toolbar --}}
  <div class="amtex-prod-toolbar">
    <div class="amtex-prod-searchbox">
      <i class="fas fa-search amtex-prod-searchicon"></i>
      <input id="amtexProdSearch" type="text" class="amtex-prod-searchinput" placeholder="Search by name, slug, SKU, category..." autocomplete="off" />
    </div>

    <div class="amtex-prod-filters">
      <select id="amtexProdActive" class="amtex-prod-select">
        <option value="">All Status</option>
        <option value="yes">Active</option>
        <option value="no">Inactive</option>
      </select>

      <select id="amtexProdFeatured" class="amtex-prod-select">
        <option value="">All Featured</option>
        <option value="yes">Featured</option>
        <option value="no">Not Featured</option>
      </select>

      <select id="amtexProdSort" class="amtex-prod-select">
        <option value="desc">Newest First</option>
        <option value="asc">Oldest First</option>
      </select>

      {{-- ✅ NEW: View toggle --}}
      <div class="amtex-prod-viewtog" role="group" aria-label="View">
        <button type="button" class="amtex-prod-viewbtn active" id="amtexViewCards" title="Card view">
          <i class="fas fa-th-large"></i>
        </button>
        <button type="button" class="amtex-prod-viewbtn" id="amtexViewTable" title="Table view">
          <i class="fas fa-list"></i>
        </button>
      </div>
    </div>
  </div>

  {{-- KPI mini bar --}}
  <div class="amtex-prod-kpis">
    <div class="amtex-prod-kpi">
      <div class="amtex-prod-kpi-label">Showing</div>
      <div class="amtex-prod-kpi-value" id="amtexProdKpiShowing">0</div>
    </div>
    <div class="amtex-prod-kpi">
      <div class="amtex-prod-kpi-label">Page</div>
      <div class="amtex-prod-kpi-value" id="amtexProdKpiPage">1</div>
    </div>
    <div class="amtex-prod-kpi">
      <div class="amtex-prod-kpi-label">Filters</div>
      <div class="amtex-prod-kpi-value" id="amtexProdKpiFilters">All</div>
    </div>
  </div>

  {{-- ✅ Cards Grid --}}
  <div id="amtexProdGrid" class="amtex-prod-grid"></div>

  {{-- ✅ Table View (uses the same datatable, just shown nicely) --}}
  <div id="amtexProdTableView" class="amtex-prod-tableview" style="display:none;">
    <div class="amtex-prod-tablewrap">
      <table class="table table-bordered table-striped ajaxTable datatable datatable-Product w-100" id="amtexProdTableVisible">
        <thead>
          <tr>
            <th></th>
            <th>{{ trans('cruds.product.fields.id') }}</th>
            <th>{{ trans('cruds.product.fields.select_category') }}</th>
            <th>{{ trans('cruds.product.fields.name') }}</th>
            <th>{{ trans('cruds.product.fields.slug') }}</th>
            <th>{{ trans('cruds.product.fields.base_price') }}</th>
            <th>{{ trans('cruds.product.fields.compare_price') }}</th>
            <th>{{ trans('cruds.product.fields.badge') }}</th>
            <th>{{ trans('cruds.product.fields.dispatch_text') }}</th>
            <th>{{ trans('cruds.product.fields.rating_avg') }}</th>
            <th>{{ trans('cruds.product.fields.rating_count') }}</th>
            <th>{{ trans('cruds.product.fields.sku') }}</th>
            <th>{{ trans('cruds.product.fields.is_featured') }}</th>
            <th>{{ trans('cruds.product.fields.is_active') }}</th>
            <th>{{ trans('cruds.product.fields.main_image') }}</th>
            <th>{{ trans('cruds.product.fields.brochure_pdf') }}</th>
            <th>&nbsp;</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>

  {{-- Empty state --}}
  <div id="amtexProdEmpty" class="amtex-prod-empty" style="display:none;">
    <div class="amtex-prod-empty-card">
      <div class="amtex-prod-empty-ico"><i class="fas fa-box-open"></i></div>
      <h3>No products found</h3>
      <p>Try changing your search or filters.</p>
    </div>
  </div>

  {{-- Pagination --}}
  <div class="amtex-prod-pager">
    <div id="amtexProdInfo" class="amtex-prod-info"></div>
    <div id="amtexProdPaginate" class="amtex-prod-paginate"></div>
  </div>

  {{-- Hidden DataTable (kept for server-side fetch & pagination mapping) --}}
  <div class="amtex-prod-hidden">
    <table class="table ajaxTable datatable datatable-Product" id="amtexProdTable">
      <thead>
        <tr>
          <th></th>
          <th>{{ trans('cruds.product.fields.id') }}</th>
          <th>{{ trans('cruds.product.fields.select_category') }}</th>
          <th>{{ trans('cruds.product.fields.name') }}</th>
          <th>{{ trans('cruds.product.fields.slug') }}</th>
          <th>{{ trans('cruds.product.fields.base_price') }}</th>
          <th>{{ trans('cruds.product.fields.compare_price') }}</th>
          <th>{{ trans('cruds.product.fields.badge') }}</th>
          <th>{{ trans('cruds.product.fields.dispatch_text') }}</th>
          <th>{{ trans('cruds.product.fields.rating_avg') }}</th>
          <th>{{ trans('cruds.product.fields.rating_count') }}</th>
          <th>{{ trans('cruds.product.fields.sku') }}</th>
          <th>{{ trans('cruds.product.fields.is_featured') }}</th>
          <th>{{ trans('cruds.product.fields.is_active') }}</th>
          <th>{{ trans('cruds.product.fields.main_image') }}</th>
          <th>{{ trans('cruds.product.fields.brochure_pdf') }}</th>
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

  // ✅ single source of truth datatable (hidden)
  let dtOverrideGlobals = {
    buttons: dtButtons,
    processing: true,
    serverSide: true,
    retrieve: true,
    aaSorting: [],
    ajax: {
      url: "{{ route('admin.products.index') }}",
      data: function (d) {
        d.amtex_active = $('#amtexProdActive').val() ?? '';
        d.amtex_featured = $('#amtexProdFeatured').val() ?? '';
      }
    },
    columns: [
      { data: 'placeholder', name: 'placeholder' },
      { data: 'id', name: 'id' },
      { data: 'select_category_name', name: 'select_category.name' },
      { data: 'name', name: 'name' },
      { data: 'slug', name: 'slug' },
      { data: 'base_price', name: 'base_price' },
      { data: 'compare_price', name: 'compare_price' },
      { data: 'badge', name: 'badge' },
      { data: 'dispatch_text', name: 'dispatch_text' },
      { data: 'rating_avg', name: 'rating_avg' },
      { data: 'rating_count', name: 'rating_count' },
      { data: 'sku', name: 'sku' },
      { data: 'is_featured', name: 'is_featured' },
      { data: 'is_active', name: 'is_active' },
      { data: 'main_image', name: 'main_image', sortable: false, searchable: false },
      { data: 'brochure_pdf', name: 'brochure_pdf', sortable: false, searchable: false },
      { data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 12,
    dom: 'rtip'
  };

  let table = $('#amtexProdTable').DataTable(dtOverrideGlobals);

  // ✅ visible table for "Table view"
  let tableVisible = null;
  function ensureVisibleTableInit() {
    if (tableVisible) return;

    // clone header structure already matches; init a datatable using same endpoint
    tableVisible = $('#amtexProdTableVisible').DataTable({
      ...dtOverrideGlobals,
      dom: 'rtip',
      // keep the same filters/search as the hidden one:
      ajax: {
        url: "{{ route('admin.products.index') }}",
        data: function (d) {
          d.search = { value: $('#amtexProdSearch').val() || '' };
          d.amtex_active = $('#amtexProdActive').val() ?? '';
          d.amtex_featured = $('#amtexProdFeatured').val() ?? '';
        }
      }
    });

    // When visible table draws, keep KPIs consistent
    tableVisible.on('draw', function(){
      updateKPIsFrom(tableVisible);
      mapPagerFrom(tableVisible);
      mapInfoFrom(tableVisible);
      toggleEmptyState(tableVisible);
    });
  }

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

  function plainText(html) {
    if (!html) return '';
    try {
      const div = document.createElement('div');
      div.innerHTML = html;
      return (div.textContent || div.innerText || '').trim();
    } catch (e) {
      return String(html);
    }
  }

  function money(val) {
    if (val === null || val === undefined || String(val).trim() === '') return '—';
    return '₹' + String(val);
  }

  function calcFilterLabel() {
    const a = $('#amtexProdActive').val();
    const f = $('#amtexProdFeatured').val();
    const parts = [];
    if (a === 'yes') parts.push('Active');
    if (a === 'no') parts.push('Inactive');
    if (f === 'yes') parts.push('Featured');
    if (f === 'no') parts.push('Not Featured');
    return parts.length ? parts.join(' • ') : 'All';
  }

  function updateKPIsFrom(dt) {
    const rows = dt.rows({ page: 'current' }).data().toArray();
    $('#amtexProdKpiShowing').text(rows.length);
    const info = dt.page.info();
    $('#amtexProdKpiPage').text((info.page + 1) + ' / ' + info.pages);
    $('#amtexProdKpiFilters').text(calcFilterLabel());
  }

  function toggleEmptyState(dt) {
    const rows = dt.rows({ page: 'current' }).data().toArray();
    if (!rows.length) $('#amtexProdEmpty').show(); else $('#amtexProdEmpty').hide();
  }

  function mapInfoFrom(dt){
    // dataTables_info exists for each table; use the active one
    const wrap = $(dt.table().container());
    $('#amtexProdInfo').html(wrap.find('.dataTables_info').html() || '');
  }

  function mapPagerFrom(dt){
    const wrap = $(dt.table().container());
    $('#amtexProdPaginate').html(wrap.find('.dataTables_paginate').html() || '');
  }

  function renderCards() {
    const grid = $('#amtexProdGrid');
    grid.html('');

    const rows = table.rows({ page: 'current' }).data().toArray();

    updateKPIsFrom(table);

    if (!rows.length) {
      $('#amtexProdEmpty').show();
      $('#amtexProdInfo').html('');
      $('#amtexProdPaginate').html('');
      return;
    }

    $('#amtexProdEmpty').hide();

    rows.forEach(row => {

      const imgUrl = extractBestImageUrl(row.main_image);
      const imgHtml = imgUrl
        ? `<img src="${imgUrl}" alt="${(row.name ?? 'Product')}" loading="lazy" />`
        : `<div class="amtex-prod-img-fallback"><span>No Image</span></div>`;

      const categoryName = row.select_category_name ?? '-';

      const activeText = plainText(row.is_active || '');
      const featuredText = plainText(row.is_featured || '');
      const badgeText = plainText(row.badge || '');

      const isActive = activeText.toLowerCase().includes('active') || activeText.toLowerCase().includes('yes');
      const isFeatured = featuredText.toLowerCase().includes('featured') || featuredText.toLowerCase().includes('yes');

      const activeClass = isActive ? 'amtex-prod-pill-active' : 'amtex-prod-pill-inactive';

      const featuredHtml = isFeatured
        ? `<span class="amtex-prod-pill amtex-prod-pill-featured"><i class="fas fa-star"></i> Featured</span>`
        : '';

      const badgeHtml = badgeText
        ? `<span class="amtex-prod-pill amtex-prod-pill-badge">${badgeText}</span>`
        : '';

      const basePrice = row.base_price ?? '';
      const comparePrice = row.compare_price ?? '';

      const priceHtml = (String(comparePrice).trim() !== '' && comparePrice !== '-')
        ? `<div class="amtex-prod-price">
             <span class="amtex-prod-price-main">${money(basePrice)}</span>
             <span class="amtex-prod-price-compare">${money(comparePrice)}</span>
           </div>`
        : `<div class="amtex-prod-price">
             <span class="amtex-prod-price-main">${money(basePrice)}</span>
           </div>`;

      const brochureText = plainText(row.brochure_pdf || '');
      const brochureHtml = brochureText
        ? `<div class="amtex-prod-brochure">${row.brochure_pdf}</div>`
        : `<div class="amtex-prod-brochure amtex-prod-brochure-muted">No brochure</div>`;

      const card = `
        <div class="amtex-prod-card">
          <div class="amtex-prod-card-top">
            <div class="amtex-prod-img">${imgHtml}</div>

            <div class="amtex-prod-pills">
              <span class="amtex-prod-pill ${activeClass}">${activeText || (isActive ? 'Active' : 'Inactive')}</span>
              <span class="amtex-prod-pill amtex-prod-pill-soft">#${row.id ?? '-'}</span>
              ${featuredHtml}
              ${badgeHtml}
            </div>
          </div>

          <div class="amtex-prod-card-body">
            <div class="amtex-prod-name" title="${row.name ?? ''}">${row.name ?? '-'}</div>
            <div class="amtex-prod-cat"><i class="fas fa-folder-open"></i> ${categoryName}</div>

            ${priceHtml}

            <div class="amtex-prod-meta">
              <div class="amtex-prod-meta-row">
                <span class="amtex-prod-meta-label">Slug</span>
                <span class="amtex-prod-meta-value" title="${row.slug ?? ''}">${row.slug ?? '-'}</span>
              </div>

              <div class="amtex-prod-meta-row">
                <span class="amtex-prod-meta-label">SKU</span>
                <span class="amtex-prod-meta-value">${row.sku ?? '-'}</span>
              </div>

              <div class="amtex-prod-meta-row">
                <span class="amtex-prod-meta-label">Rating</span>
                <span class="amtex-prod-meta-value">${row.rating_avg ?? '-'} (${row.rating_count ?? '-'})</span>
              </div>

              <div class="amtex-prod-meta-row">
                <span class="amtex-prod-meta-label">Dispatch</span>
                <span class="amtex-prod-meta-value">${row.dispatch_text ?? '-'}</span>
              </div>
            </div>

            ${brochureHtml}
          </div>

          <div class="amtex-prod-card-actions">
            <div class="amtex-prod-actions-inner">
              ${row.actions ?? ''}
            </div>
          </div>
        </div>
      `;

      grid.append(card);
    });

    mapInfoFrom(table);
    mapPagerFrom(table);

    $('#amtexProdGrid .amtex-prod-actions-inner a.btn, #amtexProdGrid .amtex-prod-actions-inner button.btn')
      .addClass('amtex-prod-actionbtn');
  }

  table.on('draw', function () {
    // only render cards if card view active
    if ($('#amtexViewCards').hasClass('active')) renderCards();
  });

  // Search (server-side)
  let searchTimer = null;
  $('#amtexProdSearch').on('input', function () {
    clearTimeout(searchTimer);
    const val = this.value;
    searchTimer = setTimeout(function () {
      if ($('#amtexViewCards').hasClass('active')) {
        table.search(val).draw();
      } else {
        ensureVisibleTableInit();
        tableVisible.search(val).draw();
      }
    }, 250);
  });

  // Filters
  $('#amtexProdActive, #amtexProdFeatured').on('change', function () {
    if ($('#amtexViewCards').hasClass('active')) {
      table.draw();
    } else {
      ensureVisibleTableInit();
      tableVisible.draw();
    }
  });

  // Sort
  $('#amtexProdSort').on('change', function () {
    const dir = $(this).val();
    if ($('#amtexViewCards').hasClass('active')) {
      table.order([1, dir]).draw();
    } else {
      ensureVisibleTableInit();
      tableVisible.order([1, dir]).draw();
    }
  });

  // Pagination mapping (works for both)
  $(document).on('click', '#amtexProdPaginate a', function (e) {
    e.preventDefault();
    const text = $(this).text().trim();

    if ($('#amtexViewCards').hasClass('active')) {
      const hidden = $('.dataTables_paginate', table.table().container());
      hidden.find('a').filter(function(){ return $(this).text().trim() === text; }).first().trigger('click');
    } else {
      ensureVisibleTableInit();
      const vis = $('.dataTables_paginate', tableVisible.table().container());
      vis.find('a').filter(function(){ return $(this).text().trim() === text; }).first().trigger('click');
    }
  });

  // ✅ View toggle
  $('#amtexViewCards').on('click', function(){
    $('#amtexViewTable').removeClass('active');
    $(this).addClass('active');

    $('#amtexProdTableView').hide();
    $('#amtexProdGrid').show();

    // sync cards based on current filters/search
    table.search($('#amtexProdSearch').val() || '').draw();
  });

  $('#amtexViewTable').on('click', function(){
    $('#amtexViewCards').removeClass('active');
    $(this).addClass('active');

    $('#amtexProdGrid').hide();
    $('#amtexProdTableView').show();

    ensureVisibleTableInit();
    tableVisible.search($('#amtexProdSearch').val() || '').draw();
  });

  // initial render
  renderCards();
});
</script>

<style>
  /* ✅ tiny addon styles for view toggle + table wrapper */
  .amtex-prod-viewtog{
    display:inline-flex;
    gap:6px;
    padding:4px;
    border:1px solid rgba(0,0,0,.08);
    border-radius:999px;
    background:#fff;
    align-items:center;
  }
  .amtex-prod-viewbtn{
    border:0;
    background:transparent;
    width:36px;
    height:36px;
    border-radius:999px;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    opacity:.7;
    cursor:pointer;
  }
  .amtex-prod-viewbtn.active{
    background:rgba(0,0,0,.06);
    opacity:1;
  }
  .amtex-prod-tablewrap{
    border:1px solid rgba(0,0,0,.08);
    border-radius:14px;
    padding:10px;
    background:#fff;
    overflow:auto;
  }
</style>
@endsection
