@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.faq.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.faqs.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.faq.fields.id') }}
                        </th>
                        <td>
                            {{ $faq->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.faq.fields.select_category') }}
                        </th>
                        <td>
                            {{ $faq->select_category->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.faq.fields.question') }}
                        </th>
                        <td>
                            {{ $faq->question }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.faq.fields.answer') }}
                        </th>
                        <td>
                            {!! $faq->answer !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.faq.fields.sort_order') }}
                        </th>
                        <td>
                            {{ $faq->sort_order }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.faq.fields.is_active') }}
                        </th>
                        <td>
                            {{ App\Models\Faq::IS_ACTIVE_SELECT[$faq->is_active] ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.faqs.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection