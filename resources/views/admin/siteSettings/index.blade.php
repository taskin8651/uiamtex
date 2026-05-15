@extends('layouts.admin')
@section('content')

<div class="amtex-page">
    <div class="amtex-header">
        <div>
            <h2 class="amtex-title">Site Settings</h2>
            <p class="amtex-subtitle">Manage your website’s primary identity and contact information.</p>
        </div>

        <div class="amtex-actions">
            @if(session('message'))
                <div class="amtex-alert">{{ session('message') }}</div>
            @endif

            {{-- HERO BANNER BUTTON --}}
            @can('home_hero_access')
                <a class="btn amtex-btn-outline" href="{{ route('admin.home-heroes.index') }}">
                    <i class="fas fa-images"></i> Hero Banner
                </a>
            @endcan

            @can('site_setting_create')
                @if(!$siteSetting)
                    <a class="btn amtex-btn" href="{{ route('admin.site-settings.create') }}">
                        <i class="fas fa-plus"></i> Add Settings
                    </a>
                @endif
            @endcan

            @can('site_setting_edit')
                @if($siteSetting)
                    <a class="btn amtex-btn-outline" href="{{ route('admin.site-settings.edit', $siteSetting->id) }}">
                        <i class="fas fa-pen"></i> Edit Settings
                    </a>
                @endif
            @endcan
        </div>
    </div>

    @if(!$siteSetting)
        <div class="amtex-empty">
            <div class="amtex-empty-card">
                <div class="amtex-badge">No Data</div>
                <h3>Site Settings not configured yet</h3>
                <p>Add your brand name, contact details, branding, social links, footer about, and map embed once.</p>

                @can('site_setting_create')
                    <a class="btn amtex-btn mt-2" href="{{ route('admin.site-settings.create') }}">
                        Create Site Settings
                    </a>
                @endcan
            </div>
        </div>
    @else
        <div class="row g-3">
            <div class="col-lg-7">
                <div class="amtex-card">
                    <div class="amtex-card-head">
                        <h4>Brand & Contact</h4>
                        <span class="amtex-chip">Active</span>
                    </div>

                    <div class="amtex-grid">
                        <div class="amtex-field">
                            <div class="amtex-label">Site Name</div>
                            <div class="amtex-value">{{ $siteSetting->site_name ?? '-' }}</div>
                        </div>

                        <div class="amtex-field">
                            <div class="amtex-label">Phone</div>
                            <div class="amtex-value">{{ $siteSetting->phone ?? '-' }}</div>
                        </div>

                        <div class="amtex-field">
                            <div class="amtex-label">Email</div>
                            <div class="amtex-value">{{ $siteSetting->email ?? '-' }}</div>
                        </div>

                        <div class="amtex-field">
                            <div class="amtex-label">WhatsApp</div>
                            <div class="amtex-value">{{ $siteSetting->whatsapp ?? '-' }}</div>
                        </div>

                        <div class="amtex-field">
                            <div class="amtex-label">Logo</div>
                            @if($siteSetting->logo)
                                <img src="{{ asset('storage/'.$siteSetting->logo) }}" style="max-height:50px;" alt="Logo">
                            @else
                                <div class="amtex-muted">Not uploaded</div>
                            @endif
                        </div>

                        <div class="amtex-field">
                            <div class="amtex-label">Favicon</div>
                            @if($siteSetting->favicon)
                                <img src="{{ asset('storage/'.$siteSetting->favicon) }}" style="max-height:24px;" alt="Favicon">
                            @else
                                <div class="amtex-muted">Not uploaded</div>
                            @endif
                        </div>

                        <div class="amtex-field amtex-field-full">
                            <div class="amtex-label">Address</div>
                            <div class="amtex-value">{{ $siteSetting->address ?? '-' }}</div>
                        </div>

                        <div class="amtex-field amtex-field-full">
                            <div class="amtex-label">Footer About</div>
                            <div class="amtex-value amtex-prewrap">{{ $siteSetting->footer_about ?? '-' }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="amtex-card">
                    <div class="amtex-card-head">
                        <h4>Social Links</h4>
                        <span class="amtex-chip amtex-chip-alt">Connected</span>
                    </div>

                    <div class="amtex-links">
                        <div class="amtex-link-row">
                            <div class="amtex-icon">f</div>
                            <div>
                                <div class="amtex-label">Facebook</div>
                                <div class="amtex-value">{{ $siteSetting->facebook_url ?? '-' }}</div>
                            </div>
                        </div>

                        <div class="amtex-link-row">
                            <div class="amtex-icon">ig</div>
                            <div>
                                <div class="amtex-label">Instagram</div>
                                <div class="amtex-value">{{ $siteSetting->instagram_url ?? '-' }}</div>
                            </div>
                        </div>

                        <div class="amtex-link-row">
                            <div class="amtex-icon">in</div>
                            <div>
                                <div class="amtex-label">LinkedIn</div>
                                <div class="amtex-value">{{ $siteSetting->linkedin ?? '-' }}</div>
                            </div>
                        </div>

                        <div class="amtex-link-row">
                            <div class="amtex-icon">yt</div>
                            <div>
                                <div class="amtex-label">YouTube</div>
                                <div class="amtex-value">{{ $siteSetting->youtube ?? '-' }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="amtex-card mt-3">
                    <div class="amtex-card-head">
                        <h4>Map Embed</h4>
                        <span class="amtex-chip amtex-chip-warn">Location</span>
                    </div>

                    @if($siteSetting->map_embed)
                        <div class="amtex-map">
                            {!! $siteSetting->map_embed !!}
                        </div>
                    @else
                        <div class="amtex-muted">No map embed added.</div>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>

@endsection
