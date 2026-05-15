<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ trans('panel.site_title') }}</title>

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet" />
    <link href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/select/1.3.0/css/select.dataTables.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" rel="stylesheet" />
    <link href="https://unpkg.com/@coreui/coreui@3.2/dist/css/coreui.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/1.5.0/css/perfect-scrollbar.min.css" rel="stylesheet" />

    <!-- Google Fonts (Inter) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <link href="{{ asset('css/custom.css') }}" rel="stylesheet" />
    @yield('styles')
</head>

<body class="c-app amtex-admin-shell">
    @include('partials.menu')

    <div class="c-wrapper">

        <!-- =======================
             AMTEX PREMIUM HEADER
             ======================= -->
        <header class="c-header c-header-fixed px-3 amtex-admin-header">
            <div class="amtex-admin-header-inner">

                <!-- Left: toggles + brand -->
                <div class="amtex-header-left">
                    <button class="c-header-toggler c-class-toggler d-lg-none mfe-auto amtex-header-btn" type="button" data-target="#sidebar" data-class="c-sidebar-show">
                        <i class="fas fa-fw fa-bars"></i>
                    </button>

                    <button class="c-header-toggler mfs-3 d-md-down-none amtex-header-btn" type="button" responsive="true">
                        <i class="fas fa-fw fa-bars"></i>
                    </button>

                    <a class="amtex-header-brand d-none d-lg-flex" href="{{ route('admin.home') }}">
                        <span class="amtex-header-logo-wrap">
                            <img src="{{ asset('img/logo.png') }}" class="amtex-header-logo" alt="{{ trans('panel.site_title') }}">
                        </span>
                        <span class="amtex-header-brand-text">
                            <span class="amtex-header-title">{{ trans('panel.site_title') }}</span>
                            <span class="amtex-header-subtitle">Admin Dashboard</span>
                        </span>
                    </a>

                    <a class="c-header-brand d-lg-none amtex-header-brand-mobile" href="{{ route('admin.home') }}">
                        {{ trans('panel.site_title') }}
                    </a>
                </div>

                <!-- Right: quick actions -->
                <ul class="c-header-nav ml-auto amtex-header-right">

                    @if(count(config('panel.available_languages', [])) > 1)
                        <li class="c-header-nav-item dropdown d-md-down-none mr-2">
                            <a class="c-header-nav-link amtex-header-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-globe mr-2"></i>{{ strtoupper(app()->getLocale()) }}
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                @foreach(config('panel.available_languages') as $langLocale => $langName)
                                    <a class="dropdown-item" href="{{ url()->current() }}?change_language={{ $langLocale }}">
                                        {{ strtoupper($langLocale) }} ({{ $langName }})
                                    </a>
                                @endforeach
                            </div>
                        </li>
                    @endif

                    <li class="c-header-nav-item d-none d-md-flex mr-2">
                        <span class="amtex-header-chip">
                            <i class="fa fa-shield-alt mr-2"></i>Secure Admin
                        </span>
                    </li>

                    <li class="c-header-nav-item">
                        <a class="c-header-nav-link amtex-header-link"
                           href="#"
                           onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                            <i class="fas fa-sign-out-alt mr-2"></i>Logout
                        </a>
                    </li>
                </ul>

            </div>
        </header>

        <div class="c-body">
            <main class="c-main">

                <div class="container-fluid amtex-admin-content">

                    @if(session('message'))
                        <div class="row mb-2">
                            <div class="col-lg-12">
                                <div class="alert alert-success" role="alert">{{ session('message') }}</div>
                            </div>
                        </div>
                    @endif

                    @if($errors->count() > 0)
                        <div class="alert alert-danger">
                            <ul class="list-unstyled">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @yield('content')

                </div>

            </main>

            <!-- =======================
                 AMTEX FOOTER
                 ======================= -->
            <footer class="amtex-admin-footer">
                <div class="container-fluid">
                    <div class="amtex-admin-footer-inner">
                        <div class="amtex-admin-footer-left">
                            Engineered with <span class="amtex-heart" aria-hidden="true">❤</span>
                            by
                            <a class="amtex-footer-link" href="https://uiprocorp.com/" target="_blank" rel="noopener">
                                Uipro Corporation Pvt. Ltd.
                            </a>
                        </div>
                        <div class="amtex-admin-footer-right">
                            <span class="amtex-version">Version: V1.0.0</span>
                        </div>
                    </div>
                </div>
            </footer>

            <form id="logoutform" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/1.5.0/perfect-scrollbar.min.js"></script>
    <script src="https://unpkg.com/@coreui/coreui@3.2/dist/js/coreui.min.js"></script>
    <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <script src="//cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js"></script>
    <script src="//cdn.datatables.net/buttons/1.2.4/js/buttons.flash.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.colVis.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/select/1.3.0/js/dataTables.select.min.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/16.0.0/classic/ckeditor.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>
    <script src="{{ asset('js/main.js') }}"></script>

    <script>
        $(function() {
          let copyButtonTrans = '{{ trans('global.datatables.copy') }}'
          let csvButtonTrans = '{{ trans('global.datatables.csv') }}'
          let excelButtonTrans = '{{ trans('global.datatables.excel') }}'
          let pdfButtonTrans = '{{ trans('global.datatables.pdf') }}'
          let printButtonTrans = '{{ trans('global.datatables.print') }}'
          let colvisButtonTrans = '{{ trans('global.datatables.colvis') }}'
          let selectAllButtonTrans = '{{ trans('global.select_all') }}'
          let selectNoneButtonTrans = '{{ trans('global.deselect_all') }}'

          let languages = {
            'en': 'https://cdn.datatables.net/plug-ins/1.10.19/i18n/English.json'
          };

          $.extend(true, $.fn.dataTable.Buttons.defaults.dom.button, { className: 'btn' })
          $.extend(true, $.fn.dataTable.defaults, {
            language: { url: languages['{{ app()->getLocale() }}'] },
            columnDefs: [{
                orderable: false,
                className: 'select-checkbox',
                targets: 0
            }, {
                orderable: false,
                searchable: false,
                targets: -1
            }],
            select: {
              style: 'multi+shift',
              selector: 'td:first-child'
            },
            order: [],
            scrollX: true,
            pageLength: 100,
            dom: 'lBfrtip<"actions">',
            buttons: [
              {
                extend: 'selectAll',
                className: 'btn-primary',
                text: selectAllButtonTrans,
                exportOptions: { columns: ':visible' },
                action: function(e, dt) {
                  e.preventDefault()
                  dt.rows().deselect();
                  dt.rows({ search: 'applied' }).select();
                }
              },
              {
                extend: 'selectNone',
                className: 'btn-primary',
                text: selectNoneButtonTrans,
                exportOptions: { columns: ':visible' }
              },
              { extend: 'copy', className: 'btn-default', text: copyButtonTrans, exportOptions: { columns: ':visible' } },
              { extend: 'csv', className: 'btn-default', text: csvButtonTrans, exportOptions: { columns: ':visible' } },
              { extend: 'excel', className: 'btn-default', text: excelButtonTrans, exportOptions: { columns: ':visible' } },
              { extend: 'pdf', className: 'btn-default', text: pdfButtonTrans, exportOptions: { columns: ':visible' } },
              { extend: 'print', className: 'btn-default', text: printButtonTrans, exportOptions: { columns: ':visible' } },
              { extend: 'colvis', className: 'btn-default', text: colvisButtonTrans, exportOptions: { columns: ':visible' } }
            ]
          });

          $.fn.dataTable.ext.classes.sPageButton = '';
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.searchable-field').select2({
                minimumInputLength: 3,
                ajax: {
                    url: '{{ route("admin.globalSearch") }}',
                    dataType: 'json',
                    type: 'GET',
                    delay: 200,
                    data: function (term) {
                        return { search: term };
                    },
                    results: function (data) {
                        return { data };
                    }
                },
                escapeMarkup: function (markup) { return markup; },
                templateResult: formatItem,
                templateSelection: formatItemSelection,
                placeholder : '{{ trans('global.search') }}...',
                language: {
                    inputTooShort: function(args) {
                        var remainingChars = args.minimum - args.input.length;
                        var translation = '{{ trans('global.search_input_too_short') }}';
                        return translation.replace(':count', remainingChars);
                    },
                    errorLoading: function() { return '{{ trans('global.results_could_not_be_loaded') }}'; },
                    searching: function() { return '{{ trans('global.searching') }}'; },
                    noResults: function() { return '{{ trans('global.no_results') }}'; },
                }
            });

            function formatItem (item) {
                if (item.loading) return '{{ trans('global.searching') }}...';
                var markup = "<div class='searchable-link' href='" + item.url + "'>";
                markup += "<div class='searchable-title'>" + item.model + "</div>";
                $.each(item.fields, function(key, field) {
                    markup += "<div class='searchable-fields'>" + item.fields_formated[field] + " : " + item[field] + "</div>";
                });
                markup += "</div>";
                return markup;
            }

            function formatItemSelection (item) {
                if (!item.model) return '{{ trans('global.search') }}...';
                return item.model;
            }

            $(document).delegate('.searchable-link', 'click', function() {
                var url = $(this).attr('href');
                window.location = url;
            });
        });
    </script>

    @yield('scripts')
</body>

</html>
