@extends('layouts.admin')
@section('content')

<div class="amtex-prodf-page">

  {{-- Header --}}
  <div class="amtex-prodf-header">
    <div class="amtex-prodf-header-left">
      <div class="amtex-prodf-kicker">
        <span class="amtex-prodf-kdot"></span>
        Catalog
      </div>
      <h2 class="amtex-prodf-title">{{ trans('global.edit') }} {{ trans('cruds.product.title_singular') }}</h2>
      <p class="amtex-prodf-subtitle">Update product details, media, brochure and visibility controls.</p>
    </div>

    <div class="amtex-prodf-actions">
      <a href="{{ route('admin.products.index') }}" class="btn amtex-prodf-btn amtex-prodf-btn-light">
        <i class="fas fa-arrow-left"></i> Back
      </a>
    </div>
  </div>

  <div class="amtex-prodf-wrap">

    {{-- Form Card --}}
    <div class="amtex-prodf-card">
      <form method="POST" action="{{ route('admin.products.update', [$product->id]) }}" enctype="multipart/form-data" class="amtex-prodf-form">
        @method('PUT')
        @csrf

        {{-- Section: Catalog --}}
        <div class="amtex-prodf-section">
          <div class="amtex-prodf-section-head">
            <div class="amtex-prodf-section-title">
              <div class="amtex-prodf-ico"><i class="fas fa-box"></i></div>
              <div>
                <h4 class="amtex-prodf-h4">Catalog Details</h4>
                <div class="amtex-prodf-hint">Category, naming and clean URL slug.</div>
              </div>
            </div>
            <span class="amtex-prodf-chip">Required</span>
          </div>

          <div class="amtex-prodf-grid">

            {{-- Category --}}
            <div class="amtex-prodf-field amtex-prodf-span2">
              <label class="amtex-prodf-label required" for="select_category_id">{{ trans('cruds.product.fields.select_category') }}</label>
              <select
                class="form-control select2 amtex-prodf-control {{ $errors->has('select_category') ? 'is-invalid' : '' }}"
                name="select_category_id"
                id="select_category_id"
                required
              >
                @foreach($select_categories as $id => $entry)
                  <option value="{{ $id }}" {{ (old('select_category_id') ? old('select_category_id') : ($product->select_category->id ?? '')) == $id ? 'selected' : '' }}>
                    {{ $entry }}
                  </option>
                @endforeach
              </select>

              @if($errors->has('select_category'))
                <div class="invalid-feedback d-block">{{ $errors->first('select_category') }}</div>
              @endif
              <small class="amtex-prodf-help">{{ trans('cruds.product.fields.select_category_helper') }}</small>
            </div>

            {{-- Name --}}
            <div class="amtex-prodf-field">
              <label class="amtex-prodf-label required" for="name">{{ trans('cruds.product.fields.name') }}</label>

              <div class="amtex-prodf-input">
                <span class="amtex-prodf-input-ico"><i class="fas fa-tag"></i></span>
                <input
                  class="form-control amtex-prodf-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                  type="text"
                  name="name"
                  id="name"
                  value="{{ old('name', $product->name) }}"
                  placeholder="e.g. ABC CO2 Fire Extinguisher"
                  required
                >
              </div>

              @if($errors->has('name'))
                <div class="invalid-feedback d-block">{{ $errors->first('name') }}</div>
              @endif
              <small class="amtex-prodf-help">{{ trans('cruds.product.fields.name_helper') }}</small>
            </div>

            {{-- Slug --}}
            <div class="amtex-prodf-field">
              <label class="amtex-prodf-label required" for="slug">{{ trans('cruds.product.fields.slug') }}</label>

              <div class="amtex-prodf-input">
                <span class="amtex-prodf-input-ico"><i class="fas fa-link"></i></span>
                <input
                  class="form-control amtex-prodf-control {{ $errors->has('slug') ? 'is-invalid' : '' }}"
                  type="text"
                  name="slug"
                  id="slug"
                  value="{{ old('slug', $product->slug) }}"
                  placeholder="auto-generated from name"
                  required
                >
                <button type="button" class="amtex-prodf-mini" id="amtexProdRegenerate" title="Regenerate slug from name">
                  <i class="fas fa-sync-alt"></i>
                </button>
              </div>

              @if($errors->has('slug'))
                <div class="invalid-feedback d-block">{{ $errors->first('slug') }}</div>
              @endif
              <small class="amtex-prodf-help">{{ trans('cruds.product.fields.slug_helper') }}</small>

              <div class="amtex-prodf-inlinehint">
                <i class="fas fa-magic"></i>
                On edit, slug will NOT change when you edit name. Clear slug to enable auto mode.
              </div>
            </div>

          </div>
        </div>

        {{-- Section: Descriptions --}}
        <div class="amtex-prodf-section">
          <div class="amtex-prodf-section-head">
            <div class="amtex-prodf-section-title">
              <div class="amtex-prodf-ico"><i class="fas fa-align-left"></i></div>
              <div>
                <h4 class="amtex-prodf-h4">Descriptions</h4>
                <div class="amtex-prodf-hint">Short summary + full product details.</div>
              </div>
            </div>
            <span class="amtex-prodf-chip amtex-prodf-chip-alt">Optional</span>
          </div>

          <div class="amtex-prodf-grid amtex-prodf-grid-1">
            <div class="amtex-prodf-field">
              <label class="amtex-prodf-label" for="short_desc">{{ trans('cruds.product.fields.short_desc') }}</label>
              <textarea class="form-control ckeditor amtex-prodf-control {{ $errors->has('short_desc') ? 'is-invalid' : '' }}" name="short_desc" id="short_desc">{!! old('short_desc', $product->short_desc) !!}</textarea>
              @if($errors->has('short_desc'))
                <div class="invalid-feedback d-block">{{ $errors->first('short_desc') }}</div>
              @endif
              <small class="amtex-prodf-help">{{ trans('cruds.product.fields.short_desc_helper') }}</small>
            </div>

            <div class="amtex-prodf-field">
              <label class="amtex-prodf-label" for="description">{{ trans('cruds.product.fields.description') }}</label>
              <textarea class="form-control ckeditor amtex-prodf-control {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" id="description">{!! old('description', $product->description) !!}</textarea>
              @if($errors->has('description'))
                <div class="invalid-feedback d-block">{{ $errors->first('description') }}</div>
              @endif
              <small class="amtex-prodf-help">{{ trans('cruds.product.fields.description_helper') }}</small>
            </div>
          </div>
        </div>

        {{-- ✅ Section: PDP Builder (ADDED for edit) --}}
        <div class="amtex-prodf-section">
          <div class="amtex-prodf-section-head">
            <div class="amtex-prodf-section-title">
              <div class="amtex-prodf-ico"><i class="fas fa-layer-group"></i></div>
              <div>
                <h4 class="amtex-prodf-h4">Product Page Builder</h4>
                <div class="amtex-prodf-hint">Tags, pointers, highlights, works-on, recommended-for & technical table.</div>
              </div>
            </div>
            <span class="amtex-prodf-chip">PDP</span>
          </div>

          {{-- Tags --}}
          <div class="amtex-prodf-subcard">
            <div class="amtex-prodf-subhead">
              <h5 class="amtex-prodf-h5">1) Tags (before title)</h5>
              <button type="button" class="amtex-prodf-miniBtn" id="amtexTagAdd"><i class="fas fa-plus"></i> Add tag</button>
            </div>
            <div id="amtexTagsWrap" class="amtex-prodf-repeater"></div>

            @if($errors->has('pdp_tags'))
              <div class="invalid-feedback d-block">{{ $errors->first('pdp_tags') }}</div>
            @endif
            <small class="amtex-prodf-help">Example: Portable Mist, Stored Pressure Type, No Residue</small>
          </div>

          {{-- 3 pointers --}}
          <div class="amtex-prodf-subcard">
            <div class="amtex-prodf-subhead">
              <h5 class="amtex-prodf-h5">2) 3 pointers (after short description)</h5>
              <button type="button" class="amtex-prodf-miniBtn" id="amtexPointerAdd"><i class="fas fa-plus"></i> Add pointer</button>
            </div>
            <div id="amtexPointersWrap" class="amtex-prodf-repeater"></div>

            @if($errors->has('pdp_pointers'))
              <div class="invalid-feedback d-block">{{ $errors->first('pdp_pointers') }}</div>
            @endif
            <small class="amtex-prodf-help">Keep 3 (recommended). You can add more if needed.</small>
          </div>

          {{-- Key Highlights --}}
          <div class="amtex-prodf-subcard">
            <div class="amtex-prodf-subhead">
              <h5 class="amtex-prodf-h5">3) Key Highlights (multiple)</h5>
              <button type="button" class="amtex-prodf-miniBtn" id="amtexKeyAdd"><i class="fas fa-plus"></i> Add highlight</button>
            </div>
            <div id="amtexKeyWrap" class="amtex-prodf-repeater"></div>

            @if($errors->has('pdp_key_highlights'))
              <div class="invalid-feedback d-block">{{ $errors->first('pdp_key_highlights') }}</div>
            @endif
            <small class="amtex-prodf-help">Icon can be a Bootstrap icon class (e.g. <code>bi bi-leaf</code>). Title & text will show on product page.</small>
          </div>

          {{-- Works On --}}
          <div class="amtex-prodf-subcard">
            <div class="amtex-prodf-subhead">
              <h5 class="amtex-prodf-h5">4) Works on (multiple)</h5>
              <button type="button" class="amtex-prodf-miniBtn" id="amtexWorksAdd"><i class="fas fa-plus"></i> Add item</button>
            </div>
            <div id="amtexWorksWrap" class="amtex-prodf-repeater"></div>

            @if($errors->has('pdp_works_on'))
              <div class="invalid-feedback d-block">{{ $errors->first('pdp_works_on') }}</div>
            @endif
          </div>

          {{-- Recommended For --}}
          <div class="amtex-prodf-subcard">
            <div class="amtex-prodf-subhead">
              <h5 class="amtex-prodf-h5">5) Recommended For (two columns)</h5>
            </div>

            <div class="amtex-prodf-grid">
              <div class="amtex-prodf-field">
                <label class="amtex-prodf-label">Left column list</label>
                <textarea class="form-control amtex-prodf-control" rows="6" name="amtex_reco_left_raw" id="amtexRecoLeftRaw" placeholder="One item per line">{{ old('amtex_reco_left_raw') }}</textarea>
                <small class="amtex-prodf-help">We will convert lines into JSON array on submit.</small>
              </div>

              <div class="amtex-prodf-field">
                <label class="amtex-prodf-label">Right column list</label>
                <textarea class="form-control amtex-prodf-control" rows="6" name="amtex_reco_right_raw" id="amtexRecoRightRaw" placeholder="One item per line">{{ old('amtex_reco_right_raw') }}</textarea>
              </div>

              <div class="amtex-prodf-field">
                <label class="amtex-prodf-label" for="pdp_available_sizes">Available Sizes</label>
                <input class="form-control amtex-prodf-control {{ $errors->has('pdp_available_sizes') ? 'is-invalid' : '' }}" id="pdp_available_sizes" name="pdp_available_sizes" value="{{ old('pdp_available_sizes', $product->pdp_available_sizes ?? '') }}" placeholder="e.g. 1L, 2L, 3L, 4L, 6L, 9L">
                @if($errors->has('pdp_available_sizes'))
                  <div class="invalid-feedback d-block">{{ $errors->first('pdp_available_sizes') }}</div>
                @endif
              </div>

              <div class="amtex-prodf-field">
                <label class="amtex-prodf-label" for="pdp_available_variants">Available Variants</label>
                <input class="form-control amtex-prodf-control {{ $errors->has('pdp_available_variants') ? 'is-invalid' : '' }}" id="pdp_available_variants" name="pdp_available_variants" value="{{ old('pdp_available_variants', $product->pdp_available_variants ?? '') }}" placeholder="e.g. Stainless Steel Polish, Regular Fire Red">
                @if($errors->has('pdp_available_variants'))
                  <div class="invalid-feedback d-block">{{ $errors->first('pdp_available_variants') }}</div>
                @endif
              </div>
            </div>

            {{-- Hidden arrays --}}
            <input type="hidden" name="pdp_recommended_for_left" id="amtexRecoLeftJson" value="{{ old('pdp_recommended_for_left', $product->pdp_recommended_for_left ?? '') }}">
            <input type="hidden" name="pdp_recommended_for_right" id="amtexRecoRightJson" value="{{ old('pdp_recommended_for_right', $product->pdp_recommended_for_right ?? '') }}">

            @if($errors->has('pdp_recommended_for_left'))
              <div class="invalid-feedback d-block">{{ $errors->first('pdp_recommended_for_left') }}</div>
            @endif
            @if($errors->has('pdp_recommended_for_right'))
              <div class="invalid-feedback d-block">{{ $errors->first('pdp_recommended_for_right') }}</div>
            @endif
          </div>

          {{-- ✅ Technical Table (Responsive + Friendly, same as create) --}}
          <div class="amtex-prodf-subcard">
            <div class="amtex-prodf-subhead">
              <h5 class="amtex-prodf-h5">6) Technical &amp; Performance Table</h5>
              <div class="d-flex gap-2 flex-wrap">
                <button type="button" class="amtex-prodf-miniBtn" id="amtexTechAddCol"><i class="fas fa-plus"></i> Add column</button>
                <button type="button" class="amtex-prodf-miniBtn" id="amtexTechAddRow"><i class="fas fa-plus"></i> Add row</button>
                <button type="button" class="amtex-prodf-miniBtn" id="amtexTechCompact"><i class="fas fa-mobile-alt"></i> Compact view</button>
                <button type="button" class="amtex-prodf-miniBtn" id="amtexTechResetView"><i class="fas fa-expand"></i> Full view</button>
              </div>
            </div>

            <div class="amtex-prodf-techbar">
              <div class="amtex-prodf-techbar-left">
                <div class="amtex-prodf-techbar-title">Table editor</div>
                <div class="amtex-prodf-techbar-sub">Tip: On mobile, use Compact view. You can also scroll horizontally.</div>
              </div>
              <div class="amtex-prodf-techbar-right">
                <div class="amtex-prodf-techbar-search">
                  <i class="fas fa-search"></i>
                  <input type="text" id="amtexTechSearch" class="form-control amtex-prodf-control" placeholder="Search (parameter/value)">
                </div>
              </div>
            </div>

            <div class="amtex-prodf-techShell" id="amtexTechShell">
              <div class="amtex-prodf-techScroll" id="amtexTechScroll">
                <div id="amtexTechWrap" class="amtex-prodf-tech"></div>
              </div>

              <div id="amtexTechCards" class="amtex-prodf-techCards d-none"></div>
            </div>

            <input type="hidden" name="pdp_tech_table" id="amtexTechJson" value="{{ old('pdp_tech_table', $product->pdp_tech_table ?? '') }}">

            @if($errors->has('pdp_tech_table'))
              <div class="invalid-feedback d-block">{{ $errors->first('pdp_tech_table') }}</div>
            @endif
          </div>
        </div>

        {{-- Section: Pricing + Meta --}}
        <div class="amtex-prodf-section">
          <div class="amtex-prodf-section-head">
            <div class="amtex-prodf-section-title">
              <div class="amtex-prodf-ico"><i class="fas fa-indian-rupee-sign"></i></div>
              <div>
                <h4 class="amtex-prodf-h4">Pricing & Meta</h4>
                <div class="amtex-prodf-hint">Pricing, SKU, ratings, badge and dispatch text.</div>
              </div>
            </div>
            <span class="amtex-prodf-chip">Required</span>
          </div>

          <div class="amtex-prodf-grid">

            {{-- Base Price --}}
            <div class="amtex-prodf-field">
              <label class="amtex-prodf-label required" for="base_price">{{ trans('cruds.product.fields.base_price') }}</label>
              <div class="amtex-prodf-input">
                <span class="amtex-prodf-input-ico">₹</span>
                <input
                  class="form-control amtex-prodf-control {{ $errors->has('base_price') ? 'is-invalid' : '' }}"
                  type="text"
                  name="base_price"
                  id="base_price"
                  value="{{ old('base_price', $product->base_price) }}"
                  placeholder="e.g. 1499"
                  required
                >
              </div>
              @if($errors->has('base_price'))
                <div class="invalid-feedback d-block">{{ $errors->first('base_price') }}</div>
              @endif
              <small class="amtex-prodf-help">{{ trans('cruds.product.fields.base_price_helper') }}</small>
            </div>

            {{-- Compare Price --}}
            <div class="amtex-prodf-field">
              <label class="amtex-prodf-label required" for="compare_price">{{ trans('cruds.product.fields.compare_price') }}</label>
              <div class="amtex-prodf-input">
                <span class="amtex-prodf-input-ico">₹</span>
                <input
                  class="form-control amtex-prodf-control {{ $errors->has('compare_price') ? 'is-invalid' : '' }}"
                  type="text"
                  name="compare_price"
                  id="compare_price"
                  value="{{ old('compare_price', $product->compare_price) }}"
                  placeholder="e.g. 1999"
                  required
                >
              </div>
              @if($errors->has('compare_price'))
                <div class="invalid-feedback d-block">{{ $errors->first('compare_price') }}</div>
              @endif
              <small class="amtex-prodf-help">{{ trans('cruds.product.fields.compare_price_helper') }}</small>
            </div>

            {{-- Badge --}}
            <div class="amtex-prodf-field">
              <label class="amtex-prodf-label required" for="badge">{{ trans('cruds.product.fields.badge') }}</label>
              <select class="form-control amtex-prodf-control {{ $errors->has('badge') ? 'is-invalid' : '' }}" name="badge" id="badge" required>
                <option value disabled {{ old('badge', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                @foreach(App\Models\Product::BADGE_SELECT as $key => $label)
                  <option value="{{ $key }}" {{ old('badge', $product->badge) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
              </select>
              @if($errors->has('badge'))
                <div class="invalid-feedback d-block">{{ $errors->first('badge') }}</div>
              @endif
              <small class="amtex-prodf-help">{{ trans('cruds.product.fields.badge_helper') }}</small>
            </div>

            {{-- Dispatch --}}
            <div class="amtex-prodf-field">
              <label class="amtex-prodf-label required" for="dispatch_text">{{ trans('cruds.product.fields.dispatch_text') }}</label>
              <div class="amtex-prodf-input">
                <span class="amtex-prodf-input-ico"><i class="fas fa-truck"></i></span>
                <input
                  class="form-control amtex-prodf-control {{ $errors->has('dispatch_text') ? 'is-invalid' : '' }}"
                  type="text"
                  name="dispatch_text"
                  id="dispatch_text"
                  value="{{ old('dispatch_text', $product->dispatch_text) }}"
                  placeholder="e.g. Dispatch in 24–48 hours"
                  required
                >
              </div>
              @if($errors->has('dispatch_text'))
                <div class="invalid-feedback d-block">{{ $errors->first('dispatch_text') }}</div>
              @endif
              <small class="amtex-prodf-help">{{ trans('cruds.product.fields.dispatch_text_helper') }}</small>
            </div>

            {{-- Rating Avg --}}
            <div class="amtex-prodf-field">
              <label class="amtex-prodf-label" for="rating_avg">{{ trans('cruds.product.fields.rating_avg') }}</label>
              <input class="form-control amtex-prodf-control {{ $errors->has('rating_avg') ? 'is-invalid' : '' }}" type="text" name="rating_avg" id="rating_avg" value="{{ old('rating_avg', $product->rating_avg) }}" placeholder="e.g. 4.8">
              @if($errors->has('rating_avg'))
                <div class="invalid-feedback d-block">{{ $errors->first('rating_avg') }}</div>
              @endif
              <small class="amtex-prodf-help">{{ trans('cruds.product.fields.rating_avg_helper') }}</small>
            </div>

            {{-- Rating Count --}}
            <div class="amtex-prodf-field">
              <label class="amtex-prodf-label" for="rating_count">{{ trans('cruds.product.fields.rating_count') }}</label>
              <input class="form-control amtex-prodf-control {{ $errors->has('rating_count') ? 'is-invalid' : '' }}" type="text" name="rating_count" id="rating_count" value="{{ old('rating_count', $product->rating_count) }}" placeholder="e.g. 120">
              @if($errors->has('rating_count'))
                <div class="invalid-feedback d-block">{{ $errors->first('rating_count') }}</div>
              @endif
              <small class="amtex-prodf-help">{{ trans('cruds.product.fields.rating_count_helper') }}</small>
            </div>

            {{-- SKU --}}
            <div class="amtex-prodf-field">
              <label class="amtex-prodf-label" for="sku">{{ trans('cruds.product.fields.sku') }}</label>
              <input class="form-control amtex-prodf-control {{ $errors->has('sku') ? 'is-invalid' : '' }}" type="text" name="sku" id="sku" value="{{ old('sku', $product->sku) }}" placeholder="e.g. AMTEX-ABC-01">
              @if($errors->has('sku'))
                <div class="invalid-feedback d-block">{{ $errors->first('sku') }}</div>
              @endif
              <small class="amtex-prodf-help">{{ trans('cruds.product.fields.sku_helper') }}</small>
            </div>

            {{-- Featured --}}
            <div class="amtex-prodf-field">
              <label class="amtex-prodf-label required" for="is_featured">{{ trans('cruds.product.fields.is_featured') }}</label>
              <select class="form-control amtex-prodf-control {{ $errors->has('is_featured') ? 'is-invalid' : '' }}" name="is_featured" id="is_featured" required>
                <option value disabled {{ old('is_featured', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                @foreach(App\Models\Product::IS_FEATURED_SELECT as $key => $label)
                  <option value="{{ $key }}" {{ old('is_featured', $product->is_featured) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
              </select>
              @if($errors->has('is_featured'))
                <div class="invalid-feedback d-block">{{ $errors->first('is_featured') }}</div>
              @endif
              <small class="amtex-prodf-help">{{ trans('cruds.product.fields.is_featured_helper') }}</small>
            </div>

            {{-- Active --}}
            <div class="amtex-prodf-field">
              <label class="amtex-prodf-label required" for="is_active">{{ trans('cruds.product.fields.is_active') }}</label>
              <select class="form-control amtex-prodf-control {{ $errors->has('is_active') ? 'is-invalid' : '' }}" name="is_active" id="is_active" required>
                <option value disabled {{ old('is_active', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                @foreach(App\Models\Product::IS_ACTIVE_SELECT as $key => $label)
                  <option value="{{ $key }}" {{ old('is_active', $product->is_active) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
              </select>
              @if($errors->has('is_active'))
                <div class="invalid-feedback d-block">{{ $errors->first('is_active') }}</div>
              @endif
              <small class="amtex-prodf-help">{{ trans('cruds.product.fields.is_active_helper') }}</small>
            </div>

          </div>
        </div>

        {{-- Section: Media --}}
        <div class="amtex-prodf-section">
          <div class="amtex-prodf-section-head">
            <div class="amtex-prodf-section-title">
              <div class="amtex-prodf-ico"><i class="fas fa-photo-film"></i></div>
              <div>
                <h4 class="amtex-prodf-h4">Media</h4>
                <div class="amtex-prodf-hint">Main image and optional brochure PDF.</div>
              </div>
            </div>
            <span class="amtex-prodf-chip amtex-prodf-chip-alt">Recommended</span>
          </div>

          <div class="amtex-prodf-grid">

            {{-- Main Image --}}
            <div class="amtex-prodf-field amtex-prodf-span2">
              <label class="amtex-prodf-label required" for="main_image">{{ trans('cruds.product.fields.main_image') }}</label>

              <div class="amtex-prodf-dropwrap {{ $errors->has('main_image') ? 'amtex-prodf-dropwrap-error' : '' }}">
                <div class="needsclick dropzone amtex-prodf-dropzone" id="main_image-dropzone"></div>

                <div class="amtex-prodf-dropnote">
                  <div class="amtex-prodf-dropnote-title">
                    <i class="fas fa-cloud-upload-alt"></i> Upload / Replace Main Image
                  </div>
                  <div class="amtex-prodf-dropnote-sub">
                    JPG/PNG/GIF • Max 10MB • 1 image only
                  </div>
                </div>
              </div>

              @if($errors->has('main_image'))
                <div class="amtex-prodf-error">{{ $errors->first('main_image') }}</div>
              @endif
              <small class="amtex-prodf-help">{{ trans('cruds.product.fields.main_image_helper') }}</small>
            </div>

            {{-- Brochure PDF --}}
            <div class="amtex-prodf-field amtex-prodf-span2">
              <label class="amtex-prodf-label" for="brochure_pdf">{{ trans('cruds.product.fields.brochure_pdf') }}</label>

              <div class="amtex-prodf-dropwrap {{ $errors->has('brochure_pdf') ? 'amtex-prodf-dropwrap-error' : '' }}">
                <div class="needsclick dropzone amtex-prodf-dropzone amtex-prodf-dropzone-file" id="brochure_pdf-dropzone"></div>

                <div class="amtex-prodf-dropnote">
                  <div class="amtex-prodf-dropnote-title">
                    <i class="fas fa-file-pdf"></i> Upload / Replace Brochure PDF
                  </div>
                  <div class="amtex-prodf-dropnote-sub">
                    PDF • Max 30MB • 1 file only
                  </div>
                </div>
              </div>

              @if($errors->has('brochure_pdf'))
                <div class="amtex-prodf-error">{{ $errors->first('brochure_pdf') }}</div>
              @endif
              <small class="amtex-prodf-help">{{ trans('cruds.product.fields.brochure_pdf_helper') }}</small>
            </div>

          </div>
        </div>

        {{-- Footer actions --}}
        <div class="amtex-prodf-footer">
          <a href="{{ route('admin.products.index') }}" class="btn amtex-prodf-btn amtex-prodf-btn-light">
            Cancel
          </a>

          <button class="btn amtex-prodf-btn amtex-prodf-btn-primary" type="submit">
            <i class="fas fa-save"></i> Update
          </button>
        </div>

      </form>
    </div>

    {{-- Preview Card --}}
    <div class="amtex-prodf-side">
      <div class="amtex-prodf-card amtex-prodf-preview">
        <div class="amtex-prodf-preview-head">
          <div class="amtex-prodf-preview-title">
            <div class="amtex-prodf-ico amtex-prodf-ico-mini"><i class="fas fa-eye"></i></div>
            <h4 class="amtex-prodf-h4">Quick Preview</h4>
          </div>
          <span class="amtex-prodf-chip">Live</span>
        </div>

        <div class="amtex-prodf-preview-box">
          <div class="amtex-prodf-preview-label">Name</div>
          <div class="amtex-prodf-preview-value" id="amtexProdPrevName">—</div>
        </div>

        <div class="amtex-prodf-preview-box">
          <div class="amtex-prodf-preview-label">Slug</div>
          <div class="amtex-prodf-preview-value" id="amtexProdPrevSlug">—</div>
        </div>

        <div class="amtex-prodf-preview-box">
          <div class="amtex-prodf-preview-label">Category</div>
          <div class="amtex-prodf-preview-value" id="amtexProdPrevCat">—</div>
        </div>

        <div class="amtex-prodf-preview-box">
          <div class="amtex-prodf-preview-label">Price</div>
          <div class="amtex-prodf-preview-value" id="amtexProdPrevPrice">—</div>
        </div>

        <div class="amtex-prodf-preview-box">
          <div class="amtex-prodf-preview-label">Status</div>
          <div class="amtex-prodf-preview-value" id="amtexProdPrevStatus">—</div>
        </div>

        {{-- ✅ preload existing image/pdf into preview (fallback if none) --}}
        <div class="amtex-prodf-preview-img" id="amtexProdPrevImg">
          @if(isset($product) && $product->main_image && !empty($product->main_image->url))
            <img src="{{ $product->main_image->url }}" alt="Preview" />
          @else
            <div class="amtex-prodf-preview-imgtext"><i class="fas fa-image"></i> Image preview will appear after upload</div>
          @endif
        </div>

        <div class="amtex-prodf-preview-file" id="amtexProdPrevPdf">
          @if(isset($product) && $product->brochure_pdf)
            <div class="amtex-prodf-preview-filetext"><i class="fas fa-file-pdf"></i> {{ $product->brochure_pdf->file_name ?? 'Brochure.pdf' }} (existing)</div>
          @else
            <div class="amtex-prodf-preview-filetext"><i class="fas fa-file-pdf"></i> Brochure PDF will appear after upload</div>
          @endif
        </div>

        <div class="amtex-prodf-muted">
          Keep titles and slugs consistent for clean URLs and better SEO.
        </div>
      </div>
    </div>

  </div>
</div>

@endsection

@section('scripts')
@parent
<script>
  // -------------------------------
  // CKEditor Upload Adapter (Edit)
  // -------------------------------
  $(document).ready(function () {
    function SimpleUploadAdapter(editor) {
      editor.plugins.get('FileRepository').createUploadAdapter = function(loader) {
        return {
          upload: function() {
            return loader.file.then(function (file) {
              return new Promise(function(resolve, reject) {
                var xhr = new XMLHttpRequest();
                xhr.open('POST', '{{ route('admin.products.storeCKEditorImages') }}', true);
                xhr.setRequestHeader('x-csrf-token', window._token);
                xhr.setRequestHeader('Accept', 'application/json');
                xhr.responseType = 'json';

                var genericErrorText = `Couldn't upload file: ${ file.name }.`;

                xhr.addEventListener('error', function() { reject(genericErrorText) });
                xhr.addEventListener('abort', function() { reject() });
                xhr.addEventListener('load', function() {
                  var response = xhr.response;

                  if (!response || xhr.status !== 201) {
                    return reject(response && response.message ? `${genericErrorText}\n${xhr.status} ${response.message}` : `${genericErrorText}\n ${xhr.status} ${xhr.statusText}`);
                  }

                  $('.amtex-prodf-form').append('<input type="hidden" name="ck-media[]" value="' + response.id + '">');
                  resolve({ default: response.url });
                });

                if (xhr.upload) {
                  xhr.upload.addEventListener('progress', function(e) {
                    if (e.lengthComputable) {
                      loader.uploadTotal = e.total;
                      loader.uploaded = e.loaded;
                    }
                  });
                }

                var data = new FormData();
                data.append('upload', file);
                data.append('crud_id', '{{ $product->id ?? 0 }}');
                xhr.send(data);
              });
            })
          }
        };
      }
    }

    var allEditors = document.querySelectorAll('.ckeditor');
    for (var i = 0; i < allEditors.length; ++i) {
      ClassicEditor.create(allEditors[i], { extraPlugins: [SimpleUploadAdapter] });
    }
  });
</script>

<script>
  // -------------------------------
  // Dropzone: Main Image (Edit)
  // -------------------------------
  Dropzone.options.mainImageDropzone = {
    url: '{{ route('admin.products.storeMedia') }}',
    maxFilesize: 10,
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    maxFiles: 1,
    addRemoveLinks: true,
    headers: { 'X-CSRF-TOKEN': "{{ csrf_token() }}" },
    params: { size: 10, width: 4096, height: 4096 },

    success: function (file, response) {
      const $form = $('.amtex-prodf-form');
      $form.find('input[name="main_image"]').remove();
      $form.append('<input type="hidden" name="main_image" value="' + response.name + '">');

      if (file && file.dataURL) {
        $('#amtexProdPrevImg').html('<img src="' + file.dataURL + '" alt="Preview" />');
      }
    },

    removedfile: function (file) {
      if (file.previewElement) file.previewElement.remove();
      if (file.status !== 'error') {
        const $form = $('.amtex-prodf-form');
        $form.find('input[name="main_image"]').remove();
        this.options.maxFiles = this.options.maxFiles + 1;
      }
      $('#amtexProdPrevImg').html('<div class="amtex-prodf-preview-imgtext"><i class="fas fa-image"></i> Image preview will appear after upload</div>');
    },

    init: function () {
@if(isset($product) && $product->main_image)
      var file = {!! json_encode($product->main_image) !!};

      this.options.addedfile.call(this, file);

      var thumb = file.preview ?? file.preview_url ?? (file.url ? file.url : null);
      if (thumb) {
        this.options.thumbnail.call(this, file, thumb);
        $('#amtexProdPrevImg').html('<img src="' + thumb + '" alt="Preview" />');
      }

      if (file.previewElement) file.previewElement.classList.add('dz-complete');

      $('.amtex-prodf-form').append('<input type="hidden" name="main_image" value="' + file.file_name + '">');
      this.options.maxFiles = this.options.maxFiles - 1;
@endif
    },

    error: function (file, response) {
      let message = ($.type(response) === 'string') ? response : (response.errors?.file || 'Upload failed');
      if (file.previewElement) file.previewElement.classList.add('dz-error');
      let _ref = file.previewElement ? file.previewElement.querySelectorAll('[data-dz-errormessage]') : [];
      for (let i = 0; i < _ref.length; i++) {
        _ref[i].textContent = message;
      }
    }
  };
</script>

<script>
  // -------------------------------
  // Dropzone: Brochure PDF (Edit)
  // -------------------------------
  Dropzone.options.brochurePdfDropzone = {
    url: '{{ route('admin.products.storeMedia') }}',
    maxFilesize: 30,
    maxFiles: 1,
    addRemoveLinks: true,
    headers: { 'X-CSRF-TOKEN': "{{ csrf_token() }}" },
    params: { size: 30 },

    success: function (file, response) {
      const $form = $('.amtex-prodf-form');
      $form.find('input[name="brochure_pdf"]').remove();
      $form.append('<input type="hidden" name="brochure_pdf" value="' + response.name + '">');

      const fileName = file?.name ? file.name : 'Brochure.pdf';
      $('#amtexProdPrevPdf').html('<div class="amtex-prodf-preview-filetext"><i class="fas fa-file-pdf"></i> ' + fileName + ' uploaded</div>');
    },

    removedfile: function (file) {
      if (file.previewElement) file.previewElement.remove();
      if (file.status !== 'error') {
        const $form = $('.amtex-prodf-form');
        $form.find('input[name="brochure_pdf"]').remove();
        this.options.maxFiles = this.options.maxFiles + 1;
      }
      $('#amtexProdPrevPdf').html('<div class="amtex-prodf-preview-filetext"><i class="fas fa-file-pdf"></i> Brochure PDF will appear after upload</div>');
    },

    init: function () {
@if(isset($product) && $product->brochure_pdf)
      var file = {!! json_encode($product->brochure_pdf) !!};

      this.options.addedfile.call(this, file);
      if (file.previewElement) file.previewElement.classList.add('dz-complete');

      $('.amtex-prodf-form').append('<input type="hidden" name="brochure_pdf" value="' + file.file_name + '">');
      this.options.maxFiles = this.options.maxFiles - 1;

      var existingName = file.file_name ? file.file_name : 'Brochure.pdf';
      $('#amtexProdPrevPdf').html('<div class="amtex-prodf-preview-filetext"><i class="fas fa-file-pdf"></i> ' + existingName + ' (existing)</div>');
@endif
    },

    error: function (file, response) {
      let message = ($.type(response) === 'string') ? response : (response.errors?.file || 'Upload failed');
      if (file.previewElement) file.previewElement.classList.add('dz-error');
      let _ref = file.previewElement ? file.previewElement.querySelectorAll('[data-dz-errormessage]') : [];
      for (let i = 0; i < _ref.length; i++) {
        _ref[i].textContent = message;
      }
    }
  };
</script>

<script>
  // -------------------------------
  // Slug auto-generate (Edit)
  // -------------------------------
  let amtexProdSlugManuallyEdited = false;

  function amtexProdSlugify(text) {
    return (text || '')
      .toString()
      .trim()
      .toLowerCase()
      .replace(/&/g, ' and ')
      .replace(/[^a-z0-9]+/g, '-')
      .replace(/^-+|-+$/g, '')
      .replace(/-{2,}/g, '-');
  }

  function amtexProdUpdatePreview() {
    const name = $('#name').val() || '—';
    const slug = $('#slug').val() || '—';
    const catText = $('#select_category_id option:selected').text() || '—';
    const base = $('#base_price').val() || '';
    const comp = $('#compare_price').val() || '';
    const statusVal = $('#is_active').val();

    let statusText = '—';
    if (statusVal === 'yes' || statusVal === '1') statusText = 'Active';
    if (statusVal === 'no' || statusVal === '0') statusText = 'Inactive';

    const priceText = base ? ('₹' + base + (comp ? ' (₹' + comp + ')' : '')) : '—';

    $('#amtexProdPrevName').text(name);
    $('#amtexProdPrevSlug').text(slug);
    $('#amtexProdPrevCat').text(catText);
    $('#amtexProdPrevPrice').text(priceText);
    $('#amtexProdPrevStatus').text(statusText);
  }

  $(document).ready(function () {
    if ($('#slug').val().trim() !== '') amtexProdSlugManuallyEdited = true;
    amtexProdUpdatePreview();
  });

  $('#slug').on('input', function () {
    amtexProdSlugManuallyEdited = $(this).val().trim().length > 0;
    amtexProdUpdatePreview();
  });

  $('#name').on('input', function () {
    if (!amtexProdSlugManuallyEdited) {
      $('#slug').val(amtexProdSlugify($(this).val()));
    }
    amtexProdUpdatePreview();
  });

  $('#amtexProdRegenerate').on('click', function () {
    amtexProdSlugManuallyEdited = false;
    $('#slug').val(amtexProdSlugify($('#name').val()));
    amtexProdUpdatePreview();
    $('#slug').trigger('focus');
  });

  $('#slug').on('blur', function () {
    if ($(this).val().trim() === '') {
      amtexProdSlugManuallyEdited = false;
      $('#slug').val(amtexProdSlugify($('#name').val()));
      amtexProdUpdatePreview();
    }
  });

  $(document).on('change', '#select_category_id, #is_active', amtexProdUpdatePreview);
  $(document).on('input', '#base_price, #compare_price', amtexProdUpdatePreview);
</script>

<script>
  /**
   * ✅ PDP Builder scripts (same responsive tech editor as create)
   */
  function amtexEscapeHtml(s){ return (s||'').replace(/[&<>"']/g, m => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#039;'}[m])); }
  function amtexAddRow(wrapper, html){ wrapper.insertAdjacentHTML('beforeend', html); }
  function amtexBindRemove(){ document.querySelectorAll('[data-amtex-remove]').forEach(btn=>{ btn.onclick = () => btn.closest('.amtex-prodf-row').remove(); }); }
  function amtexTryParseJson(val){ try { return JSON.parse(val); } catch(e){ return null; } }
  function amtexNormalize(s){ return (s||'').toString().toLowerCase().trim(); }
  function amtexLinesToArray(text){
    return (text || '')
      .split('\n')
      .map(s=>s.trim())
      .filter(Boolean);
  }

  // ---------- TAGS ----------
  const tagsWrap = document.getElementById('amtexTagsWrap');
  document.getElementById('amtexTagAdd').addEventListener('click', ()=>{
    amtexAddRow(tagsWrap, `
      <div class="amtex-prodf-row">
        <input class="form-control amtex-prodf-control" name="pdp_tags[]" placeholder="Tag text (e.g. Portable Mist)">
        <button type="button" class="amtex-prodf-rowDel" data-amtex-remove><i class="fas fa-times"></i></button>
      </div>
    `);
    amtexBindRemove();
  });

  // ---------- POINTERS ----------
  const pointersWrap = document.getElementById('amtexPointersWrap');
  document.getElementById('amtexPointerAdd').addEventListener('click', ()=>{
    amtexAddRow(pointersWrap, `
      <div class="amtex-prodf-row">
        <input class="form-control amtex-prodf-control" name="pdp_pointers[]" placeholder="Pointer (e.g. Stored pressure type)">
        <button type="button" class="amtex-prodf-rowDel" data-amtex-remove><i class="fas fa-times"></i></button>
      </div>
    `);
    amtexBindRemove();
  });

  // ---------- KEY HIGHLIGHTS ----------
  const keyWrap = document.getElementById('amtexKeyWrap');
  document.getElementById('amtexKeyAdd').addEventListener('click', ()=>{
    const idx = keyWrap.querySelectorAll('.amtex-prodf-row').length;
    amtexAddRow(keyWrap, `
      <div class="amtex-prodf-row amtex-prodf-row3">
        <input class="form-control amtex-prodf-control" name="pdp_key_highlights[${idx}][icon]" placeholder="Icon class (e.g. bi bi-leaf)">
        <input class="form-control amtex-prodf-control" name="pdp_key_highlights[${idx}][title]" placeholder="Title">
        <input class="form-control amtex-prodf-control" name="pdp_key_highlights[${idx}][text]" placeholder="Short text">
        <button type="button" class="amtex-prodf-rowDel" data-amtex-remove><i class="fas fa-times"></i></button>
      </div>
    `);
    amtexBindRemove();
  });

  // ---------- WORKS ON ----------
  const worksWrap = document.getElementById('amtexWorksWrap');
  document.getElementById('amtexWorksAdd').addEventListener('click', ()=>{
    const idx = worksWrap.querySelectorAll('.amtex-prodf-row').length;
    amtexAddRow(worksWrap, `
      <div class="amtex-prodf-row amtex-prodf-row3">
        <input class="form-control amtex-prodf-control" name="pdp_works_on[${idx}][icon]" placeholder="Icon class (e.g. bi bi-house-door)">
        <input class="form-control amtex-prodf-control" name="pdp_works_on[${idx}][title]" placeholder="Title (e.g. Class-A)">
        <input class="form-control amtex-prodf-control" name="pdp_works_on[${idx}][text]" placeholder="Text (e.g. Solid combustibles)">
        <button type="button" class="amtex-prodf-rowDel" data-amtex-remove><i class="fas fa-times"></i></button>
      </div>
    `);
    amtexBindRemove();
  });

  // ---------- TECH TABLE (Responsive + Friendly) ----------
  const techWrap = document.getElementById('amtexTechWrap');
  const techCards = document.getElementById('amtexTechCards');
  const techShell = document.getElementById('amtexTechShell');
  const techScroll = document.getElementById('amtexTechScroll');
  const techSearch = document.getElementById('amtexTechSearch');

  let techState = { columns: [], rows: [] };
  let techCompactMode = false;
  let techFilter = '';

  function renderTechTable(){
    const cols = techState.columns;
    const rows = techState.rows;

    let html = `
      <div class="amtex-prodf-techTable">
        <div class="amtex-prodf-techRow amtex-prodf-techRowHead">
          <div class="amtex-prodf-techCell amtex-prodf-techCellParam">
            <div class="amtex-prodf-techHeadLabel">Parameter</div>
          </div>
          ${cols.map((c,i)=>`
            <div class="amtex-prodf-techCell amtex-prodf-techCellCol">
              <div class="amtex-prodf-techColHead">
                <input class="form-control amtex-prodf-control" value="${amtexEscapeHtml(c)}" data-tech-col="${i}" placeholder="Column title">
                <button type="button" class="amtex-prodf-chipDel" data-tech-delcol="${i}" title="Remove column">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          `).join('')}
        </div>
    `;

    const filteredRows = rows.filter(r=>{
      if (!techFilter) return true;
      const hay = [r.parameter, ...(r.values||[])].join(' ');
      return amtexNormalize(hay).includes(techFilter);
    });

    filteredRows.forEach((r,ri)=>{
      html += `
        <div class="amtex-prodf-techRow">
          <div class="amtex-prodf-techCell amtex-prodf-techCellParam">
            <div class="amtex-prodf-techParamWrap">
              <input class="form-control amtex-prodf-control" value="${amtexEscapeHtml(r.parameter||'')}" placeholder="Parameter" data-tech-param="${ri}">
              <button type="button" class="amtex-prodf-rowDel amtex-prodf-rowDelSmall" data-tech-delrow="${ri}" title="Remove row">
                <i class="fas fa-times"></i>
              </button>
            </div>
          </div>
          ${cols.map((c,ci)=>`
            <div class="amtex-prodf-techCell amtex-prodf-techCellCol">
              <input class="form-control amtex-prodf-control"
                value="${amtexEscapeHtml((r.values && r.values[ci]) ? r.values[ci] : '')}"
                placeholder="Value"
                data-tech-val="${ri}:${ci}">
            </div>
          `).join('')}
        </div>
      `;
    });

    if (!filteredRows.length) {
      html += `<div class="amtex-prodf-techEmpty">No matching rows for "<b>${amtexEscapeHtml(techFilter)}</b>".</div>`;
    }

    html += `</div>`;
    techWrap.innerHTML = html;

    techWrap.querySelectorAll('[data-tech-col]').forEach(inp=>{
      inp.oninput = () => { techState.columns[inp.dataset.techCol] = inp.value; renderTechCards(); };
    });

    techWrap.querySelectorAll('[data-tech-delcol]').forEach(btn=>{
      btn.onclick = () => {
        const ci = parseInt(btn.dataset.techDelcol,10);
        techState.columns.splice(ci,1);
        techState.rows = techState.rows.map(r=>{
          r.values = (r.values||[]);
          r.values.splice(ci,1);
          return r;
        });
        renderTech();
      };
    });

    techWrap.querySelectorAll('[data-tech-param]').forEach(inp=>{
      inp.oninput = () => { techState.rows[inp.dataset.techParam].parameter = inp.value; renderTechCards(); };
    });

    techWrap.querySelectorAll('[data-tech-val]').forEach(inp=>{
      inp.oninput = () => {
        const [ri,ci] = inp.dataset.techVal.split(':').map(n=>parseInt(n,10));
        techState.rows[ri].values = techState.rows[ri].values || [];
        techState.rows[ri].values[ci] = inp.value;
      };
    });

    techWrap.querySelectorAll('[data-tech-delrow]').forEach(btn=>{
      btn.onclick = () => {
        const ri = parseInt(btn.dataset.techDelrow,10);
        techState.rows.splice(ri,1);
        renderTech();
      };
    });
  }

  function renderTechCards(){
    const cols = techState.columns;
    const rows = techState.rows;

    const filteredRows = rows.filter(r=>{
      if (!techFilter) return true;
      const hay = [r.parameter, ...(r.values||[])].join(' ');
      return amtexNormalize(hay).includes(techFilter);
    });

    let html = '';
    filteredRows.forEach((r,ri)=>{
      html += `
        <div class="amtex-prodf-techCard">
          <div class="amtex-prodf-techCardHead">
            <div class="amtex-prodf-techCardTitle">${amtexEscapeHtml(r.parameter || 'Parameter')}</div>
            <button type="button" class="amtex-prodf-rowDel amtex-prodf-rowDelSmall" data-tech-delrow="${ri}" title="Remove row">
              <i class="fas fa-times"></i>
            </button>
          </div>
          <div class="amtex-prodf-techCardBody">
            ${cols.map((c,ci)=>`
              <div class="amtex-prodf-techCardItem">
                <div class="amtex-prodf-techCardLabel">${amtexEscapeHtml(c || ('Column ' + (ci+1)))}</div>
                <input class="form-control amtex-prodf-control"
                  value="${amtexEscapeHtml((r.values && r.values[ci]) ? r.values[ci] : '')}"
                  placeholder="Value"
                  data-tech-val="${ri}:${ci}">
              </div>
            `).join('')}
          </div>
        </div>
      `;
    });

    if (!filteredRows.length) {
      html = `<div class="amtex-prodf-techEmpty">No matching rows for "<b>${amtexEscapeHtml(techFilter)}</b>".</div>`;
    }

    techCards.innerHTML = html;

    techCards.querySelectorAll('[data-tech-val]').forEach(inp=>{
      inp.oninput = () => {
        const [ri,ci] = inp.dataset.techVal.split(':').map(n=>parseInt(n,10));
        techState.rows[ri].values = techState.rows[ri].values || [];
        techState.rows[ri].values[ci] = inp.value;
      };
    });
    techCards.querySelectorAll('[data-tech-delrow]').forEach(btn=>{
      btn.onclick = () => {
        const ri = parseInt(btn.dataset.techDelrow,10);
        techState.rows.splice(ri,1);
        renderTech();
      };
    });
  }

  function renderTech(){
    if (techCompactMode) {
      techScroll.classList.add('d-none');
      techCards.classList.remove('d-none');
      renderTechCards();
    } else {
      techCards.classList.add('d-none');
      techScroll.classList.remove('d-none');
      renderTechTable();
    }
  }

  document.getElementById('amtexTechAddCol').addEventListener('click', ()=>{
    techState.columns.push('New Column');
    techState.rows.forEach(r=>{
      r.values = r.values || [];
      r.values.push('');
    });
    renderTech();
  });

  document.getElementById('amtexTechAddRow').addEventListener('click', ()=>{
    techState.rows.push({ parameter: '', values: techState.columns.map(()=> '') });
    renderTech();
  });

  document.getElementById('amtexTechCompact').addEventListener('click', ()=>{
    techCompactMode = true;
    techShell.classList.add('amtex-tech-compact');
    renderTech();
  });
  document.getElementById('amtexTechResetView').addEventListener('click', ()=>{
    techCompactMode = false;
    techShell.classList.remove('amtex-tech-compact');
    renderTech();
  });

  if (techSearch) {
    techSearch.addEventListener('input', function(){
      techFilter = amtexNormalize(this.value);
      renderTech();
    });
  }

  // On submit: JSON fields
  document.querySelector('.amtex-prodf-form').addEventListener('submit', function () {
    document.getElementById('amtexRecoLeftJson').value = JSON.stringify(amtexLinesToArray(document.getElementById('amtexRecoLeftRaw').value));
    document.getElementById('amtexRecoRightJson').value = JSON.stringify(amtexLinesToArray(document.getElementById('amtexRecoRightRaw').value));
    document.getElementById('amtexTechJson').value = JSON.stringify(techState);
  });

  // Restore existing DB values into UI (or old() if validation failed)
  $(document).ready(function () {
    // tags
    const oldTags = @json(old('pdp_tags', null));
    const dbTags = amtexTryParseJson(@json($product->pdp_tags ?? '')) || [];
    const tagsToUse = Array.isArray(oldTags) ? oldTags : (Array.isArray(dbTags) ? dbTags : []);
    if (tagsToUse.length) {
      tagsToUse.forEach(t=>{
        $('#amtexTagAdd').trigger('click');
        $('#amtexTagsWrap input[name="pdp_tags[]"]').last().val(t);
      });
    } else {
      $('#amtexTagAdd').trigger('click');
      $('#amtexTagAdd').trigger('click');
    }

    // pointers
    const oldPointers = @json(old('pdp_pointers', null));
    const dbPointers = amtexTryParseJson(@json($product->pdp_pointers ?? '')) || [];
    const pointersToUse = Array.isArray(oldPointers) ? oldPointers : (Array.isArray(dbPointers) ? dbPointers : []);
    if (pointersToUse.length) {
      pointersToUse.forEach(p=>{
        $('#amtexPointerAdd').trigger('click');
        $('#amtexPointersWrap input[name="pdp_pointers[]"]').last().val(p);
      });
    } else {
      $('#amtexPointerAdd').trigger('click');
      $('#amtexPointerAdd').trigger('click');
      $('#amtexPointerAdd').trigger('click');
    }

    // key highlights
    const oldKey = @json(old('pdp_key_highlights', null));
    const dbKey = amtexTryParseJson(@json($product->pdp_key_highlights ?? '')) || [];
    const keyToUse = Array.isArray(oldKey) ? oldKey : (Array.isArray(dbKey) ? dbKey : []);
    if (keyToUse.length) {
      keyToUse.forEach((h)=>{
        $('#amtexKeyAdd').trigger('click');
        const idx = $('#amtexKeyWrap .amtex-prodf-row').length - 1;
        $(`input[name="pdp_key_highlights[${idx}][icon]"]`).val(h?.icon || '');
        $(`input[name="pdp_key_highlights[${idx}][title]"]`).val(h?.title || '');
        $(`input[name="pdp_key_highlights[${idx}][text]"]`).val(h?.text || '');
      });
    }

    // works on
    const oldWorks = @json(old('pdp_works_on', null));
    const dbWorks = amtexTryParseJson(@json($product->pdp_works_on ?? '')) || [];
    const worksToUse = Array.isArray(oldWorks) ? oldWorks : (Array.isArray(dbWorks) ? dbWorks : []);
    if (worksToUse.length) {
      worksToUse.forEach((w)=>{
        $('#amtexWorksAdd').trigger('click');
        const idx = $('#amtexWorksWrap .amtex-prodf-row').length - 1;
        $(`input[name="pdp_works_on[${idx}][icon]"]`).val(w?.icon || '');
        $(`input[name="pdp_works_on[${idx}][title]"]`).val(w?.title || '');
        $(`input[name="pdp_works_on[${idx}][text]"]`).val(w?.text || '');
      });
    }

    // recommended-for: if json exists, paint into textarea
    const leftArr = amtexTryParseJson($('#amtexRecoLeftJson').val());
    const rightArr = amtexTryParseJson($('#amtexRecoRightJson').val());
    if (Array.isArray(leftArr) && leftArr.length && !$('#amtexRecoLeftRaw').val()) $('#amtexRecoLeftRaw').val(leftArr.join("\n"));
    if (Array.isArray(rightArr) && rightArr.length && !$('#amtexRecoRightRaw').val()) $('#amtexRecoRightRaw').val(rightArr.join("\n"));

    // tech table
    const techObj = amtexTryParseJson($('#amtexTechJson').val());
    if (techObj && typeof techObj === 'object' && Array.isArray(techObj.columns) && Array.isArray(techObj.rows)) {
      techState = techObj;
    } else {
      techState.columns = ['WATMIST(SP)/2','WATMIST(SP)/4','WATMIST(SP)/6','WATMIST(SP)/9'];
      techState.rows = [
        {parameter:'Capacity', values:['2 Ltrs.','4 Ltrs.','6 Ltrs.','9 Ltrs.']},
        {parameter:'Extinguishing Agent', values:['Deionised Water','Deionised Water','Deionised Water','Deionised Water']},
      ];
    }

    if (window.matchMedia && window.matchMedia('(max-width: 576px)').matches) {
      techCompactMode = true;
      techShell.classList.add('amtex-tech-compact');
    }

    renderTech();
  });
</script>

{{-- ✅ Minimal CSS for responsive tech editor (same as create) --}}
<style>
  .amtex-prodf-techbar{
    display:flex; align-items:flex-end; justify-content:space-between;
    gap:12px; padding:10px 0 12px;
    border-top:1px dashed rgba(0,0,0,.08);
    margin-top:10px;
  }
  .amtex-prodf-techbar-title{ font-weight:700; }
  .amtex-prodf-techbar-sub{ font-size:.85rem; opacity:.75; }
  .amtex-prodf-techbar-search{ display:flex; align-items:center; gap:8px; min-width:260px; }
  .amtex-prodf-techbar-search i{ opacity:.65; }
  @media (max-width: 768px){
    .amtex-prodf-techbar{ flex-direction:column; align-items:stretch; }
    .amtex-prodf-techbar-search{ min-width:100%; }
  }

  .amtex-prodf-techShell{ width:100%; }
  .amtex-prodf-techScroll{
    width:100%;
    overflow:auto;
    border:1px solid rgba(0,0,0,.08);
    border-radius:12px;
    padding:10px;
    background:#fff;
  }

  .amtex-prodf-techTable{ min-width: 860px; }
  .amtex-prodf-techRow{
    display:grid;
    grid-auto-flow:column;
    grid-auto-columns:minmax(220px, 1fr);
    gap:10px;
    align-items:start;
    padding:8px 0;
    border-bottom:1px solid rgba(0,0,0,.06);
  }
  .amtex-prodf-techRowHead{
    position:sticky; top:0; z-index:5;
    background:#fff;
    padding-top:0;
  }
  .amtex-prodf-techCell{ min-width:220px; }
  .amtex-prodf-techCellParam{
    position:sticky; left:0; z-index:6;
    background:#fff;
  }
  .amtex-prodf-techHeadLabel{ font-weight:800; padding:6px 0 0; }
  .amtex-prodf-techColHead{ display:flex; gap:8px; align-items:center; }
  .amtex-prodf-chipDel{ border:0; background:transparent; opacity:.7; padding:0 6px; cursor:pointer; }
  .amtex-prodf-techParamWrap{ display:flex; gap:8px; align-items:center; }
  .amtex-prodf-rowDelSmall{ width:34px; height:34px; display:inline-flex; align-items:center; justify-content:center; }
  .amtex-prodf-techEmpty{ padding:14px; opacity:.8; }

  .amtex-prodf-techCards{ display:grid; gap:12px; }
  .amtex-prodf-techCard{
    border:1px solid rgba(0,0,0,.08);
    border-radius:14px;
    padding:12px;
    background:#fff;
  }
  .amtex-prodf-techCardHead{
    display:flex; align-items:center; justify-content:space-between; gap:10px;
    margin-bottom:10px;
  }
  .amtex-prodf-techCardTitle{ font-weight:800; }
  .amtex-prodf-techCardBody{ display:grid; gap:10px; grid-template-columns: 1fr; }
  .amtex-prodf-techCardItem{ display:grid; gap:6px; }
  .amtex-prodf-techCardLabel{ font-size:.85rem; opacity:.75; font-weight:700; }

  .amtex-tech-compact .amtex-prodf-techScroll{ border:none; padding:0; background:transparent; }
</style>
@endsection
