@extends('layouts.admin')
@section('content')

<div class="card page-show-card">
    <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
        <div>
            <strong>{{ trans('global.show') }} {{ trans('cruds.page.title') }}</strong>
            <div class="text-muted small mt-1">
                View page details, content, and SEO information.
            </div>
        </div>

        <div class="d-flex gap-2 flex-wrap">
            <a class="btn btn-light" href="{{ route('admin.pages.index') }}">
                {{ trans('global.back_to_list') }}
            </a>

            @can('page_edit')
                <a class="btn btn-info" href="{{ route('admin.pages.edit', $page->id) }}">
                    {{ trans('global.edit') }}
                </a>
            @endcan

            @can('page_delete')
                <form action="{{ route('admin.pages.destroy', $page->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display:inline;">
                    @method('DELETE')
                    @csrf
                    <button class="btn btn-danger" type="submit">
                        {{ trans('global.delete') }}
                    </button>
                </form>
            @endcan
        </div>
    </div>

    <div class="card-body">

        <div class="row">
            {{-- LEFT: Main --}}
            <div class="col-12 col-lg-8">

                <div class="card inner-card mb-3">
                    <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
                        <strong>Page Details</strong>
                        <span class="badge badge-light p-2">
                            ID: #{{ $page->id }}
                        </span>
                    </div>

                    <div class="card-body">
                        <div class="mb-3">
                            <div class="small text-muted mb-1">{{ trans('cruds.page.fields.title') }}</div>
                            <div class="h5 mb-0">{{ $page->title }}</div>
                        </div>

                        <div class="mb-3">
                            <div class="small text-muted mb-1">{{ trans('cruds.page.fields.slug') }}</div>
                            <div class="font-monospace">
                                {{ $page->slug }}
                            </div>
                        </div>

                        <div class="mb-2">
                            <div class="small text-muted mb-2">{{ trans('cruds.page.fields.content') }}</div>
                            <div class="content-box">
                                {!! $page->content !!}
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- RIGHT: SEO + Status --}}
            <div class="col-12 col-lg-4">

                <div class="card inner-card mb-3">
                    <div class="card-header">
                        <strong>Status</strong>
                    </div>
                    <div class="card-body">
                        @php
                            $statusLabel = App\Models\Page::IS_ACTIVE_SELECT[$page->is_active] ?? '';
                            $isActive = in_array(strtolower((string)$statusLabel), ['active', 'enabled', 'yes', '1'], true)
                                        || (string)$page->is_active === '1';
                        @endphp

                        <div class="d-flex align-items-center justify-content-between">
                            <div class="small text-muted">{{ trans('cruds.page.fields.is_active') }}</div>
                            <span class="badge {{ $isActive ? 'badge-success' : 'badge-secondary' }} badge-pill">
                                {{ $statusLabel }}
                            </span>
                        </div>

                        <hr>

                        <div class="small text-muted">Timestamps</div>
                        <div class="mt-2">
                            <div class="d-flex justify-content-between small">
                                <span class="text-muted">Created</span>
                                <span>{{ optional($page->created_at)->format('d M Y, h:i A') }}</span>
                            </div>
                            <div class="d-flex justify-content-between small mt-1">
                                <span class="text-muted">Updated</span>
                                <span>{{ optional($page->updated_at)->format('d M Y, h:i A') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card inner-card mb-3">
                    <div class="card-header">
                        <strong>SEO</strong>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="small text-muted mb-1">{{ trans('cruds.page.fields.seo_title') }}</div>
                            <div class="font-weight-semibold">{{ $page->seo_title ?: '—' }}</div>
                        </div>

                        <div class="mb-3">
                            <div class="small text-muted mb-1">{{ trans('cruds.page.fields.seo_description') }}</div>
                            <div class="seo-desc">
                                {{ $page->seo_description ?: '—' }}
                            </div>
                        </div>

                        <hr>

                        {{-- SEO Preview --}}
                        <div class="small text-muted mb-2">Search Preview</div>
                        <div class="seo-preview">
                            <div class="seo-preview-title text-truncate" title="{{ $page->seo_title }}">
                                {{ $page->seo_title ?: $page->title }}
                            </div>
                            <div class="seo-preview-url text-truncate">
                                /{{ ltrim($page->slug, '/') }}
                            </div>
                            <div class="seo-preview-desc">
                                {{ $page->seo_description ?: 'Add a meta description to improve click-through rate.' }}
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mt-2">
            <a class="btn btn-light" href="{{ route('admin.pages.index') }}">
                {{ trans('global.back_to_list') }}
            </a>

            @can('page_edit')
                <a class="btn btn-info" href="{{ route('admin.pages.edit', $page->id) }}">
                    {{ trans('global.edit') }}
                </a>
            @endcan
        </div>

    </div>
</div>

@endsection

@section('styles')
@parent
<style>
    .page-show-card .inner-card { border: 1px solid rgba(0,0,0,.08); }
    .font-monospace { font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace; }

    .content-box {
        border: 1px solid rgba(0,0,0,.08);
        border-radius: 6px;
        padding: 14px;
        background: #fff;
        overflow-wrap: anywhere;
    }

    .seo-desc {
        border: 1px dashed rgba(0,0,0,.15);
        border-radius: 6px;
        padding: 10px;
        background: #fafafa;
        white-space: pre-wrap;
        overflow-wrap: anywhere;
    }

    .seo-preview {
        border: 1px solid rgba(0,0,0,.08);
        border-radius: 8px;
        padding: 12px;
        background: #fff;
    }
    .seo-preview-title { font-weight: 700; }
    .seo-preview-url { color: #2e7d32; font-size: 0.875rem; }
    .seo-preview-desc { color: rgba(0,0,0,.7); font-size: 0.9rem; margin-top: 4px; white-space: pre-wrap; }
</style>
@endsection
