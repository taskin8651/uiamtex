@extends('layouts.admin')
@section('content')

@can('blog_post_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.blog-posts.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.blogPost.title_singular') }}
            </a>
            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'BlogPost', 'route' => 'admin.blog-posts.parseCsvImport'])
        </div>
    </div>
@endcan

<div class="card">
    <div class="card-header">
        {{ trans('cruds.blogPost.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body amtex-premium-bpost-wrap">

        {{-- Premium Header (search + stats + filters) --}}
        <div class="amtex-premium-bpost-topbar">
            <div class="amtex-premium-bpost-titlebox">
                <div class="amtex-premium-bpost-title">{{ trans('cruds.blogPost.title') ?? 'Blog Posts' }}</div>
                <div class="amtex-premium-bpost-subtitle">Premium view for posts with quick actions and status.</div>
            </div>

            <div class="amtex-premium-bpost-controls">
                <div class="amtex-premium-bpost-search">
                    <span class="amtex-premium-bpost-search-ico">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" id="amtexBpostSearch" placeholder="Search posts..." autocomplete="off">
                </div>

                <div class="amtex-premium-bpost-meta">
                    <div class="amtex-premium-bpost-pill">
                        Total: <span id="amtexBpostTotal">0</span>
                    </div>
                    <div class="amtex-premium-bpost-pill amtex-premium-bpost-pill-pub">
                        Published: <span id="amtexBpostPublished">0</span>
                    </div>
                    <div class="amtex-premium-bpost-pill amtex-premium-bpost-pill-draft">
                        Unpublished: <span id="amtexBpostUnpublished">0</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Cards Grid --}}
        <div id="amtexBpostGrid" class="amtex-premium-bpost-grid"></div>

        {{-- Hidden DataTable (kept for server-side + permissions + actions partial) --}}
        <div class="amtex-premium-bpost-hidden-table">
            <table class="table table-bordered table-striped table-hover ajaxTable datatable datatable-BlogPost">
                <thead>
                    <tr>
                        <th width="10"></th>
                        <th>{{ trans('cruds.blogPost.fields.id') }}</th>
                        <th>{{ trans('cruds.blogPost.fields.select_category') }}</th>
                        <th>{{ trans('cruds.blogPost.fields.title') }}</th>
                        <th>{{ trans('cruds.blogPost.fields.slug') }}</th>
                        <th>{{ trans('cruds.blogPost.fields.excerpt') }}</th>
                        <th>{{ trans('cruds.blogPost.fields.featured_image') }}</th>
                        <th>{{ trans('cruds.blogPost.fields.read_time') }}</th>
                        <th>{{ trans('cruds.blogPost.fields.published_at') }}</th>
                        <th>{{ trans('cruds.blogPost.fields.is_published') }}</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
            </table>
        </div>

    </div>
</div>

@endsection

@section('scripts')
@parent
<script>
$(function () {

    let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)

@can('blog_post_delete')
    let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
    let deleteButton = {
        text: deleteButtonTrans,
        url: "{{ route('admin.blog-posts.massDestroy') }}",
        className: 'btn-danger',
        action: function (e, dt, node, config) {
            var ids = $.map(dt.rows({ selected: true }).data(), function (entry) {
                return entry.id
            });

            if (ids.length === 0) {
                alert('{{ trans('global.datatables.zero_selected') }}')
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
    dtButtons.push(deleteButton)
@endcan

    // Robust published classifier:
    // controller returns label string (BlogPost::IS_PUBLISHED_SELECT[key])
    function amtexIsPublishedFromLabel(label) {
        const lower = (label || '').toString().trim().toLowerCase();

        const PUB_SET = new Set(['published', 'yes', 'true', '1', 'on', 'live']);
        const UNPUB_SET = new Set(['unpublished', 'draft', 'no', 'false', '0', 'off']);

        if (PUB_SET.has(lower)) return true;
        if (UNPUB_SET.has(lower)) return false;

        // phrases - check negative first
        if (lower.includes('unpublish') || lower.includes('draft') || lower.includes('disable') || lower.includes('false')) return false;
        if (lower.includes('publish') || lower.includes('enable') || lower.includes('true')) return true;

        return false;
    }

    function amtexPlainTextFromHtml(html) {
        return (html || '').toString()
            .replace(/<[^>]*>/g, ' ')
            .replace(/\s+/g, ' ')
            .trim();
    }

    function amtexGetThumbSrc(featuredHtml) {
        const html = (featuredHtml || '').toString();
        const m = html.match(/<img[^>]+src=["']([^"']+)["']/i);
        return m && m[1] ? m[1] : '';
    }

    let dtOverrideGlobals = {
        buttons: dtButtons,
        processing: true,
        serverSide: true,
        retrieve: true,
        aaSorting: [],
        ajax: "{{ route('admin.blog-posts.index') }}",
        columns: [
            { data: 'placeholder', name: 'placeholder' },
            { data: 'id', name: 'id' },
            { data: 'select_category_name', name: 'select_category.name' },
            { data: 'title', name: 'title' },
            { data: 'slug', name: 'slug' },
            { data: 'excerpt', name: 'excerpt' },
            { data: 'featured_image', name: 'featured_image', sortable: false, searchable: false },
            { data: 'read_time', name: 'read_time' },
            { data: 'published_at', name: 'published_at' },
            { data: 'is_published', name: 'is_published' },
            { data: 'actions', name: '{{ trans('global.actions') }}' }
        ],
        orderCellsTop: true,
        order: [[ 1, 'desc' ]],
        pageLength: 100,

        drawCallback: function (settings) {
            const api = this.api();
            const rows = api.rows({ page: 'current' }).data().toArray();

            let pubCount = 0;
            let unpubCount = 0;

            let html = '';

            if (!rows.length) {
                html = `
                    <div class="amtex-premium-bpost-empty">
                        <div class="amtex-premium-bpost-empty-icon"><i class="far fa-newspaper"></i></div>
                        <div class="amtex-premium-bpost-empty-title">No blog posts found</div>
                        <div class="amtex-premium-bpost-empty-sub">Try searching or create a new post.</div>
                    </div>
                `;
            } else {
                rows.forEach(function (row) {

                    const postId = row.id ?? '';
                    const category = (row.select_category_name ?? '').toString();
                    const title = amtexPlainTextFromHtml(row.title ?? '');
                    const slug = amtexPlainTextFromHtml(row.slug ?? '');
                    const excerpt = amtexPlainTextFromHtml(row.excerpt ?? '');
                    const readTime = amtexPlainTextFromHtml(row.read_time ?? '');
                    const publishedAt = amtexPlainTextFromHtml(row.published_at ?? '');
                    const publishLabel = amtexPlainTextFromHtml(row.is_published ?? '');

                    const isPublished = amtexIsPublishedFromLabel(publishLabel);
                    if (isPublished) pubCount++; else unpubCount++;

                    const badgeClass = isPublished ? 'amtex-premium-bpost-badge--pub' : 'amtex-premium-bpost-badge--draft';
                    const dotClass = isPublished ? 'amtex-premium-bpost-dot--pub' : 'amtex-premium-bpost-dot--draft';

                    const thumb = amtexGetThumbSrc(row.featured_image);
                    const thumbHtml = thumb
                        ? `<div class="amtex-premium-bpost-thumb"><img src="${thumb}" alt="featured"></div>`
                        : `<div class="amtex-premium-bpost-thumb amtex-premium-bpost-thumb--empty"><i class="far fa-image"></i></div>`;

                    html += `
                        <div class="amtex-premium-bpost-card">
                            <div class="amtex-premium-bpost-card-top">
                                <div class="amtex-premium-bpost-id">#${postId}</div>
                                <div class="amtex-premium-bpost-badge ${badgeClass}">
                                    <span class="amtex-premium-bpost-dot ${dotClass}"></span>
                                    ${publishLabel || '-'}
                                </div>
                            </div>

                            <div class="amtex-premium-bpost-main">
                                ${thumbHtml}

                                <div class="amtex-premium-bpost-content">
                                    <div class="amtex-premium-bpost-titleline" title="${title}">
                                        ${title || '-'}
                                    </div>

                                    <div class="amtex-premium-bpost-meta1">
                                        <span class="amtex-premium-bpost-chip">
                                            <i class="fas fa-folder"></i> ${category || 'No Category'}
                                        </span>
                                        ${readTime ? `<span class="amtex-premium-bpost-chip"><i class="far fa-clock"></i> ${readTime}</span>` : ``}
                                    </div>

                                    <div class="amtex-premium-bpost-slug">
                                        <span class="amtex-premium-bpost-slug-label">Slug</span>
                                        <span class="amtex-premium-bpost-slug-val">${slug || '-'}</span>
                                    </div>

                                    ${excerpt ? `<div class="amtex-premium-bpost-excerpt">${excerpt}</div>` : ``}

                                    <div class="amtex-premium-bpost-meta2">
                                        <span class="amtex-premium-bpost-date">
                                            <i class="far fa-calendar-alt"></i> ${publishedAt || '—'}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="amtex-premium-bpost-actions">
                                <div class="amtex-premium-bpost-actions-inner">
                                    ${row.actions ?? ''}
                                </div>
                            </div>
                        </div>
                    `;
                });
            }

            $('#amtexBpostGrid').html(html);

            // Stats (server-side => per page stats)
            $('#amtexBpostTotal').text(rows.length);
            $('#amtexBpostPublished').text(pubCount);
            $('#amtexBpostUnpublished').text(unpubCount);

            // Premium button treatment only inside this module
            $('#amtexBpostGrid .amtex-premium-bpost-actions-inner a.btn').addClass('amtex-premium-bpost-btnfix');
            $('#amtexBpostGrid .amtex-premium-bpost-actions-inner form button.btn').addClass('amtex-premium-bpost-btnfix');
        }
    };

    let table = $('.datatable-BlogPost').DataTable(dtOverrideGlobals);

    // Premium search -> global search
    $('#amtexBpostSearch').on('input', function () {
        table.search(this.value).draw();
    });

    $('a[data-toggle="tab"]').on('shown.bs.tab click', function (e) {
        $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
    });

});
</script>
@endsection
