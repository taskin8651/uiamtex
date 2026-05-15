@extends('layouts.admin')
@section('content')

<div class="amtex-page">

    <div class="amtex-header">
        <div>
            <h2 class="amtex-title">Work Gallery Details</h2>
        </div>

        <div class="amtex-actions">
            <a class="btn btn-light" href="{{ route('admin.work-galleries.index') }}">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <div class="amtex-card">
        <div class="amtex-card-body">
            <div><strong>Title:</strong> {{ $workGallery->title }}</div>
            <div class="mt-1"><strong>Status:</strong> {{ $workGallery->is_active === 'yes' ? 'Active' : 'Inactive' }}</div>
            <div class="mt-1"><strong>Sort Order:</strong> {{ $workGallery->sort_order }}</div>

            <div class="mt-3">
                <strong>Image:</strong>
                <div class="mt-2">
                    @if($workGallery->image)
                        <img src="{{ asset($workGallery->image) }}" alt="{{ $workGallery->title }}"
                             class="img-fluid rounded border" style="max-height: 350px;">
                    @else
                        <div class="alert alert-warning mb-0 mt-2">No image uploaded.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>

@endsection