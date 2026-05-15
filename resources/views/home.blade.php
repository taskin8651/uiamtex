@extends('layouts.admin')

@section('content')
<div class="content amtex-dashboard">

    <!-- Page Header -->
    <div class="amtex-dash-header mb-4">
        <div class="amtex-dash-header-left">
            <h2 class="amtex-dash-title mb-1">Dashboard</h2>
            <p class="amtex-dash-subtitle mb-0">Quick overview of your platform activity and latest records.</p>
        </div>
        <div class="amtex-dash-header-right">
            <div class="amtex-dash-pill">
                <i class="fa fa-shield mr-2"></i> Admin Panel
            </div>
        </div>
    </div>

    @if(session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <!-- Stat Cards -->
    <div class="row">
        <div class="{{ $settings1['column_class'] }}">
            <div class="amtex-stat-card">
                <div class="amtex-stat-top">
                    <div class="amtex-stat-icon"><i class="fas fa-chart-line"></i></div>
                    <div class="amtex-stat-meta">
                        <div class="amtex-stat-value">{{ number_format($settings1['total_number']) }}</div>
                        <div class="amtex-stat-label">{{ $settings1['chart_title'] }}</div>
                    </div>
                </div>
                <div class="amtex-stat-foot">
                    <span class="amtex-stat-hint">Updated just now</span>
                    <span class="amtex-stat-dot"></span>
                </div>
            </div>
        </div>

        <div class="{{ $settings2['column_class'] }}">
            <div class="amtex-stat-card">
                <div class="amtex-stat-top">
                    <div class="amtex-stat-icon"><i class="fas fa-bolt"></i></div>
                    <div class="amtex-stat-meta">
                        <div class="amtex-stat-value">{{ number_format($settings2['total_number']) }}</div>
                        <div class="amtex-stat-label">{{ $settings2['chart_title'] }}</div>
                    </div>
                </div>
                <div class="amtex-stat-foot">
                    <span class="amtex-stat-hint">Quick snapshot</span>
                    <span class="amtex-stat-dot"></span>
                </div>
            </div>
        </div>

        <div class="{{ $settings3['column_class'] }}">
            <div class="amtex-stat-card">
                <div class="amtex-stat-top">
                    <div class="amtex-stat-icon"><i class="fas fa-layer-group"></i></div>
                    <div class="amtex-stat-meta">
                        <div class="amtex-stat-value">{{ number_format($settings3['total_number']) }}</div>
                        <div class="amtex-stat-label">{{ $settings3['chart_title'] }}</div>
                    </div>
                </div>
                <div class="amtex-stat-foot">
                    <span class="amtex-stat-hint">At a glance</span>
                    <span class="amtex-stat-dot"></span>
                </div>
            </div>
        </div>

        <div class="{{ $settings4['column_class'] }}">
            <div class="amtex-stat-card">
                <div class="amtex-stat-top">
                    <div class="amtex-stat-icon"><i class="fas fa-shopping-cart"></i></div>
                    <div class="amtex-stat-meta">
                        <div class="amtex-stat-value">{{ number_format($settings4['total_number']) }}</div>
                        <div class="amtex-stat-label">{{ $settings4['chart_title'] }}</div>
                    </div>
                </div>
                <div class="amtex-stat-foot">
                    <span class="amtex-stat-hint">New updates</span>
                    <span class="amtex-stat-dot"></span>
                </div>
            </div>
        </div>

        <div class="{{ $settings5['column_class'] }}">
            <div class="amtex-stat-card">
                <div class="amtex-stat-top">
                    <div class="amtex-stat-icon"><i class="fas fa-inbox"></i></div>
                    <div class="amtex-stat-meta">
                        <div class="amtex-stat-value">{{ number_format($settings5['total_number']) }}</div>
                        <div class="amtex-stat-label">{{ $settings5['chart_title'] }}</div>
                    </div>
                </div>
                <div class="amtex-stat-foot">
                    <span class="amtex-stat-hint">Keep tracking</span>
                    <span class="amtex-stat-dot"></span>
                </div>
            </div>
        </div>

        <div class="{{ $settings6['column_class'] }}">
            <div class="amtex-stat-card">
                <div class="amtex-stat-top">
                    <div class="amtex-stat-icon"><i class="fas fa-user-check"></i></div>
                    <div class="amtex-stat-meta">
                        <div class="amtex-stat-value">{{ number_format($settings6['total_number']) }}</div>
                        <div class="amtex-stat-label">{{ $settings6['chart_title'] }}</div>
                    </div>
                </div>
                <div class="amtex-stat-foot">
                    <span class="amtex-stat-hint">Performance</span>
                    <span class="amtex-stat-dot"></span>
                </div>
            </div>
        </div>

        <div class="{{ $settings7['column_class'] }}">
            <div class="amtex-stat-card">
                <div class="amtex-stat-top">
                    <div class="amtex-stat-icon"><i class="fas fa-file-alt"></i></div>
                    <div class="amtex-stat-meta">
                        <div class="amtex-stat-value">{{ number_format($settings7['total_number']) }}</div>
                        <div class="amtex-stat-label">{{ $settings7['chart_title'] }}</div>
                    </div>
                </div>
                <div class="amtex-stat-foot">
                    <span class="amtex-stat-hint">Overview</span>
                    <span class="amtex-stat-dot"></span>
                </div>
            </div>
        </div>

        <div class="{{ $settings8['column_class'] }}">
            <div class="amtex-stat-card">
                <div class="amtex-stat-top">
                    <div class="amtex-stat-icon"><i class="fas fa-headset"></i></div>
                    <div class="amtex-stat-meta">
                        <div class="amtex-stat-value">{{ number_format($settings8['total_number']) }}</div>
                        <div class="amtex-stat-label">{{ $settings8['chart_title'] }}</div>
                    </div>
                </div>
                <div class="amtex-stat-foot">
                    <span class="amtex-stat-hint">Live status</span>
                    <span class="amtex-stat-dot"></span>
                </div>
            </div>
        </div>

        <!-- Latest Entries Widget -->
        <div class="{{ $settings9['column_class'] }} mt-2">
            <div class="amtex-panel">
                <div class="amtex-panel-head">
                    <div>
                        <h4 class="amtex-panel-title mb-0">{{ $settings9['chart_title'] }}</h4>
                        <p class="amtex-panel-sub mb-0">Most recent records</p>
                    </div>
                    <div class="amtex-panel-chip">
                        <i class="fa fa-clock mr-2"></i>Latest
                    </div>
                </div>

                <div class="amtex-panel-body" style="overflow-x:auto;">
                    <table class="table amtex-table mb-0">
                        <thead>
                            <tr>
                                @foreach($settings9['fields'] as $key => $value)
                                    <th>
                                        {{ trans(sprintf('cruds.%s.fields.%s', $settings9['translation_key'] ?? 'pleaseUpdateWidget', $key)) }}
                                    </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($settings9['data'] as $entry)
                                <tr>
                                    @foreach($settings9['fields'] as $key => $value)
                                        <td>
                                            @if($value === '')
                                                {{ $entry->{$key} }}
                                            @elseif(is_iterable($entry->{$key}))
                                                @foreach($entry->{$key} as $subEentry)
                                                    <span class="amtex-badge">{{ $subEentry->{$value} }}</span>
                                                @endforeach
                                            @else
                                                {{ data_get($entry, $key . '.' . $value) }}
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ count($settings9['fields']) }}" class="text-center text-muted py-4">
                                        No entries found
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    </div>
</div>
@endsection

@section('scripts')
@parent
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
@endsection
