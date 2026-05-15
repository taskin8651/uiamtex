@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <span>{{ trans('global.show') }} Process Step</span>
        <a class="btn btn-default btn-sm" href="{{ route('admin.service-process-steps.index') }}">
            {{ trans('global.back_to_list') }}
        </a>
    </div>

    <div class="card-body">
        <div class="row g-3">

            <div class="col-md-6">
                <div class="p-3 border rounded">
                    <div class="text-muted small">Step No</div>
                    <div class="fw-bold">{{ str_pad((int)$serviceProcessStep->step_no, 2, '0', STR_PAD_LEFT) }}</div>

                    <div class="text-muted small mt-2">Title</div>
                    <div class="fw-bold">{{ $serviceProcessStep->title }}</div>

                    <div class="text-muted small mt-2">Status</div>
                    <div>
                        @if((string)$serviceProcessStep->is_active === 'yes')
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
                    <div class="fw-bold">{{ $serviceProcessStep->sort_order ?? 0 }}</div>

                    <div class="text-muted small mt-2">Updated</div>
                    <div>{{ optional($serviceProcessStep->updated_at)->format('d M Y, h:i A') }}</div>

                    <div class="text-muted small mt-2">Created</div>
                    <div>{{ optional($serviceProcessStep->created_at)->format('d M Y, h:i A') }}</div>
                </div>
            </div>

            <div class="col-12">
                <div class="p-3 border rounded">
                    <div class="text-muted small">Description</div>
                    <div>{{ $serviceProcessStep->description ?: '—' }}</div>
                </div>
            </div>

        </div>

        <div class="mt-3">
            <a class="btn btn-default" href="{{ route('admin.service-process-steps.index') }}">
                {{ trans('global.back_to_list') }}
            </a>
        </div>
    </div>
</div>

@endsection
