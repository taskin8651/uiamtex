@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.address.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.addresses.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.address.fields.id') }}
                        </th>
                        <td>
                            {{ $address->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.address.fields.user') }}
                        </th>
                        <td>
                            {{ $address->user->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.address.fields.label') }}
                        </th>
                        <td>
                            {{ $address->label }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.address.fields.line_1') }}
                        </th>
                        <td>
                            {{ $address->line_1 }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.address.fields.line_2') }}
                        </th>
                        <td>
                            {{ $address->line_2 }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.address.fields.city') }}
                        </th>
                        <td>
                            {{ $address->city }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.address.fields.state') }}
                        </th>
                        <td>
                            {{ $address->state }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.address.fields.pincode') }}
                        </th>
                        <td>
                            {{ $address->pincode }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.address.fields.country') }}
                        </th>
                        <td>
                            {{ $address->country }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.address.fields.is_default') }}
                        </th>
                        <td>
                            {{ App\Models\Address::IS_DEFAULT_SELECT[$address->is_default] ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.addresses.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection