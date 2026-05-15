@extends('layouts.admin')
@section('content')
@can('amc_enquiry_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.amc-enquiries.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.amcEnquiry.title_singular') }}
            </a>
            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'AmcEnquiry', 'route' => 'admin.amc-enquiries.parseCsvImport'])
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.amcEnquiry.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-AmcEnquiry">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.amcEnquiry.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.amcEnquiry.fields.user') }}
                    </th>
                    <th>
                        {{ trans('cruds.amcEnquiry.fields.plan_type') }}
                    </th>
                    <th>
                        {{ trans('cruds.amcEnquiry.fields.city') }}
                    </th>
                    <th>
                        {{ trans('cruds.amcEnquiry.fields.site_type') }}
                    </th>
                    <th>
                        {{ trans('cruds.amcEnquiry.fields.phone') }}
                    </th>
                    <th>
                        {{ trans('cruds.amcEnquiry.fields.email') }}
                    </th>
                    <th>
                        {{ trans('cruds.amcEnquiry.fields.message') }}
                    </th>
                    <th>
                        {{ trans('cruds.amcEnquiry.fields.status') }}
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
@can('amc_enquiry_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.amc-enquiries.massDestroy') }}",
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
    ajax: "{{ route('admin.amc-enquiries.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'user', name: 'user' },
{ data: 'plan_type', name: 'plan_type' },
{ data: 'city', name: 'city' },
{ data: 'site_type', name: 'site_type' },
{ data: 'phone', name: 'phone' },
{ data: 'email', name: 'email' },
{ data: 'message', name: 'message' },
{ data: 'status', name: 'status' },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  };
  let table = $('.datatable-AmcEnquiry').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
});

</script>
@endsection