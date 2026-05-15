@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.amcEnquiry.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.amc-enquiries.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.amcEnquiry.fields.id') }}
                        </th>
                        <td>
                            {{ $amcEnquiry->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.amcEnquiry.fields.user') }}
                        </th>
                        <td>
                            {{ $amcEnquiry->user }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.amcEnquiry.fields.plan_type') }}
                        </th>
                        <td>
                            {{ $amcEnquiry->plan_type }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.amcEnquiry.fields.city') }}
                        </th>
                        <td>
                            {{ $amcEnquiry->city }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.amcEnquiry.fields.site_type') }}
                        </th>
                        <td>
                            {{ $amcEnquiry->site_type }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.amcEnquiry.fields.phone') }}
                        </th>
                        <td>
                            {{ $amcEnquiry->phone }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.amcEnquiry.fields.email') }}
                        </th>
                        <td>
                            {{ $amcEnquiry->email }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.amcEnquiry.fields.message') }}
                        </th>
                        <td>
                            {{ $amcEnquiry->message }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.amcEnquiry.fields.status') }}
                        </th>
                        <td>
                            {{ $amcEnquiry->status }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.amcEnquiry.fields.admin_notes') }}
                        </th>
                        <td>
                            {!! $amcEnquiry->admin_notes !!}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.amc-enquiries.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection