@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.siteSetting.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.site-settings.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.siteSetting.fields.id') }}
                        </th>
                        <td>
                            {{ $siteSetting->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.siteSetting.fields.site_name') }}
                        </th>
                        <td>
                            {{ $siteSetting->site_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.siteSetting.fields.phone') }}
                        </th>
                        <td>
                            {{ $siteSetting->phone }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.siteSetting.fields.email') }}
                        </th>
                        <td>
                            {{ $siteSetting->email }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.siteSetting.fields.address') }}
                        </th>
                        <td>
                            {{ $siteSetting->address }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.siteSetting.fields.whatsapp') }}
                        </th>
                        <td>
                            {{ $siteSetting->whatsapp }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.siteSetting.fields.footer_about') }}
                        </th>
                        <td>
                            {{ $siteSetting->footer_about }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.siteSetting.fields.map_embed') }}
                        </th>
                        <td>
                            {{ $siteSetting->map_embed }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.siteSetting.fields.facebook_url') }}
                        </th>
                        <td>
                            {{ $siteSetting->facebook_url }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.siteSetting.fields.instagram_url') }}
                        </th>
                        <td>
                            {{ $siteSetting->instagram_url }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.siteSetting.fields.linkedin') }}
                        </th>
                        <td>
                            {{ $siteSetting->linkedin }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.siteSetting.fields.youtube') }}
                        </th>
                        <td>
                            {{ $siteSetting->youtube }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.site-settings.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection