@extends('layouts.admin')
@section('content')

<div class="amtex-page">

    {{-- Header --}}
    <div class="amtex-header">
        <div>
            <h2 class="amtex-title">{{ trans('global.show') }} {{ trans('cruds.download.title_singular') }}</h2>
            <p class="amtex-subtitle">View download details, file and visibility status.</p>
        </div>

        <div class="amtex-actions d-flex flex-wrap gap-2">
            <a class="btn amtex-btn-outline" href="{{ route('admin.downloads.index') }}">
                <i class="fas fa-arrow-left"></i> Back to List
            </a>

            @can('download_edit')
                <a class="btn amtex-btn" href="{{ route('admin.downloads.edit', $download->id) }}">
                    <i class="fas fa-pen"></i> Edit
                </a>
            @endcan
        </div>
    </div>

    {{-- Details Card --}}
    <div class="amtex-card">
        <div class="amtex-card-head d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Download Details</h4>

            @if((string)($download->is_active ?? '') === 'yes')
                <span class="amtex-chip">Active</span>
            @else
                <span class="amtex-chip amtex-chip-warn">Inactive</span>
            @endif
        </div>

        <div class="amtex-card-body">

            <div class="row g-3">

                {{-- Left: Meta --}}
                <div class="col-lg-6">
                    <div class="amtex-info-list">

                        <div class="amtex-info-row">
                            <div class="amtex-info-label">{{ trans('cruds.download.fields.id') }}</div>
                            <div class="amtex-info-value">#{{ $download->id }}</div>
                        </div>

                        <div class="amtex-info-row">
                            <div class="amtex-info-label">{{ trans('cruds.download.fields.title') }}</div>
                            <div class="amtex-info-value">{{ $download->title ?? '-' }}</div>
                        </div>

                        <div class="amtex-info-row">
                            <div class="amtex-info-label">{{ trans('cruds.download.fields.is_active') }}</div>
                            <div class="amtex-info-value">
                                {{ App\Models\Download::IS_ACTIVE_SELECT[$download->is_active] ?? '-' }}
                            </div>
                        </div>

                        <div class="amtex-info-row">
                            <div class="amtex-info-label">Created</div>
                            <div class="amtex-info-value">
                                {{ optional($download->created_at)->format('d M Y, h:i A') ?? '-' }}
                            </div>
                        </div>

                        <div class="amtex-info-row">
                            <div class="amtex-info-label">Updated</div>
                            <div class="amtex-info-value">
                                {{ optional($download->updated_at)->format('d M Y, h:i A') ?? '-' }}
                            </div>
                        </div>

                    </div>
                </div>

                {{-- Right: File --}}
                <div class="col-lg-6">
                    <div class="amtex-file-card">

                        <div class="d-flex align-items-center justify-content-between gap-2">
                            <div>
                                <div class="amtex-label mb-1">{{ trans('cruds.download.fields.file') }}</div>
                                <div class="small text-muted">
                                    {{ $download->file ? 'File is attached and available.' : 'No file attached.' }}
                                </div>
                            </div>

                            @if($download->file)
                                <span class="amtex-chip">
                                    <i class="fas fa-paperclip me-1"></i> Attached
                                </span>
                            @endif
                        </div>

                        <div class="mt-3 d-flex flex-wrap gap-2">
                            @if($download->file)
                                <a class="btn btn-outline-secondary" href="{{ $download->file->getUrl() }}" target="_blank" rel="noopener">
                                    <i class="fas fa-external-link-alt"></i> Open
                                </a>

                                <a class="btn btn-outline-primary" href="{{ $download->file->getUrl() }}" download>
                                    <i class="fas fa-download"></i> Download
                                </a>
                            @else
                                <button class="btn btn-light" type="button" disabled>
                                    <i class="fas fa-ban"></i> No File
                                </button>
                            @endif
                        </div>

                    </div>
                </div>

                {{-- Description --}}
                <div class="col-12">
                    <div class="amtex-card">
                        <div class="amtex-card-head">
                            <h4 class="mb-0">{{ trans('cruds.download.fields.description') }}</h4>
                        </div>

                        <div class="amtex-card-body">
                            @if(!empty($download->description))
                                <div class="amtex-richtext">
                                    {!! $download->description !!}
                                </div>
                            @else
                                <div class="text-muted">No description added.</div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Footer actions --}}
                <div class="col-12 d-flex justify-content-between flex-wrap gap-2">
                    <a class="btn btn-light" href="{{ route('admin.downloads.index') }}">
                        Back
                    </a>

                    <div class="d-flex gap-2">
                        @can('download_edit')
                            <a class="btn amtex-btn" href="{{ route('admin.downloads.edit', $download->id) }}">
                                <i class="fas fa-pen"></i> Edit
                            </a>
                        @endcan

                        @can('download_delete')
                            <form action="{{ route('admin.downloads.destroy', $download->id) }}" method="POST"
                                  onsubmit="return confirm('{{ trans('global.areYouSure') }}');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        @endcan
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>

@endsection
