@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.wishlist.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.wishlists.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.wishlist.fields.id') }}
                        </th>
                        <td>
                            {{ $wishlist->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.wishlist.fields.user') }}
                        </th>
                        <td>
                            {{ $wishlist->user->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.wishlist.fields.product') }}
                        </th>
                        <td>
                            {{ $wishlist->product->name ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.wishlists.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection