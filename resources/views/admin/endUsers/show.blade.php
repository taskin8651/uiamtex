@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.endUser.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.end-users.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.endUser.fields.id') }}
                        </th>
                        <td>
                            {{ $endUser->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.endUser.fields.name') }}
                        </th>
                        <td>
                            {{ $endUser->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.endUser.fields.phone') }}
                        </th>
                        <td>
                            {{ $endUser->phone }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.endUser.fields.email') }}
                        </th>
                        <td>
                            {{ $endUser->email }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.endUser.fields.password') }}
                        </th>
                        <td>
                            ********
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.endUser.fields.status') }}
                        </th>
                        <td>
                            {{ App\Models\EndUser::STATUS_SELECT[$endUser->status] ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.end-users.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection