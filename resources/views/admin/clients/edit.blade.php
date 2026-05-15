@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.client.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.clients.update", [$client->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.client.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $client->name) }}" required>
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.client.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="logo">{{ trans('cruds.client.fields.logo') }}</label>
                <div class="needsclick dropzone {{ $errors->has('logo') ? 'is-invalid' : '' }}" id="logo-dropzone">
                </div>
                @if($errors->has('logo'))
                    <div class="invalid-feedback">
                        {{ $errors->first('logo') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.client.fields.logo_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="sort_order">{{ trans('cruds.client.fields.sort_order') }}</label>
                <input class="form-control {{ $errors->has('sort_order') ? 'is-invalid' : '' }}" type="text" name="sort_order" id="sort_order" value="{{ old('sort_order', $client->sort_order) }}" required>
                @if($errors->has('sort_order'))
                    <div class="invalid-feedback">
                        {{ $errors->first('sort_order') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.client.fields.sort_order_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.client.fields.is_active') }}</label>
                <select class="form-control {{ $errors->has('is_active') ? 'is-invalid' : '' }}" name="is_active" id="is_active">
                    <option value disabled {{ old('is_active', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Client::IS_ACTIVE_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('is_active', $client->is_active) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('is_active'))
                    <div class="invalid-feedback">
                        {{ $errors->first('is_active') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.client.fields.is_active_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection

@section('scripts')
<script>
    Dropzone.options.logoDropzone = {
    url: '{{ route('admin.clients.storeMedia') }}',
    maxFilesize: 10, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 10,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').find('input[name="logo"]').remove()
      $('form').append('<input type="hidden" name="logo" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="logo"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($client) && $client->logo)
      var file = {!! json_encode($client->logo) !!}
          this.options.addedfile.call(this, file)
      this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="logo" value="' + file.file_name + '">')
      this.options.maxFiles = this.options.maxFiles - 1
@endif
    },
    error: function (file, response) {
        if ($.type(response) === 'string') {
            var message = response //dropzone sends it's own error messages in string
        } else {
            var message = response.errors.file
        }
        file.previewElement.classList.add('dz-error')
        _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
        _results = []
        for (_i = 0, _len = _ref.length; _i < _len; _i++) {
            node = _ref[_i]
            _results.push(node.textContent = message)
        }

        return _results
    }
}

</script>
@endsection