@extends('layouts.admin')
@section('content')

<div class="amtex-pvf-page">

  {{-- Header --}}
  <div class="amtex-pvf-header">
    <div>
      <div class="amtex-pvf-kicker">
        <span class="amtex-pvf-kdot"></span>
        Variants
      </div>
      <h2 class="amtex-pvf-title">{{ trans('global.edit') }} {{ trans('cruds.productVariant.title_singular') }}</h2>
      <p class="amtex-pvf-subtitle">Update variant details, pricing and stock. Keep SKU consistent for inventory accuracy.</p>
    </div>

    <div class="amtex-pvf-actions">
      <a href="{{ route('admin.product-variants.index') }}" class="btn amtex-pvf-btn amtex-pvf-btn-light">
        <i class="fas fa-arrow-left"></i> Back
      </a>
    </div>
  </div>

  <div class="amtex-pvf-wrap">

    {{-- Form --}}
    <div class="amtex-pvf-card">
      <form method="POST" action="{{ route('admin.product-variants.update', [$productVariant->id]) }}" enctype="multipart/form-data" class="amtex-pvf-form">
        @method('PUT')
        @csrf

        {{-- Section: Product --}}
        <div class="amtex-pvf-section">
          <div class="amtex-pvf-section-head">
            <div>
              <h4 class="amtex-pvf-section-title">Product Mapping</h4>
              <p class="amtex-pvf-section-sub">This variant belongs to the selected product.</p>
            </div>
            <span class="amtex-pvf-chip">Required</span>
          </div>

          <div class="amtex-pvf-grid">
            <div class="amtex-pvf-field amtex-pvf-span2">
              <label class="amtex-pvf-label required" for="select_product_id">{{ trans('cruds.productVariant.fields.select_product') }}</label>

              <select
                class="form-control select2 amtex-pvf-control {{ $errors->has('select_product') ? 'is-invalid' : '' }}"
                name="select_product_id"
                id="select_product_id"
                required
              >
                @foreach($select_products as $id => $entry)
                  <option value="{{ $id }}"
                    {{ (old('select_product_id') ? old('select_product_id') : ($productVariant->select_product->id ?? '')) == $id ? 'selected' : '' }}>
                    {{ $entry }}
                  </option>
                @endforeach
              </select>

              @if($errors->has('select_product'))
                <div class="invalid-feedback">{{ $errors->first('select_product') }}</div>
              @endif

              <small class="amtex-pvf-help">{{ trans('cruds.productVariant.fields.select_product_helper') }}</small>
            </div>
          </div>
        </div>

        {{-- Section: Labels --}}
        <div class="amtex-pvf-section">
          <div class="amtex-pvf-section-head">
            <div>
              <h4 class="amtex-pvf-section-title">Variant Labels</h4>
              <p class="amtex-pvf-section-sub">Capacity and finish shown to users (and used for catalog clarity).</p>
            </div>
            <span class="amtex-pvf-chip amtex-pvf-chip-alt">Recommended</span>
          </div>

          <div class="amtex-pvf-grid">
            {{-- Capacity --}}
            <div class="amtex-pvf-field">
              <label class="amtex-pvf-label required" for="capacity_label">{{ trans('cruds.productVariant.fields.capacity_label') }}</label>
              <input
                class="form-control amtex-pvf-control {{ $errors->has('capacity_label') ? 'is-invalid' : '' }}"
                type="text"
                name="capacity_label"
                id="capacity_label"
                value="{{ old('capacity_label', $productVariant->capacity_label) }}"
                placeholder="e.g. 4 KG / 6 KG / 9 KG"
                required
              >
              @if($errors->has('capacity_label'))
                <div class="invalid-feedback">{{ $errors->first('capacity_label') }}</div>
              @endif
              <small class="amtex-pvf-help">{{ trans('cruds.productVariant.fields.capacity_label_helper') }}</small>
            </div>

            {{-- Finish --}}
            <div class="amtex-pvf-field">
              <label class="amtex-pvf-label required" for="finish_label">{{ trans('cruds.productVariant.fields.finish_label') }}</label>
              <input
                class="form-control amtex-pvf-control {{ $errors->has('finish_label') ? 'is-invalid' : '' }}"
                type="text"
                name="finish_label"
                id="finish_label"
                value="{{ old('finish_label', $productVariant->finish_label) }}"
                placeholder="e.g. Red / Stainless / ABC"
                required
              >
              @if($errors->has('finish_label'))
                <div class="invalid-feedback">{{ $errors->first('finish_label') }}</div>
              @endif
              <small class="amtex-pvf-help">{{ trans('cruds.productVariant.fields.finish_label_helper') }}</small>
            </div>

            {{-- SKU --}}
            <div class="amtex-pvf-field amtex-pvf-span2">
              <label class="amtex-pvf-label required" for="sku">{{ trans('cruds.productVariant.fields.sku') }}</label>
              <input
                class="form-control amtex-pvf-control {{ $errors->has('sku') ? 'is-invalid' : '' }}"
                type="text"
                name="sku"
                id="sku"
                value="{{ old('sku', $productVariant->sku) }}"
                placeholder="e.g. AMTEX-ABC-6KG-RED"
                required
              >
              @if($errors->has('sku'))
                <div class="invalid-feedback">{{ $errors->first('sku') }}</div>
              @endif
              <small class="amtex-pvf-help">{{ trans('cruds.productVariant.fields.sku_helper') }}</small>

              <div class="amtex-pvf-inlinehint">
                <i class="fas fa-lightbulb"></i>
                Tip: SKU should remain stable once used in invoices / inventory records.
              </div>
            </div>
          </div>
        </div>

        {{-- Section: Pricing & Stock --}}
        <div class="amtex-pvf-section">
          <div class="amtex-pvf-section-head">
            <div>
              <h4 class="amtex-pvf-section-title">Pricing & Inventory</h4>
              <p class="amtex-pvf-section-sub">Update selling price, compare price and stock quantity.</p>
            </div>
            <span class="amtex-pvf-chip">Required</span>
          </div>

          <div class="amtex-pvf-grid">
            {{-- Price --}}
            <div class="amtex-pvf-field">
              <label class="amtex-pvf-label required" for="price">{{ trans('cruds.productVariant.fields.price') }}</label>
              <div class="amtex-pvf-money">
                <span class="amtex-pvf-money-sym">₹</span>
                <input
                  class="form-control amtex-pvf-control amtex-pvf-control-money {{ $errors->has('price') ? 'is-invalid' : '' }}"
                  type="number"
                  name="price"
                  id="price"
                  value="{{ old('price', $productVariant->price) }}"
                  placeholder="e.g. 1499"
                  min="0"
                  step="0.01"
                  required
                >
              </div>
              @if($errors->has('price'))
                <div class="invalid-feedback d-block">{{ $errors->first('price') }}</div>
              @endif
              <small class="amtex-pvf-help">{{ trans('cruds.productVariant.fields.price_helper') }}</small>
            </div>

            {{-- Compare Price --}}
            <div class="amtex-pvf-field">
              <label class="amtex-pvf-label required" for="compare_price">{{ trans('cruds.productVariant.fields.compare_price') }}</label>
              <div class="amtex-pvf-money">
                <span class="amtex-pvf-money-sym">₹</span>
                <input
                  class="form-control amtex-pvf-control amtex-pvf-control-money {{ $errors->has('compare_price') ? 'is-invalid' : '' }}"
                  type="number"
                  name="compare_price"
                  id="compare_price"
                  value="{{ old('compare_price', $productVariant->compare_price) }}"
                  placeholder="e.g. 1999"
                  min="0"
                  step="0.01"
                  required
                >
              </div>
              @if($errors->has('compare_price'))
                <div class="invalid-feedback d-block">{{ $errors->first('compare_price') }}</div>
              @endif
              <small class="amtex-pvf-help">{{ trans('cruds.productVariant.fields.compare_price_helper') }}</small>

              <div class="amtex-pvf-inlinehint">
                <i class="fas fa-tags"></i>
                Compare price helps show discount. Keep it higher than Price for offers.
              </div>
            </div>

            {{-- Stock --}}
            <div class="amtex-pvf-field">
              <label class="amtex-pvf-label required" for="stock_qty">{{ trans('cruds.productVariant.fields.stock_qty') }}</label>
              <input
                class="form-control amtex-pvf-control {{ $errors->has('stock_qty') ? 'is-invalid' : '' }}"
                type="number"
                name="stock_qty"
                id="stock_qty"
                value="{{ old('stock_qty', $productVariant->stock_qty) }}"
                placeholder="e.g. 50"
                min="0"
                step="1"
                required
              >
              @if($errors->has('stock_qty'))
                <div class="invalid-feedback">{{ $errors->first('stock_qty') }}</div>
              @endif
              <small class="amtex-pvf-help">{{ trans('cruds.productVariant.fields.stock_qty_helper') }}</small>

              <div class="amtex-pvf-stockhint">
                <span class="amtex-pvf-badge amtex-pvf-badge-in"><i class="fas fa-check"></i> In</span>
                <span class="amtex-pvf-badge amtex-pvf-badge-low"><i class="fas fa-triangle-exclamation"></i> Low</span>
                <span class="amtex-pvf-badge amtex-pvf-badge-out"><i class="fas fa-xmark"></i> Out</span>
              </div>
            </div>

            {{-- Default --}}
            <div class="amtex-pvf-field">
              <label class="amtex-pvf-label required" for="is_default">{{ trans('cruds.productVariant.fields.is_default') }}</label>
              <select
                class="form-control amtex-pvf-control {{ $errors->has('is_default') ? 'is-invalid' : '' }}"
                name="is_default"
                id="is_default"
                required
              >
                <option value disabled {{ old('is_default', null) === null ? 'selected' : '' }}>
                  {{ trans('global.pleaseSelect') }}
                </option>
                @foreach(App\Models\ProductVariant::IS_DEFAULT_SELECT as $key => $label)
                  <option value="{{ $key }}" {{ old('is_default', (string) $productVariant->is_default) === (string) $key ? 'selected' : '' }}>
                    {{ $label }}
                  </option>
                @endforeach
              </select>

              @if($errors->has('is_default'))
                <div class="invalid-feedback">{{ $errors->first('is_default') }}</div>
              @endif

              <small class="amtex-pvf-help">{{ trans('cruds.productVariant.fields.is_default_helper') }}</small>

              <div class="amtex-pvf-inlinehint">
                <i class="fas fa-shield"></i>
                Recommended: only one variant should be default per product.
              </div>
            </div>

          </div>
        </div>

        {{-- Footer --}}
        <div class="amtex-pvf-footer">
          <a href="{{ route('admin.product-variants.index') }}" class="btn amtex-pvf-btn amtex-pvf-btn-light">
            Cancel
          </a>

          <button class="btn amtex-pvf-btn amtex-pvf-btn-primary" type="submit">
            <i class="fas fa-save"></i> Update
          </button>
        </div>

      </form>
    </div>

    {{-- Preview --}}
    <div class="amtex-pvf-side">
      <div class="amtex-pvf-card amtex-pvf-preview">
        <div class="amtex-pvf-preview-head">
          <h4 class="amtex-pvf-preview-title">Quick Preview</h4>
          <span class="amtex-pvf-chip">Live</span>
        </div>

        <div class="amtex-pvf-preview-box">
          <div class="amtex-pvf-preview-label">Product</div>
          <div class="amtex-pvf-preview-value" id="amtexPvfPrevProduct">—</div>
        </div>

        <div class="amtex-pvf-preview-box">
          <div class="amtex-pvf-preview-label">Capacity</div>
          <div class="amtex-pvf-preview-value" id="amtexPvfPrevCap">—</div>
        </div>

        <div class="amtex-pvf-preview-box">
          <div class="amtex-pvf-preview-label">Finish</div>
          <div class="amtex-pvf-preview-value" id="amtexPvfPrevFinish">—</div>
        </div>

        <div class="amtex-pvf-preview-box">
          <div class="amtex-pvf-preview-label">SKU</div>
          <div class="amtex-pvf-preview-value" id="amtexPvfPrevSku">—</div>
        </div>

        <div class="amtex-pvf-preview-prices">
          <div class="amtex-pvf-preview-price">
            <div class="amtex-pvf-preview-label">Price</div>
            <div class="amtex-pvf-preview-value" id="amtexPvfPrevPrice">—</div>
          </div>
          <div class="amtex-pvf-preview-price">
            <div class="amtex-pvf-preview-label">Compare</div>
            <div class="amtex-pvf-preview-value amtex-pvf-preview-compare" id="amtexPvfPrevCompare">—</div>
          </div>
        </div>

        <div class="amtex-pvf-preview-box">
          <div class="amtex-pvf-preview-label">Stock</div>
          <div class="amtex-pvf-preview-value" id="amtexPvfPrevStock">—</div>
        </div>

        <div class="amtex-pvf-preview-box">
          <div class="amtex-pvf-preview-label">Default</div>
          <div class="amtex-pvf-preview-value" id="amtexPvfPrevDefault">—</div>
        </div>

        <div class="amtex-pvf-muted">
          Keep variants consistent for clean SKU structure and accurate inventory.
        </div>
      </div>
    </div>

  </div>
</div>

@endsection

@section('scripts')
@parent
<script>
  function amtexPvfMoney(v){
    if(v === null || v === undefined || String(v).trim() === '') return '—';
    return '₹' + String(v);
  }

  function amtexPvfUpdatePreview(){
    const productText = $('#select_product_id option:selected').text() || '—';
    const cap = $('#capacity_label').val() || '—';
    const finish = $('#finish_label').val() || '—';
    const sku = $('#sku').val() || '—';

    const price = amtexPvfMoney($('#price').val());
    const compare = amtexPvfMoney($('#compare_price').val());

    const stock = $('#stock_qty').val();
    const stockText = (stock === null || stock === undefined || String(stock).trim()==='') ? '—' : stock;

    const defVal = $('#is_default').val();
    let defText = '—';
    if(defVal === 'yes' || defVal === '1') defText = 'Yes (Default)';
    if(defVal === 'no' || defVal === '0') defText = 'No';

    $('#amtexPvfPrevProduct').text(productText);
    $('#amtexPvfPrevCap').text(cap);
    $('#amtexPvfPrevFinish').text(finish);
    $('#amtexPvfPrevSku').text(sku);
    $('#amtexPvfPrevPrice').text(price);
    $('#amtexPvfPrevCompare').text(compare);
    $('#amtexPvfPrevStock').text(stockText);
    $('#amtexPvfPrevDefault').text(defText);
  }

  $(document).ready(function(){
    $(document).on('change input', '#select_product_id, #capacity_label, #finish_label, #sku, #price, #compare_price, #stock_qty, #is_default', amtexPvfUpdatePreview);
    amtexPvfUpdatePreview();
  });
</script>
@endsection
