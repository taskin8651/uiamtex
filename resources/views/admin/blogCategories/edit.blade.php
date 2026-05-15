@extends('layouts.admin')
@section('content')

<div class="card amtex-premium-bcat-form-card">
    <div class="card-header amtex-premium-bcat-form-header">
        <div class="amtex-premium-bcat-form-head">
            <div class="amtex-premium-bcat-form-title">
                {{ trans('global.edit') }} {{ trans('cruds.blogCategory.title_singular') }}
            </div>
            <div class="amtex-premium-bcat-form-subtitle">
                Update category details. Slug can be auto-regenerated from name when needed.
            </div>
        </div>

        <div class="amtex-premium-bcat-form-header-actions">
            <a href="{{ route('admin.blog-categories.index') }}" class="btn btn-light amtex-premium-bcat-btn-soft">
                <i class="fas fa-arrow-left"></i> {{ trans('global.back_to_list') ?? 'Back to list' }}
            </a>
        </div>
    </div>

    <div class="card-body amtex-premium-bcat-form-body">
        <form method="POST" action="{{ route('admin.blog-categories.update', [$blogCategory->id]) }}" enctype="multipart/form-data" class="amtex-premium-bcat-form">
            @method('PUT')
            @csrf

            <div class="amtex-premium-bcat-form-grid">

                {{-- Name --}}
                <div class="form-group amtex-premium-bcat-field">
                    <label class="required amtex-premium-bcat-label" for="name">
                        {{ trans('cruds.blogCategory.fields.name') }}
                    </label>

                    <input
                        class="form-control amtex-premium-bcat-input {{ $errors->has('name') ? 'is-invalid' : '' }}"
                        type="text"
                        name="name"
                        id="name"
                        value="{{ old('name', $blogCategory->name) }}"
                        required
                        placeholder="e.g. Fire Safety Tips"
                    >

                    @if($errors->has('name'))
                        <div class="invalid-feedback">
                            {{ $errors->first('name') }}
                        </div>
                    @endif

                    <span class="help-block amtex-premium-bcat-help">
                        {{ trans('cruds.blogCategory.fields.name_helper') }}
                    </span>
                </div>

                {{-- Slug --}}
                <div class="form-group amtex-premium-bcat-field">
                    <label class="required amtex-premium-bcat-label" for="slug">
                        {{ trans('cruds.blogCategory.fields.slug') }}
                    </label>

                    <div class="amtex-premium-bcat-slugwrap">
                        <input
                            class="form-control amtex-premium-bcat-input {{ $errors->has('slug') ? 'is-invalid' : '' }}"
                            type="text"
                            name="slug"
                            id="slug"
                            value="{{ old('slug', $blogCategory->slug) }}"
                            required
                            placeholder="auto-generated-from-name"
                        />

                        <button type="button" class="btn btn-light amtex-premium-bcat-slugbtn" id="amtexSlugRegenerate" title="Regenerate from name">
                            <i class="fas fa-sync-alt"></i>
                        </button>
                    </div>

                    @if($errors->has('slug'))
                        <div class="invalid-feedback">
                            {{ $errors->first('slug') }}
                        </div>
                    @endif

                    <span class="help-block amtex-premium-bcat-help">
                        {{ trans('cruds.blogCategory.fields.slug_helper') }}
                    </span>

                    <div class="amtex-premium-bcat-hint">
                        Tip: If you change the name and want matching slug, click regenerate.
                    </div>
                </div>

                {{-- Status --}}
                <div class="form-group amtex-premium-bcat-field">
                    <label class="amtex-premium-bcat-label" for="is_active">
                        {{ trans('cruds.blogCategory.fields.is_active') }}
                    </label>

                    <select
                        class="form-control amtex-premium-bcat-input {{ $errors->has('is_active') ? 'is-invalid' : '' }}"
                        name="is_active"
                        id="is_active"
                    >
                        <option value disabled {{ old('is_active', null) === null ? 'selected' : '' }}>
                            {{ trans('global.pleaseSelect') }}
                        </option>

                        @foreach(App\Models\BlogCategory::IS_ACTIVE_SELECT as $key => $label)
                            <option value="{{ $key }}" {{ old('is_active', $blogCategory->is_active) === (string) $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>

                    @if($errors->has('is_active'))
                        <div class="invalid-feedback">
                            {{ $errors->first('is_active') }}
                        </div>
                    @endif

                    <span class="help-block amtex-premium-bcat-help">
                        {{ trans('cruds.blogCategory.fields.is_active_helper') }}
                    </span>
                </div>

            </div>

            {{-- Actions --}}
            <div class="amtex-premium-bcat-form-actions">
                <button class="btn btn-danger amtex-premium-bcat-btn-primary" type="submit">
                    <i class="fas fa-save"></i> {{ trans('global.save') }}
                </button>

                <a href="{{ route('admin.blog-categories.index') }}" class="btn btn-secondary amtex-premium-bcat-btn-secondary">
                    {{ trans('global.cancel') ?? 'Cancel' }}
                </a>
            </div>

        </form>
    </div>
</div>

@endsection

@section('scripts')
@parent
<script>
(function () {
    const nameEl = document.getElementById('name');
    const slugEl = document.getElementById('slug');
    const regenBtn = document.getElementById('amtexSlugRegenerate');

    if (!nameEl || !slugEl) return;

    const slugify = (str) => {
        return (str || '')
            .toString()
            .trim()
            .toLowerCase()
            .replace(/&/g, ' and ')
            .replace(/['"]/g, '')
            .replace(/[^a-z0-9]+/g, '-')
            .replace(/^-+|-+$/g, '')
            .replace(/-+/g, '-');
    };

    // EDIT PAGE BEHAVIOR:
    // - Do NOT overwrite slug automatically by default (safe for SEO/URLs).
    // - If user clears slug manually, we can assist auto-fill while typing.
    // - Regenerate button always forces slug from name.

    let slugTouched = true; // treat as touched by default since it already has value

    slugEl.addEventListener('input', function () {
        slugTouched = !!slugEl.value.trim(); // if empty => allow auto-fill
    });

    nameEl.addEventListener('input', function () {
        // Only auto-fill if user made slug empty (meaning they want auto help)
        if (!slugTouched) {
            slugEl.value = slugify(nameEl.value);
        }
    });

    if (regenBtn) {
        regenBtn.addEventListener('click', function () {
            slugEl.value = slugify(nameEl.value);
            slugTouched = true;
        });
    }
})();
</script>
@endsection
