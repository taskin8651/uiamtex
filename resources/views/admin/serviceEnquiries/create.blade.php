@extends('layouts.admin')
@section('content')

<div class="amtex-page">

    <div class="amtex-header">
        <div>
            <h2 class="amtex-title">Create Service Enquiry</h2>
            <p class="amtex-subtitle">Manual entry (normally created from frontend form).</p>
        </div>
        <div class="amtex-actions">
            <a class="btn btn-light" href="{{ route('admin.service-enquiries.index') }}">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <div class="amtex-card">
        <div class="amtex-card-head">
            <h4 class="mb-0">Enquiry Details</h4>
        </div>

        <div class="amtex-card-body">
            <form method="POST" action="{{ route('admin.service-enquiries.store') }}">
                @csrf

                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="amtex-label">Premises Type</label>
                        <input type="text" name="premises_type" class="form-control {{ $errors->has('premises_type') ? 'is-invalid' : '' }}"
                               value="{{ old('premises_type') }}" placeholder="Apartment / Office / Retail etc.">
                        @if($errors->has('premises_type')) <div class="invalid-feedback">{{ $errors->first('premises_type') }}</div> @endif
                    </div>

                    <div class="col-md-6">
                        <label class="amtex-label">Service Required</label>
                        <input type="text" name="service_required" class="form-control {{ $errors->has('service_required') ? 'is-invalid' : '' }}"
                               value="{{ old('service_required') }}" placeholder="AMC / Refilling / Installation etc.">
                        @if($errors->has('service_required')) <div class="invalid-feedback">{{ $errors->first('service_required') }}</div> @endif
                    </div>

                    <div class="col-md-6">
                        <label class="amtex-label required">Name</label>
                        <input type="text" name="name" required class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                               value="{{ old('name') }}">
                        @if($errors->has('name')) <div class="invalid-feedback">{{ $errors->first('name') }}</div> @endif
                    </div>

                    <div class="col-md-6">
                        <label class="amtex-label required">Phone</label>
                        <input type="text" name="phone" required class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}"
                               value="{{ old('phone') }}">
                        @if($errors->has('phone')) <div class="invalid-feedback">{{ $errors->first('phone') }}</div> @endif
                    </div>

                    <div class="col-md-6">
                        <label class="amtex-label">Email</label>
                        <input type="email" name="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                               value="{{ old('email') }}">
                        @if($errors->has('email')) <div class="invalid-feedback">{{ $errors->first('email') }}</div> @endif
                    </div>

                    <div class="col-md-6">
                        <label class="amtex-label">City</label>
                        <input type="text" name="city" class="form-control {{ $errors->has('city') ? 'is-invalid' : '' }}"
                               value="{{ old('city') }}">
                        @if($errors->has('city')) <div class="invalid-feedback">{{ $errors->first('city') }}</div> @endif
                    </div>

                    <div class="col-12">
                        <label class="amtex-label">Message</label>
                        <textarea name="message" rows="4" class="form-control {{ $errors->has('message') ? 'is-invalid' : '' }}">{{ old('message') }}</textarea>
                        @if($errors->has('message')) <div class="invalid-feedback">{{ $errors->first('message') }}</div> @endif
                    </div>

                    <div class="col-md-4">
                        <label class="amtex-label">Status</label>
                        <select name="status" class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}">
                            @foreach($statusOptions as $key => $label)
                                <option value="{{ $key }}" {{ old('status', 'new') === $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('status')) <div class="invalid-feedback">{{ $errors->first('status') }}</div> @endif
                    </div>

                </div>

                <div class="mt-4 d-flex gap-2">
                    <button class="btn btn-danger" type="submit">
                        <i class="fas fa-save"></i> Save
                    </button>
                    <a class="btn btn-light" href="{{ route('admin.service-enquiries.index') }}">Cancel</a>
                </div>
            </form>
        </div>
    </div>

</div>

@endsection
