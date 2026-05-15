@extends('layouts.admin')
@section('content')

<div class="amtex-page">

    <div class="amtex-header">
        <div>
            <h2 class="amtex-title">{{ trans('global.show') }} {{ trans('cruds.industry.title_singular') ?? 'Industry' }}</h2>
            <p class="amtex-subtitle">View industry details.</p>
        </div>

        <div class="amtex-actions d-flex gap-2">
            <a class="btn btn-light" href="{{ route('admin.industries.index') }}">
                <i class="fas fa-arrow-left"></i> Back
            </a>

            @can('industry_edit')
                <a class="btn btn-primary" href="{{ route('admin.industries.edit', $industry->id) }}">
                    <i class="fas fa-pen"></i> Edit
                </a>
            @endcan
        </div>
    </div>

    <div class="amtex-card">
        <div class="amtex-card-head">
            <h4 class="mb-0">Industry</h4>
        </div>

        <div class="amtex-card-body">
            <div class="row g-3">

                <div class="col-md-6">
                    <div class="small text-muted">ID</div>
                    <div class="fw-bold">#{{ $industry->id }}</div>
                </div>

                <div class="col-md-6">
                    <div class="small text-muted">Status</div>
                    <div class="fw-bold">
                        @if((string)$industry->is_active === 'yes' || (string)$industry->is_active === '1')
                            Active
                        @else
                            Inactive
                        @endif
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="small text-muted">Title</div>
                    <div class="fw-bold">{{ $industry->title }}</div>
                </div>

                <div class="col-md-4">
                    <div class="small text-muted">Sort Order</div>
                    <div class="fw-bold">{{ $industry->sort_order ?? 0 }}</div>
                </div>

                <div class="col-12">
                    <div class="small text-muted">Last Updated</div>
                    <div class="fw-bold">{{ optional($industry->updated_at)->format('d M Y, h:i A') }}</div>
                </div>

            </div>
        </div>
    </div>

</div>

@endsection
 