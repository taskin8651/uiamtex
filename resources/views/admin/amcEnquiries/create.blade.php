@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.amcEnquiry.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.amc-enquiries.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="user">{{ trans('cruds.amcEnquiry.fields.user') }}</label>
                <input class="form-control {{ $errors->has('user') ? 'is-invalid' : '' }}" type="text" name="user" id="user" value="{{ old('user', '') }}">
                @if($errors->has('user'))
                    <div class="invalid-feedback">
                        {{ $errors->first('user') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.amcEnquiry.fields.user_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="plan_type">{{ trans('cruds.amcEnquiry.fields.plan_type') }}</label>
                <input class="form-control {{ $errors->has('plan_type') ? 'is-invalid' : '' }}" type="text" name="plan_type" id="plan_type" value="{{ old('plan_type', '') }}">
                @if($errors->has('plan_type'))
                    <div class="invalid-feedback">
                        {{ $errors->first('plan_type') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.amcEnquiry.fields.plan_type_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="city">{{ trans('cruds.amcEnquiry.fields.city') }}</label>
                <input class="form-control {{ $errors->has('city') ? 'is-invalid' : '' }}" type="text" name="city" id="city" value="{{ old('city', '') }}">
                @if($errors->has('city'))
                    <div class="invalid-feedback">
                        {{ $errors->first('city') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.amcEnquiry.fields.city_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="site_type">{{ trans('cruds.amcEnquiry.fields.site_type') }}</label>
                <input class="form-control {{ $errors->has('site_type') ? 'is-invalid' : '' }}" type="text" name="site_type" id="site_type" value="{{ old('site_type', '') }}">
                @if($errors->has('site_type'))
                    <div class="invalid-feedback">
                        {{ $errors->first('site_type') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.amcEnquiry.fields.site_type_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="phone">{{ trans('cruds.amcEnquiry.fields.phone') }}</label>
                <input class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" type="text" name="phone" id="phone" value="{{ old('phone', '') }}">
                @if($errors->has('phone'))
                    <div class="invalid-feedback">
                        {{ $errors->first('phone') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.amcEnquiry.fields.phone_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="email">{{ trans('cruds.amcEnquiry.fields.email') }}</label>
                <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="email" name="email" id="email" value="{{ old('email') }}">
                @if($errors->has('email'))
                    <div class="invalid-feedback">
                        {{ $errors->first('email') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.amcEnquiry.fields.email_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="message">{{ trans('cruds.amcEnquiry.fields.message') }}</label>
                <textarea class="form-control {{ $errors->has('message') ? 'is-invalid' : '' }}" name="message" id="message">{{ old('message') }}</textarea>
                @if($errors->has('message'))
                    <div class="invalid-feedback">
                        {{ $errors->first('message') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.amcEnquiry.fields.message_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="status">{{ trans('cruds.amcEnquiry.fields.status') }}</label>
                <input class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" type="text" name="status" id="status" value="{{ old('status', '') }}">
                @if($errors->has('status'))
                    <div class="invalid-feedback">
                        {{ $errors->first('status') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.amcEnquiry.fields.status_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="admin_notes">{{ trans('cruds.amcEnquiry.fields.admin_notes') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('admin_notes') ? 'is-invalid' : '' }}" name="admin_notes" id="admin_notes">{!! old('admin_notes') !!}</textarea>
                @if($errors->has('admin_notes'))
                    <div class="invalid-feedback">
                        {{ $errors->first('admin_notes') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.amcEnquiry.fields.admin_notes_helper') }}</span>
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
    $(document).ready(function () {
  function SimpleUploadAdapter(editor) {
    editor.plugins.get('FileRepository').createUploadAdapter = function(loader) {
      return {
        upload: function() {
          return loader.file
            .then(function (file) {
              return new Promise(function(resolve, reject) {
                // Init request
                var xhr = new XMLHttpRequest();
                xhr.open('POST', '{{ route('admin.amc-enquiries.storeCKEditorImages') }}', true);
                xhr.setRequestHeader('x-csrf-token', window._token);
                xhr.setRequestHeader('Accept', 'application/json');
                xhr.responseType = 'json';

                // Init listeners
                var genericErrorText = `Couldn't upload file: ${ file.name }.`;
                xhr.addEventListener('error', function() { reject(genericErrorText) });
                xhr.addEventListener('abort', function() { reject() });
                xhr.addEventListener('load', function() {
                  var response = xhr.response;

                  if (!response || xhr.status !== 201) {
                    return reject(response && response.message ? `${genericErrorText}\n${xhr.status} ${response.message}` : `${genericErrorText}\n ${xhr.status} ${xhr.statusText}`);
                  }

                  $('form').append('<input type="hidden" name="ck-media[]" value="' + response.id + '">');

                  resolve({ default: response.url });
                });

                if (xhr.upload) {
                  xhr.upload.addEventListener('progress', function(e) {
                    if (e.lengthComputable) {
                      loader.uploadTotal = e.total;
                      loader.uploaded = e.loaded;
                    }
                  });
                }

                // Send request
                var data = new FormData();
                data.append('upload', file);
                data.append('crud_id', '{{ $amcEnquiry->id ?? 0 }}');
                xhr.send(data);
              });
            })
        }
      };
    }
  }

  var allEditors = document.querySelectorAll('.ckeditor');
  for (var i = 0; i < allEditors.length; ++i) {
    ClassicEditor.create(
      allEditors[i], {
        extraPlugins: [SimpleUploadAdapter]
      }
    );
  }
});
</script>

@endsection