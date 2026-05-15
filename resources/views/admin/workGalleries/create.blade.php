@extends('layouts.admin')
@section('content')

<div class="amtex-page">

    <div class="amtex-header">
        <div>
            <h2 class="amtex-title">Create Work Gallery</h2>
            <p class="amtex-subtitle">Add a Work Gallery item.</p>
        </div>

        <div class="amtex-actions">
            <a class="btn btn-light" href="{{ route('admin.work-galleries.index') }}">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <div class="amtex-card">
        <div class="amtex-card-body">
            <form method="POST" action="{{ route('admin.work-galleries.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="amtex-label required">Title</label>
                        <input type="text" name="title" class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}"
                               value="{{ old('title') }}" required>
                        @if($errors->has('title'))
                            <div class="invalid-feedback">{{ $errors->first('title') }}</div>
                        @endif
                    </div>

                    <div class="col-md-3">
                        <label class="amtex-label">Sort Order</label>
                        <input type="number" name="sort_order" class="form-control {{ $errors->has('sort_order') ? 'is-invalid' : '' }}"
                               value="{{ old('sort_order', 0) }}" min="0">
                        @if($errors->has('sort_order'))
                            <div class="invalid-feedback">{{ $errors->first('sort_order') }}</div>
                        @endif
                    </div>

                    <div class="col-md-3">
                        <label class="amtex-label">Status</label>
                        <select name="is_active" class="form-control {{ $errors->has('is_active') ? 'is-invalid' : '' }}">
                            <option value="yes" {{ old('is_active','yes') == 'yes' ? 'selected' : '' }}>YES</option>
                            <option value="no" {{ old('is_active') == 'no' ? 'selected' : '' }}>NO</option>
                        </select>
                        @if($errors->has('is_active'))
                            <div class="invalid-feedback">{{ $errors->first('is_active') }}</div>
                        @endif
                    </div>

                    <div class="col-12">
                        <label class="amtex-label required">Image</label>
                        <input type="file" name="image" class="form-control {{ $errors->has('image') ? 'is-invalid' : '' }}" accept="image/*" required>
                        @if($errors->has('image'))
                            <div class="invalid-feedback">{{ $errors->first('image') }}</div>
                        @endif
                    </div>

                </div>

                <div class="mt-4 d-flex gap-2">
                    <button class="btn btn-danger" type="submit">
                        <i class="fas fa-save"></i> Save
                    </button>
                    <a class="btn btn-light" href="{{ route('admin.work-galleries.index') }}">Cancel</a>
                </div>

            </form>
        </div>
    </div>

</div>

@endsection