@extends('layouts.admin')
@section('content')

<div class="amtex-page">

    <div class="amtex-header">
        <div>
            <h2 class="amtex-title">{{ trans('global.edit') }} {{ trans('cruds.siteSetting.title_singular') }}</h2>
            <p class="amtex-subtitle">Update your website identity and contact details (singleton settings).</p>
        </div>

        <div class="amtex-actions">
            @if(session('message'))
                <div class="amtex-alert">{{ session('message') }}</div>
            @endif

            <a class="btn amtex-btn-outline" href="{{ route('admin.site-settings.index') }}">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.site-settings.update', [$siteSetting->id]) }}" enctype="multipart/form-data" class="amtex-form">
        @method('PUT')
        @csrf

        <div class="amtex-split">
            {{-- LEFT --}}
            <div class="amtex-left">

                {{-- Brand & Contact --}}
                <div class="amtex-card">
                    <div class="amtex-card-head">
                        <h4>Brand & Contact</h4>
                        <span class="amtex-chip">Required</span>
                    </div>

                    <div class="amtex-form-grid">
                        <div class="amtex-input">
                            <label class="required" for="site_name">{{ trans('cruds.siteSetting.fields.site_name') }}</label>
                            <input
                                class="form-control amtex-control {{ $errors->has('site_name') ? 'is-invalid' : '' }}"
                                type="text"
                                name="site_name"
                                id="site_name"
                                value="{{ old('site_name', $siteSetting->site_name) }}"
                                placeholder="e.g. Amtex Safety Systems"
                                required
                            >
                            @if($errors->has('site_name'))
                                <div class="invalid-feedback">{{ $errors->first('site_name') }}</div>
                            @endif
                            <small class="amtex-help">{{ trans('cruds.siteSetting.fields.site_name_helper') }}</small>
                        </div>

                        <div class="amtex-input">
                            <label class="required" for="phone">{{ trans('cruds.siteSetting.fields.phone') }}</label>
                            <input
                                class="form-control amtex-control {{ $errors->has('phone') ? 'is-invalid' : '' }}"
                                type="text"
                                name="phone"
                                id="phone"
                                value="{{ old('phone', $siteSetting->phone) }}"
                                placeholder="e.g. +91 99999 99999"
                                required
                            >
                            @if($errors->has('phone'))
                                <div class="invalid-feedback">{{ $errors->first('phone') }}</div>
                            @endif
                            <small class="amtex-help">{{ trans('cruds.siteSetting.fields.phone_helper') }}</small>
                        </div>

                        <div class="amtex-input">
                            <label class="required" for="email">{{ trans('cruds.siteSetting.fields.email') }}</label>
                            <input
                                class="form-control amtex-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                type="email"
                                name="email"
                                id="email"
                                value="{{ old('email', $siteSetting->email) }}"
                                placeholder="e.g. support@amtex.com"
                                required
                            >
                            @if($errors->has('email'))
                                <div class="invalid-feedback">{{ $errors->first('email') }}</div>
                            @endif
                            <small class="amtex-help">{{ trans('cruds.siteSetting.fields.email_helper') }}</small>
                        </div>

                        <div class="amtex-input">
                            <label for="whatsapp">{{ trans('cruds.siteSetting.fields.whatsapp') }}</label>
                            <input
                                class="form-control amtex-control {{ $errors->has('whatsapp') ? 'is-invalid' : '' }}"
                                type="text"
                                name="whatsapp"
                                id="whatsapp"
                                value="{{ old('whatsapp', $siteSetting->whatsapp) }}"
                                placeholder="e.g. +91 99999 99999"
                            >
                            @if($errors->has('whatsapp'))
                                <div class="invalid-feedback">{{ $errors->first('whatsapp') }}</div>
                            @endif
                            <small class="amtex-help">{{ trans('cruds.siteSetting.fields.whatsapp_helper') }}</small>
                        </div>

                        <div class="amtex-input amtex-span-2">
                            <label class="required" for="address">{{ trans('cruds.siteSetting.fields.address') }}</label>
                            <textarea
                                class="form-control amtex-control amtex-textarea {{ $errors->has('address') ? 'is-invalid' : '' }}"
                                name="address"
                                id="address"
                                placeholder="Full address for footer & contact page..."
                                required
                            >{{ old('address', $siteSetting->address) }}</textarea>
                            @if($errors->has('address'))
                                <div class="invalid-feedback">{{ $errors->first('address') }}</div>
                            @endif
                            <small class="amtex-help">{{ trans('cruds.siteSetting.fields.address_helper') }}</small>
                        </div>
                    </div>
                </div>

                {{-- Branding --}}
                <div class="amtex-card mt-3">
                    <div class="amtex-card-head">
                        <h4>Branding</h4>
                        <span class="amtex-chip amtex-chip-alt">Logo & Favicon</span>
                    </div>

                    <div class="amtex-form-grid">
                        <div class="amtex-input">
                            <label>Website Logo</label>

                            @if($siteSetting->logo)
                                <div class="amtex-preview-block mb-2">
                                    <img src="{{ asset('storage/'.$siteSetting->logo) }}" alt="Logo" style="max-height:60px;">
                                </div>
                            @endif

                            <input
                                type="file"
                                name="logo"
                                class="form-control amtex-control {{ $errors->has('logo') ? 'is-invalid' : '' }}"
                                accept="image/*"
                            >
                            @if($errors->has('logo'))
                                <div class="invalid-feedback">{{ $errors->first('logo') }}</div>
                            @endif
                            <small class="amtex-help">Upload to replace existing logo.</small>
                        </div>

                        <div class="amtex-input">
                            <label>Favicon</label>

                            @if($siteSetting->favicon)
                                <div class="amtex-preview-block mb-2">
                                    <img src="{{ asset('storage/'.$siteSetting->favicon) }}" alt="Favicon" style="max-height:32px;">
                                </div>
                            @endif

                            <input
                                type="file"
                                name="favicon"
                                class="form-control amtex-control {{ $errors->has('favicon') ? 'is-invalid' : '' }}"
                                accept="image/png,image/x-icon,image/svg+xml,image/*"
                            >
                            @if($errors->has('favicon'))
                                <div class="invalid-feedback">{{ $errors->first('favicon') }}</div>
                            @endif
                            <small class="amtex-help">Browser tab icon.</small>
                        </div>
                    </div>
                </div>

                {{-- Footer & Location --}}
                <div class="amtex-card mt-3">
                    <div class="amtex-card-head">
                        <h4>Footer & Location</h4>
                        <span class="amtex-chip amtex-chip-alt">Recommended</span>
                    </div>

                    <div class="amtex-form-grid">
                        <div class="amtex-input amtex-span-2">
                            <label class="required" for="footer_about">{{ trans('cruds.siteSetting.fields.footer_about') }}</label>
                            <textarea
                                class="form-control amtex-control amtex-textarea {{ $errors->has('footer_about') ? 'is-invalid' : '' }}"
                                name="footer_about"
                                id="footer_about"
                                placeholder="Short about text shown in footer..."
                                required
                            >{{ old('footer_about', $siteSetting->footer_about) }}</textarea>
                            @if($errors->has('footer_about'))
                                <div class="invalid-feedback">{{ $errors->first('footer_about') }}</div>
                            @endif
                            <small class="amtex-help">{{ trans('cruds.siteSetting.fields.footer_about_helper') }}</small>
                        </div>

                        <div class="amtex-input amtex-span-2">
                            <label for="map_embed">{{ trans('cruds.siteSetting.fields.map_embed') }}</label>
                            <textarea
                                class="form-control amtex-control amtex-textarea amtex-codearea {{ $errors->has('map_embed') ? 'is-invalid' : '' }}"
                                name="map_embed"
                                id="map_embed"
                                placeholder="Paste Google Map iframe embed code here..."
                            >{{ old('map_embed', $siteSetting->map_embed) }}</textarea>
                            @if($errors->has('map_embed'))
                                <div class="invalid-feedback">{{ $errors->first('map_embed') }}</div>
                            @endif
                            <small class="amtex-help">{{ trans('cruds.siteSetting.fields.map_embed_helper') }}</small>
                        </div>
                    </div>
                </div>

                {{-- Social Links --}}
                <div class="amtex-card mt-3">
                    <div class="amtex-card-head">
                        <h4>Social Links</h4>
                        <span class="amtex-chip amtex-chip-warn">Optional</span>
                    </div>

                    <div class="amtex-form-grid">
                        <div class="amtex-input">
                            <label for="facebook_url">{{ trans('cruds.siteSetting.fields.facebook_url') }}</label>
                            <input
                                class="form-control amtex-control {{ $errors->has('facebook_url') ? 'is-invalid' : '' }}"
                                type="text"
                                name="facebook_url"
                                id="facebook_url"
                                value="{{ old('facebook_url', $siteSetting->facebook_url) }}"
                                placeholder="https://facebook.com/yourpage"
                            >
                            @if($errors->has('facebook_url'))
                                <div class="invalid-feedback">{{ $errors->first('facebook_url') }}</div>
                            @endif
                            <small class="amtex-help">{{ trans('cruds.siteSetting.fields.facebook_url_helper') }}</small>
                        </div>

                        <div class="amtex-input">
                            <label for="instagram_url">{{ trans('cruds.siteSetting.fields.instagram_url') }}</label>
                            <input
                                class="form-control amtex-control {{ $errors->has('instagram_url') ? 'is-invalid' : '' }}"
                                type="text"
                                name="instagram_url"
                                id="instagram_url"
                                value="{{ old('instagram_url', $siteSetting->instagram_url) }}"
                                placeholder="https://instagram.com/yourhandle"
                            >
                            @if($errors->has('instagram_url'))
                                <div class="invalid-feedback">{{ $errors->first('instagram_url') }}</div>
                            @endif
                            <small class="amtex-help">{{ trans('cruds.siteSetting.fields.instagram_url_helper') }}</small>
                        </div>

                        <div class="amtex-input">
                            <label for="linkedin">{{ trans('cruds.siteSetting.fields.linkedin') }}</label>
                            <input
                                class="form-control amtex-control {{ $errors->has('linkedin') ? 'is-invalid' : '' }}"
                                type="text"
                                name="linkedin"
                                id="linkedin"
                                value="{{ old('linkedin', $siteSetting->linkedin) }}"
                                placeholder="https://linkedin.com/company/yourcompany"
                            >
                            @if($errors->has('linkedin'))
                                <div class="invalid-feedback">{{ $errors->first('linkedin') }}</div>
                            @endif
                            <small class="amtex-help">{{ trans('cruds.siteSetting.fields.linkedin_helper') }}</small>
                        </div>

                        <div class="amtex-input">
                            <label for="youtube">{{ trans('cruds.siteSetting.fields.youtube') }}</label>
                            <input
                                class="form-control amtex-control {{ $errors->has('youtube') ? 'is-invalid' : '' }}"
                                type="text"
                                name="youtube"
                                id="youtube"
                                value="{{ old('youtube', $siteSetting->youtube) }}"
                                placeholder="https://youtube.com/@yourchannel"
                            >
                            @if($errors->has('youtube'))
                                <div class="invalid-feedback">{{ $errors->first('youtube') }}</div>
                            @endif
                            <small class="amtex-help">{{ trans('cruds.siteSetting.fields.youtube_helper') }}</small>
                        </div>
                    </div>
                </div>

                <div class="amtex-form-footer">
                    <a href="{{ route('admin.site-settings.index') }}" class="btn amtex-btn-outline">Cancel</a>
                    <button class="btn amtex-btn" type="submit">
                        <i class="fas fa-save"></i> Update Settings
                    </button>
                </div>

            </div>

            {{-- RIGHT --}}
            <div class="amtex-right">

                <div class="amtex-card">
                    <div class="amtex-card-head">
                        <h4>Quick Preview</h4>
                        <span class="amtex-chip">Live</span>
                    </div>

                    <div class="amtex-preview-block">
                        <div class="amtex-preview-label">Site Name</div>
                        <div class="amtex-preview-value">{{ old('site_name', $siteSetting->site_name) }}</div>
                    </div>

                    <div class="amtex-preview-block">
                        <div class="amtex-preview-label">Primary Contact</div>
                        <div class="amtex-preview-value">
                            {{ old('phone', $siteSetting->phone) }}<br>
                            {{ old('email', $siteSetting->email) }}
                        </div>
                    </div>

                    <div class="amtex-preview-block">
                        <div class="amtex-preview-label">Address</div>
                        <div class="amtex-preview-value amtex-prewrap">{{ old('address', $siteSetting->address) }}</div>
                    </div>

                    <div class="amtex-preview-block">
                        <div class="amtex-preview-label">Branding</div>
                        <div class="amtex-preview-value">
                            <div class="mb-2">
                                <div class="amtex-preview-label">Logo</div>
                                @if($siteSetting->logo)
                                    <img src="{{ asset('storage/'.$siteSetting->logo) }}" alt="Logo" style="max-height:46px;">
                                @else
                                    <div class="amtex-muted">No logo uploaded</div>
                                @endif
                            </div>

                            <div>
                                <div class="amtex-preview-label">Favicon</div>
                                @if($siteSetting->favicon)
                                    <img src="{{ asset('storage/'.$siteSetting->favicon) }}" alt="Favicon" style="max-height:24px;">
                                @else
                                    <div class="amtex-muted">No favicon uploaded</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="amtex-card mt-3">
                    <div class="amtex-card-head">
                        <h4>Map Preview</h4>
                        <span class="amtex-chip amtex-chip-warn">Embed</span>
                    </div>

                    @php
                        $embed = old('map_embed', $siteSetting->map_embed);
                    @endphp

                    @if($embed && str_contains($embed, '<iframe'))
                        <div class="amtex-map">{!! $embed !!}</div>
                        <div class="amtex-muted mt-2">Preview showing iframe embed.</div>
                    @elseif($embed)
                        <div class="amtex-muted">Paste full iframe code for preview (not just a URL).</div>
                        <div class="amtex-preview-code">{{ $embed }}</div>
                    @else
                        <div class="amtex-muted">No map embed added.</div>
                    @endif
                </div>

            </div>
        </div>

    </form>

</div>

@endsection
