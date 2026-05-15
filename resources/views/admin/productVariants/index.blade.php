@extends('layouts.admin')
@section('content')

<div class="amtex-pvar-page">

  {{-- Header --}}
  <div class="amtex-pvar-header">
    <div class="amtex-pvar-header-left">
      <div class="amtex-pvar-kicker">
        <span class="amtex-pvar-kdot"></span>
        Catalogue
      </div>
      <h2 class="amtex-pvar-title">{{ trans('cruds.productVariant.title') ?? trans('cruds.productVariant.title_singular') }}</h2>
      <p class="amtex-pvar-subtitle">Manage variants with a premium, clean and non-tabular view.</p>
    </div>

    <div class="amtex-pvar-header-right">
      @can('product_variant_create')
        <a class="btn amtex-pvar-btn amtex-pvar-btn-primary" href="{{ route('admin.product-variants.create') }}">
          <i class="fas fa-plus"></i> {{ trans('global.add') }} {{ trans('cruds.productVariant.title_singular') }}
        </a>

        <button class="btn amtex-pvar-btn amtex-pvar-btn-light" data-toggle="modal" data-target="#csvImportModal">
          <i class="fas fa-file-csv"></i> {{ trans('global.app_csvImport') }}
        </button>

        @include('csvImport.modal', ['model' => 'ProductVariant', 'route' => 'admin.product-variants.parseCsvImport'])
      @endcan
    </div>
  </div>

  {{-- Controls --}}
  <div class="amtex-pvar-controls">

    <div class="amtex-pvar-search">
      <i class="fas fa-search"></i>
      <input id="amtexPvarSearch" type="text" class="amtex-pvar-search-input" placeholder="Search by product, SKU, capacity, finish..." />
    </div>

    <div class="amtex-pvar-filter">
      <select id="amtexPvarProduct" class="amtex-pvar-select">
        @foreach($select_products as $id => $name)
          <option value="{{ $id }}">{{ $name }}</option>
        @endforeach
      </select>

      <select id="amtexPvarDefault" class="amtex-pvar-select">
        <option value="">All Defaults</option>
        <option value="yes">Default</option>
        <option value="no">Not Default</option>
      </select>

      <select id="amtexPvarStock" class="amtex-pvar-select">
        <option value="">All Stock</option>
        <option value="in">In Stock</option>
        <option value="low">Low Stock</option>
        <option value="out">Out of Stock</option>
      </select>

      <select id="amtexPvarSort" class="amtex-pvar-select">
        <option value="desc">Newest First</option>
        <option value="asc">Oldest First</option>
      </select>
    </div>
  </div>

  {{-- Grid --}}
  <div id="amtexPvarGrid" class="amtex-pvar-grid"></div>

  {{-- Empty --}}
  <div id="amtexPvarEmpty" class="amtex-pvar-empty" style="display:none;">
    <div class="amtex-pvar-empty-card">
      <h3>No variants found</h3>
      <p>Try changing your search or filters.</p>
    </div>
  </div>

  {{-- Pagination --}}
  <div class="amtex-pvar-pager">
    <div id="amtexPvarInfo" class="amtex-pvar-info"></div>
    <div id="amtexPvarPaginate" class="amtex-pvar-paginate"></div>
  </div>

  {{-- Hidden DataTable --}}
  <div class="amtex-pvar-hidden">
    <table class="table ajaxTable datatable datatable-ProductVariant" id="amtexPvarTable">
      <thead>
        <tr>
          <th></th>
          <th>{{ trans('cruds.productVariant.fields.id') }}</th>
          <th>{{ trans('cruds.productVariant.fields.select_product') }}</th>
          <th>{{ trans('cruds.productVariant.fields.capacity_label') }}</th>
          <th>{{ trans('cruds.productVariant.fields.finish_label') }}</th>
          <th>{{ trans('cruds.productVariant.fields.sku') }}</th>
          <th>{{ trans('cruds.productVariant.fields.price') }}</th>
          <th>{{ trans('cruds.productVariant.fields.compare_price') }}</th>
          <th>{{ trans('cruds.productVariant.fields.stock_qty') }}</th>
          <th>{{ trans('cruds.productVariant.fields.is_default') }}</th>
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

  // Keep mass delete, but not visible (still works when selecting rows in hidden table)
  @can('product_variant_delete')
    let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
    let deleteButton = {
      text: deleteButtonTrans,
      url: "{{ route('admin.product-variants.massDestroy') }}",
      className: 'btn-danger',
      action: function (e, dt, node, config) {
        var ids = $.map(dt.rows({ selected: true }).data(), function (entry) {
          return entry.id
        });

        if (ids.length === 0) {
          alert('{{ trans('global.datatables.zero_selected') }}');
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
    dtButtons.push(deleteButton);
  @endcan

  let dtOverrideGlobals = {
    buttons: dtButtons,
    processing: true,
    serverSide: true,
    retrieve: true,
    aaSorting: [],
    ajax: {
      url: "{{ route('admin.product-variants.index') }}",
      data: function (d) {
        d.amtex_product_id = $('#amtexPvarProduct').val() ?? '';
        d.amtex_default    = $('#amtexPvarDefault').val() ?? '';
        d.amtex_stock      = $('#amtexPvarStock').val() ?? '';
        d.amtex_low_threshold = 10; // tweak if needed
      }
    },
    columns: [
      { data: 'placeholder', name: 'placeholder' },
      { data: 'id', name: 'id' },
      { data: 'select_product_name', name: 'select_product.name' },
      { data: 'capacity_label', name: 'capacity_label' },
      { data: 'finish_label', name: 'finish_label' },
      { data: 'sku', name: 'sku' },
      { data: 'price', name: 'price' },
      { data: 'compare_price', name: 'compare_price' },
      { data: 'stock_qty', name: 'stock_qty' },
      { data: 'is_default', name: 'is_default' },
      { data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 12,
    dom: 'rtip'
  };

  let table = $('#amtexPvarTable').DataTable(dtOverrideGlobals);

  function plainText(html) {
    if (!html) return '';
    try {
      const div = document.createElement('div');
      div.innerHTML = html;
      return (div.textContent || div.innerText || '').trim();
    } catch (e) { return String(html); }
  }

  function fmtMoney(v){
    if (v === null || v === undefined || String(v).trim()==='') return '—';
    return '₹' + String(v);
  }

  function renderCards() {
    const grid = $('#amtexPvarGrid');
    const empty = $('#amtexPvarEmpty');

    grid.html('');

    const data = table.rows({ page: 'current' }).data().toArray();

    if (!data.length) {
      empty.show();
      $('#amtexPvarInfo').html('');
      $('#amtexPvarPaginate').html('');
      return;
    }

    empty.hide();

    data.forEach(row => {
      const productName = row.select_product_name ?? '—';
      const cap = row.capacity_label ?? '—';
      const finish = row.finish_label ?? '—';
      const sku = row.sku ?? '—';

      const price = fmtMoney(row.price);
      const cprice = row.compare_price ? fmtMoney(row.compare_price) : '';

      const stock = (row.stock_qty === null || row.stock_qty === undefined || row.stock_qty === '') ? '—' : row.stock_qty;

      const isDefaultText = plainText(row.is_default || '');
      const isDefaultYes = isDefaultText.toLowerCase().includes('yes') || isDefaultText.toLowerCase().includes('default') || isDefaultText === '1';

      let stockClass = 'amtex-pvar-pill-soft';
      const stockNum = parseInt(stock, 10);
      if (!isNaN(stockNum)) {
        if (stockNum <= 0) stockClass = 'amtex-pvar-pill-out';
        else if (stockNum <= 10) stockClass = 'amtex-pvar-pill-low';
        else stockClass = 'amtex-pvar-pill-in';
      }

      const card = `
        <div class="amtex-pvar-card">
          <div class="amtex-pvar-card-top">
            <div class="amtex-pvar-top-left">
              <div class="amtex-pvar-name">${productName}</div>
              <div class="amtex-pvar-sub">
                <span class="amtex-pvar-dot"></span>
                Variant #${row.id ?? '—'}
              </div>
            </div>

            <div class="amtex-pvar-pills">
              <span class="amtex-pvar-pill ${stockClass}">
                <i class="fas fa-cubes"></i> Stock: ${stock}
              </span>
              ${isDefaultYes ? `<span class="amtex-pvar-pill amtex-pvar-pill-default"><i class="fas fa-check"></i> Default</span>` : ``}
              <span class="amtex-pvar-pill amtex-pvar-pill-soft">SKU: ${sku}</span>
            </div>
          </div>

          <div class="amtex-pvar-body">
            <div class="amtex-pvar-kv">
              <div class="amtex-pvar-kv-item">
                <div class="amtex-pvar-kv-label">Capacity</div>
                <div class="amtex-pvar-kv-value">${cap}</div>
              </div>
              <div class="amtex-pvar-kv-item">
                <div class="amtex-pvar-kv-label">Finish</div>
                <div class="amtex-pvar-kv-value">${finish}</div>
              </div>
              <div class="amtex-pvar-kv-item">
                <div class="amtex-pvar-kv-label">Price</div>
                <div class="amtex-pvar-kv-value">
                  <span class="amtex-pvar-price">${price}</span>
                  ${cprice ? `<span class="amtex-pvar-compare">${cprice}</span>` : ``}
                </div>
              </div>
            </div>
          </div>

          <div class="amtex-pvar-actions">
            ${row.actions ?? ''}
          </div>
        </div>
      `;

      grid.append(card);
    });

    $('#amtexPvarInfo').html($('.dataTables_info').html() || '');
    $('#amtexPvarPaginate').html($('.dataTables_paginate').html() || '');
  }

  table.on('draw', function () {
    renderCards();
  });

  // Search
  let searchTimer = null;
  $('#amtexPvarSearch').on('input', function () {
    clearTimeout(searchTimer);
    const val = this.value;
    searchTimer = setTimeout(function () {
      table.search(val).draw();
    }, 250);
  });

  // Filters
  $('#amtexPvarProduct, #amtexPvarDefault, #amtexPvarStock').on('change', function () {
    table.draw();
  });

  // Sort by ID
  $('#amtexPvarSort').on('change', function () {
    const dir = $(this).val();
    table.order([1, dir]).draw();
  });

  // Pagination mapping
  $(document).on('click', '#amtexPvarPaginate a', function (e) {
    e.preventDefault();
    const text = $(this).text().trim();
    const hidden = $('.dataTables_paginate');
    hidden.find('a').filter(function(){ return $(this).text().trim() === text; }).first().trigger('click');
  });

  renderCards();

});
</script>
@endsection
