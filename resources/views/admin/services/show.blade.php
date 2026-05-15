@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <span>{{ trans('global.show') }} Service</span>
        <a class="btn btn-default btn-sm" href="{{ route('admin.services.index') }}">
            {{ trans('global.back_to_list') }}
        </a>
    </div>

    <div class="card-body">

        <div class="row g-3">
            <div class="col-md-6">
                <div class="p-3 border rounded">
                    <div class="text-muted small">Title</div>
                    <div class="fw-bold">{{ $service->title }}</div>

                    @if($service->category)
                        <div class="text-muted small mt-2">Category</div>
                        <div>{{ $service->category }}</div>
                    @endif

                    <div class="text-muted small mt-2">Status</div>
                    <div>
                        @if((string)$service->is_active === 'yes')
                            <span class="badge badge-success">Active</span>
                        @else
                            <span class="badge badge-secondary">Inactive</span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="p-3 border rounded">
                    <div class="text-muted small">Sort Order</div>
                    <div class="fw-bold">{{ $service->sort_order ?? 0 }}</div>

                    @if($service->cta_label)
                        <div class="text-muted small mt-2">CTA Label</div>
                        <div>{{ $service->cta_label }}</div>
                    @endif

                    <div class="text-muted small mt-2">Updated</div>
                    <div>{{ optional($service->updated_at)->format('d M Y, h:i A') }}</div>
                </div>
            </div>

            <div class="col-12">
                <div class="p-3 border rounded">
                    <div class="text-muted small">Short Description</div>
                    <div>{{ $service->short_description ?: '—' }}</div>
                </div>
            </div>

            <div class="col-12">
                <div class="p-3 border rounded">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="text-muted small">Features</div>
                        <div class="text-muted small">Total: {{ $service->features->count() }}</div>
                    </div>

                    @if($service->features->count())
                        <ul class="mt-2 mb-0">
                            @foreach($service->features->sortBy('sort_order') as $f)
                                <li>{{ $f->feature_text }}</li>
                            @endforeach
                        </ul>
                    @else
                        <div class="mt-2 text-muted">No features added.</div>
                    @endif
                </div>
            </div>
        </div>

        <div class="mt-3">
            <a class="btn btn-default" href="{{ route('admin.services.index') }}">
                {{ trans('global.back_to_list') }}
            </a>
        </div>

    </div>
</div>

@endsection
