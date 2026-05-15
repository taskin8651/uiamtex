@extends('layouts.admin')
@section('content')

<div class="amtex-page">
    <div class="amtex-header">
        <div>
            <h2 class="amtex-title">Work Gallery</h2>
            <p class="amtex-subtitle">Manage Work Gallery items.</p>
        </div>

        <div class="amtex-actions d-flex gap-2 flex-wrap">
            @if(session('message'))
                <div class="amtex-alert">{{ session('message') }}</div>
            @endif

            @can('work_gallery_create')
                <a class="btn amtex-btn" href="{{ route('admin.work-galleries.create') }}">
                    <i class="fas fa-plus"></i> Add Work Gallery
                </a>
            @endcan
        </div>
    </div>

    <div class="row g-3">
        @forelse($workGalleries as $item)
            <div class="col-md-6 col-lg-4">
                <div class="amtex-card h-100">

                    @if($item->image)
                        <div class="p-3 pb-0">
                            <img src="{{ asset($item->image) }}" alt="{{ $item->title }}"
                                 class="img-fluid rounded border"
                                 style="width:100%; height:220px; object-fit:cover;">
                        </div>
                    @endif

                    <div class="amtex-card-head d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">{{ $item->title }}</h4>
                        <span class="amtex-chip {{ $item->is_active === 'yes' ? '' : 'amtex-chip-warn' }}">
                            {{ $item->is_active === 'yes' ? 'Active' : 'Inactive' }}
                        </span>
                    </div>

                    <div class="amtex-card-body">
                        <div class="small text-muted">
                            Sort: <strong>{{ $item->sort_order }}</strong>
                        </div>
                    </div>

                    <div class="amtex-card-footer d-flex justify-content-end gap-1">
                        @can('work_gallery_show')
                            <a href="{{ route('admin.work-galleries.show', $item->id) }}" class="btn btn-sm btn-outline-secondary">View</a>
                        @endcan
                        @can('work_gallery_edit')
                            <a href="{{ route('admin.work-galleries.edit', $item->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                        @endcan
                        @can('work_gallery_delete')
                            <form action="{{ route('admin.work-galleries.destroy', $item->id) }}" method="POST"
                                  onsubmit="return confirm('{{ trans('global.areYouSure') }}');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" type="submit">Delete</button>
                            </form>
                        @endcan
                    </div>

                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-warning mb-0">No work gallery items found.</div>
            </div>
        @endforelse
    </div>

    <div class="mt-4 d-flex justify-content-center">
        {{ $workGalleries->links() }}
    </div>
</div>

@endsection