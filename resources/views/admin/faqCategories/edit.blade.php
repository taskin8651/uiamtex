@extends('layouts.admin')
@section('content')

<div class="amtex-faqcat-form">

    <div class="af-header">
        <div>
            <h3 class="af-title">{{ trans('global.edit') }} {{ trans('cruds.faqCategory.title_singular') }}</h3>
            <p class="af-subtitle">
                Update category details and publishing status.
            </p>
        </div>

        <div style="display:flex; gap:.5rem; flex-wrap:wrap;">
            <a href="{{ route('admin.faq-categories.index') }}" class="btn btn-outline-secondary">
                ← Back to list
            </a>

            @can('faq_category_show')
                <a href="{{ route('admin.faq-categories.show', $faqCategory->id) }}" class="btn btn-outline-primary">
                    View
                </a>
            @endcan
        </div>
    </div>

    <form method="POST" action="{{ route('admin.faq-categories.update', [$faqCategory->id]) }}" enctype="multipart/form-data">
        @method('PUT')
        @csrf

        <div class="row">
            <!-- Left: Main form -->
            <div class="col-lg-8 mb-3">
                <div class="card af-card">
                    <div class="card-header">
                        <div>
                            <div class="af-section-title">Category Details</div>
                            <div class="af-section-hint">Edit basic details for this FAQ category.</div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <!-- Name -->
                            <div class="col-md-7">
                                <div class="form-group af-field">
                                    <label class="required af-label" for="name">{{ trans('cruds.faqCategory.fields.name') }}</label>
                                    <input
                                        class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                        type="text"
                                        name="name"
                                        id="name"
                                        value="{{ old('name', $faqCategory->name) }}"
                                        placeholder="e.g. Fire Safety, AMC, Refilling, Installation..."
                                        required
                                    >
                                    @if($errors->has('name'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('name') }}
                                        </div>
                                    @endif
                                    <div class="af-help">{{ trans('cruds.faqCategory.fields.name_helper') }}</div>
                                </div>
                            </div>

                            <!-- Sort order -->
                            <div class="col-md-5">
                                <div class="form-group af-field">
                                    <label class="required af-label" for="sort_order">{{ trans('cruds.faqCategory.fields.sort_order') }}</label>
                                    <input
                                        class="form-control {{ $errors->has('sort_order') ? 'is-invalid' : '' }}"
                                        type="number"
                                        name="sort_order"
                                        id="sort_order"
                                        value="{{ old('sort_order', $faqCategory->sort_order) }}"
                                        placeholder="e.g. 1"
                                        required
                                    >
                                    @if($errors->has('sort_order'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('sort_order') }}
                                        </div>
                                    @endif
                                    <div class="af-help">{{ trans('cruds.faqCategory.fields.sort_order_helper') }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="af-note">
                            <strong>Tip</strong>
                            Keep the sort order consistent to control category display priority on the FAQ page.
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Status card -->
            <div class="col-lg-4 mb-3">
                <div class="card af-card">
                    <div class="card-header">
                        <div class="af-section-title">Publishing</div>
                        <div class="af-section-hint">Control visibility on the website.</div>
                    </div>

                    <div class="card-body">
                        <div class="form-group af-field">
                            <label class="af-label" for="is_active">{{ trans('cruds.faqCategory.fields.is_active') }}</label>
                            <select
                                class="form-control {{ $errors->has('is_active') ? 'is-invalid' : '' }}"
                                name="is_active"
                                id="is_active"
                            >
                                <option value disabled {{ old('is_active', null) === null ? 'selected' : '' }}>
                                    {{ trans('global.pleaseSelect') }}
                                </option>

                                @foreach(App\Models\FaqCategory::IS_ACTIVE_SELECT as $key => $label)
                                    <option value="{{ $key }}" {{ old('is_active', $faqCategory->is_active) === (string) $key ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>

                            @if($errors->has('is_active'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('is_active') }}
                                </div>
                            @endif

                            <div class="af-help">{{ trans('cruds.faqCategory.fields.is_active_helper') }}</div>
                        </div>

                        <div class="af-actions">
                            <a href="{{ route('admin.faq-categories.index') }}" class="btn btn-light">
                                Cancel
                            </a>

                            <button class="btn btn-danger" type="submit">
                                {{ trans('global.save') }}
                            </button>
                        </div>

                        @can('faq_category_delete')
                            <hr>
                            <form action="{{ route('admin.faq-categories.destroy', $faqCategory->id) }}" method="POST"
                                  onsubmit="return confirm('{{ trans('global.areYouSure') }}');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-block">
                                    Delete Category
                                </button>
                            </form>
                        @endcan

                    </div>
                </div>
            </div>
        </div>
    </form>

</div>
@endsection
