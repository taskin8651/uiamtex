@extends('layouts.admin')
@section('content')

<div class="card amtex-premium-bcat-form-card">
    <div class="card-header amtex-premium-bcat-form-header">
        <div class="amtex-premium-bcat-form-head">
            <div class="amtex-premium-bcat-form-title">
                {{ trans('global.create') }} {{ trans('cruds.blogCategory.title_singular') }}
            </div>
            <div class="amtex-premium-bcat-form-subtitle">
                Add a new blog category with clean naming and auto-generated slug.
            </div>
        </div>

        <div class="amtex-premium-bcat-form-header-actions">
            <a href="{{ route('admin.blog-categories.index') }}" class="btn btn-light amtex-premium-bcat-btn-soft">
                <i class="fas fa-arrow-left"></i> {{ trans('global.back_to_list') ?? 'Back to list' }}
            </a>
        </div>
    </div>

    <div class="card-body amtex-premium-bcat-form-body">
        <form method="POST" action="{{ route('admin.blog-categories.store') }}" enctype="multipart/form-data" class="amtex-premium-bcat-form">
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
                        value="{{ old('name', '') }}"
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
                            value="{{ old('slug', '') }}"
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
                            <option value="{{ $key }}" {{ old('is_active', 'yes') === (string) $key ? 'selected' : '' }}>
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
            // Replace & with 'and'
            .replace(/&/g, ' and ')
            // Remove quotes
            .replace(/['"]/g, '')
            // Replace non-alphanumeric with hyphen
            .replace(/[^a-z0-9]+/g, '-')
            // Trim hyphens
            .replace(/^-+|-+$/g, '')
            // Collapse multiple hyphens
            .replace(/-+/g, '-');
    };

    // If slug is empty (or equals old), auto-fill while typing
    let slugTouched = !!slugEl.value.trim();

    slugEl.addEventListener('input', function () {
        slugTouched = !!slugEl.value.trim();
    });

    const generateFromName = () => {
        const s = slugify(nameEl.value);
        if (!slugTouched) slugEl.value = s;
    };

    nameEl.addEventListener('input', function () {
        // Only auto-fill if user hasn't manually edited slug
        if (!slugTouched) {
            slugEl.value = slugify(nameEl.value);
        }
    });

    // If page loads with empty slug, create from existing name
    if (!slugEl.value.trim() && nameEl.value.trim()) {
        slugEl.value = slugify(nameEl.value);
    }

    // Regenerate button forces slug from name and marks as touched
    if (regenBtn) {
        regenBtn.addEventListener('click', function () {
            slugEl.value = slugify(nameEl.value);
            slugTouched = true;
        });
    }
})();
</script>
@endsection
