@extends('layouts.admin')
@section('content')
@can('dealership_application_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.dealership-applications.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.dealershipApplication.title_singular') }}
            </a>
            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'DealershipApplication', 'route' => 'admin.dealership-applications.parseCsvImport'])
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.dealershipApplication.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-DealershipApplication">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.dealershipApplication.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.dealershipApplication.fields.full_name') }}
                    </th>
                    <th>
                        {{ trans('cruds.dealershipApplication.fields.mobile') }}
                    </th>
                    <th>
                        {{ trans('cruds.dealershipApplication.fields.email') }}
                    </th>
                    <th>
                        {{ trans('cruds.dealershipApplication.fields.city_state') }}
                    </th>
                    <th>
                        {{ trans('cruds.dealershipApplication.fields.business_type') }}
                    </th>
                    <th>
                        {{ trans('cruds.dealershipApplication.fields.sales_focus') }}
                    </th>
                    <th>
                        {{ trans('cruds.dealershipApplication.fields.experience') }}
                    </th>
                    <th>
                        {{ trans('cruds.dealershipApplication.fields.upload_compay_profile') }}
                    </th>
                    <th>
                        {{ trans('cruds.dealershipApplication.fields.upload_gst') }}
                    </th>
                    <th>
                        {{ trans('cruds.dealershipApplication.fields.status') }}
                    </th>
                    <th>
                        &nbsp;
                    </th>
                </tr>
            </thead>
        </table>
    </div>
</div>



@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('dealership_application_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.dealership-applications.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).data(), function (entry) {
          return entry.id
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  let dtOverrideGlobals = {
    buttons: dtButtons,
    processing: true,
    serverSide: true,
    retrieve: true,
    aaSorting: [],
    ajax: "{{ route('admin.dealership-applications.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'full_name', name: 'full_name' },
{ data: 'mobile', name: 'mobile' },
{ data: 'email', name: 'email' },
{ data: 'city_state', name: 'city_state' },
{ data: 'business_type', name: 'business_type' },
{ data: 'sales_focus', name: 'sales_focus' },
{ data: 'experience', name: 'experience' },
{ data: 'upload_compay_profile', name: 'upload_compay_profile', sortable: false, searchable: false },
{ data: 'upload_gst', name: 'upload_gst', sortable: false, searchable: false },
{ data: 'status', name: 'status' },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  };
  let table = $('.datatable-DealershipApplication').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
});

</script>
@endsection