@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.bulkQuoteRequest.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.bulk-quote-requests.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.bulkQuoteRequest.fields.id') }}
                        </th>
                        <td>
                            {{ $bulkQuoteRequest->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.bulkQuoteRequest.fields.product') }}
                        </th>
                        <td>
                            {{ $bulkQuoteRequest->product }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.bulkQuoteRequest.fields.variant') }}
                        </th>
                        <td>
                            {{ $bulkQuoteRequest->variant }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.bulkQuoteRequest.fields.qty') }}
                        </th>
                        <td>
                            {{ $bulkQuoteRequest->qty }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.bulkQuoteRequest.fields.company_name') }}
                        </th>
                        <td>
                            {{ $bulkQuoteRequest->company_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.bulkQuoteRequest.fields.city') }}
                        </th>
                        <td>
                            {{ $bulkQuoteRequest->city }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.bulkQuoteRequest.fields.phone') }}
                        </th>
                        <td>
                            {{ $bulkQuoteRequest->phone }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.bulkQuoteRequest.fields.email') }}
                        </th>
                        <td>
                            {{ $bulkQuoteRequest->email }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.bulkQuoteRequest.fields.notes') }}
                        </th>
                        <td>
                            {{ $bulkQuoteRequest->notes }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.bulkQuoteRequest.fields.status') }}
                        </th>
                        <td>
                            {{ $bulkQuoteRequest->status }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.bulkQuoteRequest.fields.admin_notes') }}
                        </th>
                        <td>
                            {{ $bulkQuoteRequest->admin_notes }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.bulk-quote-requests.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection