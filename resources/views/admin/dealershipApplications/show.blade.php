@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.dealershipApplication.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.dealership-applications.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.dealershipApplication.fields.id') }}
                        </th>
                        <td>
                            {{ $dealershipApplication->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.dealershipApplication.fields.full_name') }}
                        </th>
                        <td>
                            {{ $dealershipApplication->full_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.dealershipApplication.fields.mobile') }}
                        </th>
                        <td>
                            {{ $dealershipApplication->mobile }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.dealershipApplication.fields.email') }}
                        </th>
                        <td>
                            {{ $dealershipApplication->email }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.dealershipApplication.fields.city_state') }}
                        </th>
                        <td>
                            {{ $dealershipApplication->city_state }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.dealershipApplication.fields.business_type') }}
                        </th>
                        <td>
                            {{ $dealershipApplication->business_type }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.dealershipApplication.fields.sales_focus') }}
                        </th>
                        <td>
                            {{ $dealershipApplication->sales_focus }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.dealershipApplication.fields.experience') }}
                        </th>
                        <td>
                            {{ $dealershipApplication->experience }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.dealershipApplication.fields.upload_compay_profile') }}
                        </th>
                        <td>
                            @if($dealershipApplication->upload_compay_profile)
                                <a href="{{ $dealershipApplication->upload_compay_profile->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.dealershipApplication.fields.upload_gst') }}
                        </th>
                        <td>
                            @if($dealershipApplication->upload_gst)
                                <a href="{{ $dealershipApplication->upload_gst->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.dealershipApplication.fields.status') }}
                        </th>
                        <td>
                            {{ $dealershipApplication->status }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.dealershipApplication.fields.admin_notes') }}
                        </th>
                        <td>
                            {!! $dealershipApplication->admin_notes !!}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.dealership-applications.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection