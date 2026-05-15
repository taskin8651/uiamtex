@extends('layouts.admin')
@section('content')

<div class="card hero-edit-card">
    <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
        <div>
            <strong>Edit Home Hero Slide</strong>
            <div class="text-muted small mt-1">
                Update slide content, images, ordering and visibility.
            </div>
        </div>
        <a class="btn btn-light" href="{{ route('admin.home-heroes.index') }}">
            Back to list
        </a>
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('admin.home-heroes.update', $hero->id) }}" enctype="multipart/form-data" id="heroEditForm">
            @csrf
            @method('PUT')

            <div class="row">
                {{-- LEFT: Content --}}
                <div class="col-12 col-lg-8">
                    <div class="card inner-card mb-3">
                        <div class="card-header">
                            <strong>Slide Content</strong>
                        </div>
                        <div class="card-body">

                            {{-- Badge --}}
                            <div class="row g-2">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="badge_text">Badge Text</label>
                                        <input
                                            class="form-control {{ $errors->has('badge_text') ? 'is-invalid' : '' }}"
                                            type="text"
                                            name="badge_text"
                                            id="badge_text"
                                            value="{{ old('badge_text', $hero->badge_text) }}"
                                            placeholder="Example: Fire Safety Awareness"
                                        >
                                        @if($errors->has('badge_text'))
                                            <div class="invalid-feedback">{{ $errors->first('badge_text') }}</div>
                                        @endif
                                        <small class="text-muted">Small label shown above the title.</small>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="badge_icon">Badge Icon Class</label>
                                        <input
                                            class="form-control {{ $errors->has('badge_icon') ? 'is-invalid' : '' }}"
                                            type="text"
                                            name="badge_icon"
                                            id="badge_icon"
                                            value="{{ old('badge_icon', $hero->badge_icon) }}"
                                            placeholder="Example: bi bi-megaphone"
                                        >
                                        @if($errors->has('badge_icon'))
                                            <div class="invalid-feedback">{{ $errors->first('badge_icon') }}</div>
                                        @endif
                                        <small class="text-muted">Bootstrap icon class (e.g., <code>bi bi-shield-check</code>).</small>
                                    </div>
                                </div>
                            </div>

                            {{-- Title --}}
                            <div class="row g-2">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="title_line_1">Title Line 1</label>
                                        <input
                                            class="form-control {{ $errors->has('title_line_1') ? 'is-invalid' : '' }}"
                                            type="text"
                                            name="title_line_1"
                                            id="title_line_1"
                                            value="{{ old('title_line_1', $hero->title_line_1) }}"
                                            placeholder="Example: Introducing"
                                        >
                                        @if($errors->has('title_line_1'))
                                            <div class="invalid-feedback">{{ $errors->first('title_line_1') }}</div>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="title_highlight">Title Highlight</label>
                                        <input
                                            class="form-control {{ $errors->has('title_highlight') ? 'is-invalid' : '' }}"
                                            type="text"
                                            name="title_highlight"
                                            id="title_highlight"
                                            value="{{ old('title_highlight', $hero->title_highlight) }}"
                                            placeholder="Example: Water Mist Fire Extinguishers"
                                        >
                                        @if($errors->has('title_highlight'))
                                            <div class="invalid-feedback">{{ $errors->first('title_highlight') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            {{-- Subtitle --}}
                            <div class="form-group">
                                <label for="subtitle">Subtitle</label>
                                <textarea
                                    class="form-control {{ $errors->has('subtitle') ? 'is-invalid' : '' }}"
                                    name="subtitle"
                                    id="subtitle"
                                    rows="5"
                                    placeholder="Short paragraph describing the slide..."
                                >{{ old('subtitle', $hero->subtitle) }}</textarea>
                                @if($errors->has('subtitle'))
                                    <div class="invalid-feedback">{{ $errors->first('subtitle') }}</div>
                                @endif
                                <small class="text-muted">Keep as plain text. If your frontend renders HTML, you may add limited HTML.</small>
                            </div>

                            {{-- Meta + CTA --}}
                            <div class="row g-2">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="meta_text">Meta Text</label>
                                        <input
                                            class="form-control {{ $errors->has('meta_text') ? 'is-invalid' : '' }}"
                                            type="text"
                                            name="meta_text"
                                            id="meta_text"
                                            value="{{ old('meta_text', $hero->meta_text) }}"
                                            placeholder="Example: Tested • Certified • Trusted Nationwide"
                                        >
                                        @if($errors->has('meta_text'))
                                            <div class="invalid-feedback">{{ $errors->first('meta_text') }}</div>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="cta_text">CTA Button Text</label>
                                        <input
                                            class="form-control {{ $errors->has('cta_text') ? 'is-invalid' : '' }}"
                                            type="text"
                                            name="cta_text"
                                            id="cta_text"
                                            value="{{ old('cta_text', $hero->cta_text) }}"
                                            placeholder="Example: Know More"
                                        >
                                        @if($errors->has('cta_text'))
                                            <div class="invalid-feedback">{{ $errors->first('cta_text') }}</div>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="cta_url">CTA URL</label>
                                        <input
                                            class="form-control {{ $errors->has('cta_url') ? 'is-invalid' : '' }}"
                                            type="text"
                                            name="cta_url"
                                            id="cta_url"
                                            value="{{ old('cta_url', $hero->cta_url) }}"
                                            placeholder="Example: /products"
                                        >
                                        @if($errors->has('cta_url'))
                                            <div class="invalid-feedback">{{ $errors->first('cta_url') }}</div>
                                        @endif
                                        <small class="text-muted">Use relative URL like <code>/products</code>.</small>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                {{-- RIGHT: Images + Settings --}}
                <div class="col-12 col-lg-4">

                    <div class="card inner-card mb-3">
                        <div class="card-header">
                            <strong>Images</strong>
                        </div>
                        <div class="card-body">

                            {{-- Desktop image --}}
                            <div class="form-group">
                                <label for="desktop_image">Desktop Image</label>
                                <input
                                    class="form-control {{ $errors->has('desktop_image') ? 'is-invalid' : '' }}"
                                    type="file"
                                    name="desktop_image"
                                    id="desktop_image"
                                    accept="image/*"
                                >
                                @if($errors->has('desktop_image'))
                                    <div class="invalid-feedback">{{ $errors->first('desktop_image') }}</div>
                                @endif

                                @if(!empty($hero->desktop_image))
                                    <div class="mt-2">
                                        <div class="preview-label">Current</div>
                                        <img
                                            src="{{ asset('storage/'.$hero->desktop_image) }}"
                                            class="img-fluid rounded border"
                                            alt="Current Desktop Image"
                                            style="width:100%; height:140px; object-fit:cover;"
                                        >
                                    </div>
                                @endif

                                <div class="mt-2 preview-box" id="desktopPreviewWrap" style="display:none;">
                                    <div class="preview-label">New Preview</div>
                                    <img id="desktopPreview" class="img-fluid rounded border" alt="Desktop Preview">
                                </div>
                            </div>

                            {{-- Mobile image --}}
                            <div class="form-group">
                                <label for="mobile_image">Mobile Image</label>
                                <input
                                    class="form-control {{ $errors->has('mobile_image') ? 'is-invalid' : '' }}"
                                    type="file"
                                    name="mobile_image"
                                    id="mobile_image"
                                    accept="image/*"
                                >
                                @if($errors->has('mobile_image'))
                                    <div class="invalid-feedback">{{ $errors->first('mobile_image') }}</div>
                                @endif

                                @if(!empty($hero->mobile_image))
                                    <div class="mt-2">
                                        <div class="preview-label">Current</div>
                                        <img
                                            src="{{ asset('storage/'.$hero->mobile_image) }}"
                                            class="img-fluid rounded border"
                                            alt="Current Mobile Image"
                                            style="width:100%; height:180px; object-fit:cover;"
                                        >
                                    </div>
                                @endif

                                <div class="mt-2 preview-box" id="mobilePreviewWrap" style="display:none;">
                                    <div class="preview-label">New Preview</div>
                                    <img id="mobilePreview" class="img-fluid rounded border" alt="Mobile Preview">
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="card inner-card mb-3">
                        <div class="card-header">
                            <strong>Settings</strong>
                        </div>
                        <div class="card-body">

                            {{-- Sort order --}}
                            <div class="form-group">
                                <label for="sort_order">Sort Order</label>
                                <input
                                    class="form-control {{ $errors->has('sort_order') ? 'is-invalid' : '' }}"
                                    type="number"
                                    name="sort_order"
                                    id="sort_order"
                                    value="{{ old('sort_order', $hero->sort_order ?? 0) }}"
                                    min="0"
                                >
                                @if($errors->has('sort_order'))
                                    <div class="invalid-feedback">{{ $errors->first('sort_order') }}</div>
                                @endif
                                <small class="text-muted">Lower number appears first.</small>
                            </div>

                            {{-- Is active --}}
                            <div class="form-group mb-0">
                                <div class="custom-control custom-switch">
                                    <input
                                        type="checkbox"
                                        class="custom-control-input"
                                        id="is_active"
                                        name="is_active"
                                        value="1"
                                        {{ old('is_active', (int) $hero->is_active === 1 ? 1 : 0) ? 'checked' : '' }}
                                    >
                                    <label class="custom-control-label" for="is_active">
                                        Active
                                    </label>
                                </div>
                                <small class="text-muted d-block mt-2">Inactive slides will not show on homepage.</small>
                            </div>

                        </div>
                    </div>

                    {{-- Info --}}
                    <div class="card inner-card">
                        <div class="card-body">
                            <div class="small text-muted">
                                Last updated:
                                <strong>{{ optional($hero->updated_at)->format('d M Y, h:i A') }}</strong>
                            </div>
                            <div class="small text-muted mt-1">
                                Slide ID: <strong>#{{ $hero->id }}</strong>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            {{-- Sticky Actions --}}
            <div class="hero-actions-sticky">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <a href="{{ route('admin.home-heroes.index') }}" class="btn btn-light">
                        Cancel
                    </a>

                    <button class="btn btn-danger" type="submit">
                        Update Slide
                    </button>
                </div>
            </div>

        </form>
    </div>
</div>

@endsection

@section('styles')
@parent
<style>
    .hero-edit-card .inner-card { border: 1px solid rgba(0,0,0,.08); }
    .hero-actions-sticky{
        position: sticky;
        bottom: 0;
        background: #fff;
        padding: 12px;
        border-top: 1px solid rgba(0,0,0,.08);
        margin-top: 10px;
        z-index: 5;
    }
    .preview-label{
        font-size: 12px;
        color: #666;
        margin-bottom: 6px;
        font-weight: 600;
    }
</style>
@endsection

@section('scripts')
@parent
<script>
(function () {

    function previewImage(input, imgEl, wrapEl) {
        const file = input.files && input.files[0] ? input.files[0] : null;
        if (!file) {
            wrapEl.style.display = 'none';
            imgEl.src = '';
            return;
        }
        const reader = new FileReader();
        reader.onload = function(e) {
            imgEl.src = e.target.result;
            wrapEl.style.display = 'block';
        };
        reader.readAsDataURL(file);
    }

    const desktopInput = document.getElementById('desktop_image');
    const mobileInput  = document.getElementById('mobile_image');

    if (desktopInput) {
        desktopInput.addEventListener('change', function() {
            previewImage(
                desktopInput,
                document.getElementById('desktopPreview'),
                document.getElementById('desktopPreviewWrap')
            );
        });
    }

    if (mobileInput) {
        mobileInput.addEventListener('change', function() {
            previewImage(
                mobileInput,
                document.getElementById('mobilePreview'),
                document.getElementById('mobilePreviewWrap')
            );
        });
    }

})();
</script>
@endsection
