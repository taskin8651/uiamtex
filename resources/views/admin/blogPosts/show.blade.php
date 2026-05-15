@extends('layouts.admin')
@section('content')

<div class="card amtex-premium-bpostshow-card">

    <div class="card-header amtex-premium-bpostshow-header">
        <div class="amtex-premium-bpostshow-head">
            <div class="amtex-premium-bpostshow-title">
                {{ trans('global.show') }} {{ trans('cruds.blogPost.title_singular') ?? trans('cruds.blogPost.title') }}
            </div>
            <div class="amtex-premium-bpostshow-subtitle">
                Preview post details, media, and publishing status in a clean premium layout.
            </div>
        </div>

        <div class="amtex-premium-bpostshow-actions">
            <a class="btn btn-light amtex-premium-bpostshow-btnsoft" href="{{ route('admin.blog-posts.index') }}">
                <i class="fas fa-arrow-left"></i> {{ trans('global.back_to_list') }}
            </a>

            @can('blog_post_edit')
                <a class="btn btn-primary amtex-premium-bpostshow-btnprimary" href="{{ route('admin.blog-posts.edit', $blogPost->id) }}">
                    <i class="fas fa-edit"></i> {{ trans('global.edit') ?? 'Edit' }}
                </a>
            @endcan
        </div>
    </div>

    <div class="card-body amtex-premium-bpostshow-body">

        {{-- Top Summary --}}
        <div class="amtex-premium-bpostshow-summary">
            <div class="amtex-premium-bpostshow-badgewrap">
                @php
                    $pubLabel = App\Models\BlogPost::IS_PUBLISHED_SELECT[$blogPost->is_published] ?? '';
                    $pubKey = strtolower((string) $blogPost->is_published);
                    $labelLower = strtolower($pubLabel);
                    $isPublished = in_array($pubKey, ['yes','1','true','published','on'], true) || str_contains($labelLower, 'publish') || str_contains($labelLower, 'live') || str_contains($labelLower, 'enable');
                @endphp

                <span class="amtex-premium-bpostshow-badge {{ $isPublished ? 'amtex-premium-bpostshow-badge--pub' : 'amtex-premium-bpostshow-badge--draft' }}">
                    <span class="amtex-premium-bpostshow-dot {{ $isPublished ? 'amtex-premium-bpostshow-dot--pub' : 'amtex-premium-bpostshow-dot--draft' }}"></span>
                    {{ $pubLabel ?: '-' }}
                </span>

                <span class="amtex-premium-bpostshow-chip">
                    <i class="fas fa-hashtag"></i> #{{ $blogPost->id }}
                </span>

                <span class="amtex-premium-bpostshow-chip">
                    <i class="fas fa-folder"></i> {{ $blogPost->select_category->name ?? '—' }}
                </span>

                @if(!empty($blogPost->read_time))
                    <span class="amtex-premium-bpostshow-chip">
                        <i class="far fa-clock"></i> {{ $blogPost->read_time }}
                    </span>
                @endif

                <span class="amtex-premium-bpostshow-chip">
                    <i class="far fa-calendar-alt"></i> {{ $blogPost->published_at ?? '—' }}
                </span>
            </div>

            <div class="amtex-premium-bpostshow-headline">
                {{ $blogPost->title ?? '—' }}
            </div>

            @if(!empty($blogPost->slug))
                <div class="amtex-premium-bpostshow-slug">
                    <span class="amtex-premium-bpostshow-sluglabel">Slug</span>
                    <span class="amtex-premium-bpostshow-slugval">{{ $blogPost->slug }}</span>
                </div>
            @endif
        </div>

        {{-- Content Layout --}}
        <div class="amtex-premium-bpostshow-grid">

            {{-- Left: Main Content --}}
            <div class="amtex-premium-bpostshow-left">

                {{-- Excerpt --}}
                <div class="amtex-premium-bpostshow-box">
                    <div class="amtex-premium-bpostshow-boxhead">
                        <i class="far fa-sticky-note"></i>
                        <span>{{ trans('cruds.blogPost.fields.excerpt') }}</span>
                    </div>
                    <div class="amtex-premium-bpostshow-boxbody">
                        {{ $blogPost->excerpt ?? '—' }}
                    </div>
                </div>

                {{-- Content --}}
                <div class="amtex-premium-bpostshow-box">
                    <div class="amtex-premium-bpostshow-boxhead">
                        <i class="far fa-file-alt"></i>
                        <span>{{ trans('cruds.blogPost.fields.content') }}</span>
                    </div>
                    <div class="amtex-premium-bpostshow-boxbody amtex-premium-bpostshow-content">
                        {!! $blogPost->content ?: '<span class="amtex-premium-bpostshow-muted">—</span>' !!}
                    </div>
                </div>

            </div>

            {{-- Right: Media + Quick Details --}}
            <div class="amtex-premium-bpostshow-right">

                {{-- Featured Image --}}
                <div class="amtex-premium-bpostshow-box">
                    <div class="amtex-premium-bpostshow-boxhead">
                        <i class="far fa-image"></i>
                        <span>{{ trans('cruds.blogPost.fields.featured_image') }}</span>
                    </div>
                    <div class="amtex-premium-bpostshow-boxbody">
                        @if($blogPost->featured_image)
                            <a href="{{ $blogPost->featured_image->getUrl() }}" target="_blank" class="amtex-premium-bpostshow-imagewrap">
                                <img src="{{ $blogPost->featured_image->getUrl() }}" alt="Featured Image">
                                <span class="amtex-premium-bpostshow-imagetag">
                                    <i class="fas fa-external-link-alt"></i> Open Full
                                </span>
                            </a>
                        @else
                            <div class="amtex-premium-bpostshow-emptyimg">
                                <i class="far fa-image"></i>
                                <div>No image uploaded</div>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Quick Details --}}
                <div class="amtex-premium-bpostshow-box">
                    <div class="amtex-premium-bpostshow-boxhead">
                        <i class="fas fa-info-circle"></i>
                        <span>Quick Details</span>
                    </div>

                    <div class="amtex-premium-bpostshow-kv">
                        <div class="amtex-premium-bpostshow-k">
                            {{ trans('cruds.blogPost.fields.id') }}
                        </div>
                        <div class="amtex-premium-bpostshow-v">
                            {{ $blogPost->id }}
                        </div>
                    </div>

                    <div class="amtex-premium-bpostshow-kv">
                        <div class="amtex-premium-bpostshow-k">
                            {{ trans('cruds.blogPost.fields.select_category') }}
                        </div>
                        <div class="amtex-premium-bpostshow-v">
                            {{ $blogPost->select_category->name ?? '—' }}
                        </div>
                    </div>

                    <div class="amtex-premium-bpostshow-kv">
                        <div class="amtex-premium-bpostshow-k">
                            {{ trans('cruds.blogPost.fields.read_time') }}
                        </div>
                        <div class="amtex-premium-bpostshow-v">
                            {{ $blogPost->read_time ?? '—' }}
                        </div>
                    </div>

                    <div class="amtex-premium-bpostshow-kv">
                        <div class="amtex-premium-bpostshow-k">
                            {{ trans('cruds.blogPost.fields.published_at') }}
                        </div>
                        <div class="amtex-premium-bpostshow-v">
                            {{ $blogPost->published_at ?? '—' }}
                        </div>
                    </div>

                    <div class="amtex-premium-bpostshow-kv">
                        <div class="amtex-premium-bpostshow-k">
                            {{ trans('cruds.blogPost.fields.is_published') }}
                        </div>
                        <div class="amtex-premium-bpostshow-v">
                            {{ $pubLabel ?: '—' }}
                        </div>
                    </div>
                </div>

            </div>
        </div>

        {{-- Bottom Back --}}
        <div class="amtex-premium-bpostshow-footer">
            <a class="btn btn-light amtex-premium-bpostshow-btnsoft" href="{{ route('admin.blog-posts.index') }}">
                <i class="fas fa-arrow-left"></i> {{ trans('global.back_to_list') }}
            </a>
        </div>

    </div>
</div>

@endsection
