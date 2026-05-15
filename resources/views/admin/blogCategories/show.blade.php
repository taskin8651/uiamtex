@extends('layouts.admin')
@section('content')

<div class="card amtex-premium-bcat-show-card">
    <div class="card-header amtex-premium-bcat-show-header">
        <div class="amtex-premium-bcat-show-head">
            <div class="amtex-premium-bcat-show-title">
                {{ trans('global.show') }} {{ trans('cruds.blogCategory.title') }}
            </div>
            <div class="amtex-premium-bcat-show-subtitle">
                View category details in a clean, premium layout.
            </div>
        </div>

        <div class="amtex-premium-bcat-show-actions">
            <a class="btn btn-light amtex-premium-bcat-btn-soft" href="{{ route('admin.blog-categories.index') }}">
                <i class="fas fa-arrow-left"></i> {{ trans('global.back_to_list') }}
            </a>

            @can('blog_category_edit')
                <a class="btn btn-primary amtex-premium-bcat-btn-primaryblue" href="{{ route('admin.blog-categories.edit', $blogCategory->id) }}">
                    <i class="fas fa-edit"></i> {{ trans('global.edit') }}
                </a>
            @endcan
        </div>
    </div>

    <div class="card-body amtex-premium-bcat-show-body">

        <div class="amtex-premium-bcat-show-grid">

            {{-- ID --}}
            <div class="amtex-premium-bcat-info">
                <div class="amtex-premium-bcat-info-label">{{ trans('cruds.blogCategory.fields.id') }}</div>
                <div class="amtex-premium-bcat-info-value">
                    <span class="amtex-premium-bcat-chip">#{{ $blogCategory->id }}</span>
                </div>
            </div>

            {{-- Name --}}
            <div class="amtex-premium-bcat-info">
                <div class="amtex-premium-bcat-info-label">{{ trans('cruds.blogCategory.fields.name') }}</div>
                <div class="amtex-premium-bcat-info-value amtex-premium-bcat-info-value--big">
                    {{ $blogCategory->name }}
                </div>
            </div>

            {{-- Slug --}}
            <div class="amtex-premium-bcat-info">
                <div class="amtex-premium-bcat-info-label">{{ trans('cruds.blogCategory.fields.slug') }}</div>
                <div class="amtex-premium-bcat-info-value">
                    <span class="amtex-premium-bcat-mono">{{ $blogCategory->slug }}</span>
                </div>
            </div>

            {{-- Status --}}
            @php
                $statusText = App\Models\BlogCategory::IS_ACTIVE_SELECT[$blogCategory->is_active] ?? '';
                $statusLower = strtolower(trim($statusText));
                $isActive = (strpos($statusLower, 'active') !== false) && (strpos($statusLower, 'inactive') === false);
            @endphp

            <div class="amtex-premium-bcat-info">
                <div class="amtex-premium-bcat-info-label">{{ trans('cruds.blogCategory.fields.is_active') }}</div>
                <div class="amtex-premium-bcat-info-value">
                    <span class="amtex-premium-bcat-status {{ $isActive ? 'amtex-premium-bcat-status--active' : 'amtex-premium-bcat-status--inactive' }}">
                        <span class="amtex-premium-bcat-dot {{ $isActive ? 'amtex-premium-bcat-dot--active' : 'amtex-premium-bcat-dot--inactive' }}"></span>
                        {{ $statusText }}
                    </span>
                </div>
            </div>

        </div>

        <div class="amtex-premium-bcat-show-footer">
            <a class="btn btn-light amtex-premium-bcat-btn-soft" href="{{ route('admin.blog-categories.index') }}">
                <i class="fas fa-arrow-left"></i> {{ trans('global.back_to_list') }}
            </a>

            @can('blog_category_edit')
                <a class="btn btn-primary amtex-premium-bcat-btn-primaryblue" href="{{ route('admin.blog-categories.edit', $blogCategory->id) }}">
                    <i class="fas fa-edit"></i> {{ trans('global.edit') }}
                </a>
            @endcan
        </div>

    </div>
</div>

@endsection
