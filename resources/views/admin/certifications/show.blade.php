@extends('layouts.admin')
@section('content')

<div class="amtex-page">

    {{-- Header --}}
    <div class="amtex-header">
        <div>
            <h2 class="amtex-title">{{ trans('global.show') }} {{ trans('cruds.certification.title_singular') }}</h2>
            <p class="amtex-subtitle">View certification details, image preview, and status.</p>
        </div>

        <div class="amtex-actions d-flex gap-2 flex-wrap">
            @can('certification_edit')
                <a class="btn amtex-btn" href="{{ route('admin.certifications.edit', $certification->id) }}">
                    <i class="fas fa-pen"></i> Edit
                </a>
            @endcan

            <a class="btn amtex-btn-outline" href="{{ route('admin.certifications.index') }}">
                <i class="fas fa-arrow-left"></i> Back to list
            </a>
        </div>
    </div>

    <div class="row g-3">

        {{-- Left: Image Preview --}}
        <div class="col-lg-5">
            <div class="amtex-card h-100">
                <div class="amtex-card-head d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">Certificate Image</h4>

                    @if((string)$certification->is_active === '1')
                        <span class="amtex-chip">Active</span>
                    @else
                        <span class="amtex-chip amtex-chip-warn">Inactive</span>
                    @endif
                </div>

                <div class="amtex-card-body">
                    @if($certification->image)
                        <a href="{{ $certification->image->getUrl() }}" target="_blank" rel="noopener" style="display:block;">
                            <img
                                src="{{ $certification->image->getUrl() }}"
                                alt="{{ $certification->title }}"
                                class="img-fluid rounded"
                                style="width:100%; object-fit:cover;"
                            >
                        </a>

                        <div class="small text-muted mt-2">
                            Click image to open full size.
                        </div>
                    @else
                        <div class="amtex-empty" style="padding: 28px 10px;">
                            <div class="amtex-empty-card" style="max-width: 100%;">
                                <div class="amtex-badge">No Image</div>
                                <h3 class="mb-1" style="font-size: 18px;">Image not uploaded</h3>
                                <p class="mb-0">You can upload the image from Edit page.</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Right: Details --}}
        <div class="col-lg-7">
            <div class="amtex-card h-100">
                <div class="amtex-card-head">
                    <h4 class="mb-0">Certification Details</h4>
                </div>

                <div class="amtex-card-body">

                    <div class="amtex-grid">

                        <div class="amtex-field">
                            <div class="amtex-label">{{ trans('cruds.certification.fields.id') }}</div>
                            <div class="amtex-value">#{{ $certification->id }}</div>
                        </div>

                        <div class="amtex-field">
                            <div class="amtex-label">{{ trans('cruds.certification.fields.sort_order') }}</div>
                            <div class="amtex-value">{{ $certification->sort_order ?? 0 }}</div>
                        </div>

                        <div class="amtex-field amtex-field-full">
                            <div class="amtex-label">{{ trans('cruds.certification.fields.title') }}</div>
                            <div class="amtex-value">{{ $certification->title ?? '-' }}</div>
                        </div>

                        <div class="amtex-field">
                            <div class="amtex-label">{{ trans('cruds.certification.fields.is_active') }}</div>
                            <div class="amtex-value">
                                {{ App\Models\Certification::IS_ACTIVE_SELECT[$certification->is_active] ?? '-' }}
                            </div>
                        </div>

                        <div class="amtex-field">
                            <div class="amtex-label">Last Updated</div>
                            <div class="amtex-value">
                                {{ optional($certification->updated_at)->format('d M Y, h:i A') ?? '-' }}
                            </div>
                        </div>

                    </div>

                </div>

                <div class="amtex-card-footer d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <a class="btn btn-light" href="{{ route('admin.certifications.index') }}">
                        Back
                    </a>

                    <div class="d-flex gap-2">
                        @can('certification_edit')
                            <a class="btn btn-outline-primary" href="{{ route('admin.certifications.edit', $certification->id) }}">
                                Edit
                            </a>
                        @endcan

                        @can('certification_delete')
                            <form
                                action="{{ route('admin.certifications.destroy', $certification->id) }}"
                                method="POST"
                                onsubmit="return confirm('Are you sure you want to delete this certification?');"
                            >
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-outline-danger">
                                    Delete
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
