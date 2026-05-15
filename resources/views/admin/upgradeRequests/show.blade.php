@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.upgradeRequest.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.upgrade-requests.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.upgradeRequest.fields.id') }}
                        </th>
                        <td>
                            {{ $upgradeRequest->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.upgradeRequest.fields.user') }}
                        </th>
                        <td>
                            {{ $upgradeRequest->user }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.upgradeRequest.fields.current_extinguisher_type') }}
                        </th>
                        <td>
                            {{ $upgradeRequest->current_extinguisher_type }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.upgradeRequest.fields.qty') }}
                        </th>
                        <td>
                            {{ $upgradeRequest->qty }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.upgradeRequest.fields.city') }}
                        </th>
                        <td>
                            {{ $upgradeRequest->city }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.upgradeRequest.fields.phone') }}
                        </th>
                        <td>
                            {{ $upgradeRequest->phone }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.upgradeRequest.fields.email') }}
                        </th>
                        <td>
                            {{ $upgradeRequest->email }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.upgradeRequest.fields.message') }}
                        </th>
                        <td>
                            {{ $upgradeRequest->message }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.upgradeRequest.fields.status') }}
                        </th>
                        <td>
                            {{ $upgradeRequest->status }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.upgradeRequest.fields.admin_notes') }}
                        </th>
                        <td>
                            {{ $upgradeRequest->admin_notes }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.upgrade-requests.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection