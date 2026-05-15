@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.contactEnquiry.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.contact-enquiries.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="enquiry_type">{{ trans('cruds.contactEnquiry.fields.enquiry_type') }}</label>
                <input class="form-control {{ $errors->has('enquiry_type') ? 'is-invalid' : '' }}" type="text" name="enquiry_type" id="enquiry_type" value="{{ old('enquiry_type', '') }}" required>
                @if($errors->has('enquiry_type'))
                    <div class="invalid-feedback">
                        {{ $errors->first('enquiry_type') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.contactEnquiry.fields.enquiry_type_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.contactEnquiry.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}" required>
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.contactEnquiry.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="phone">{{ trans('cruds.contactEnquiry.fields.phone') }}</label>
                <input class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" type="text" name="phone" id="phone" value="{{ old('phone', '') }}" required>
                @if($errors->has('phone'))
                    <div class="invalid-feedback">
                        {{ $errors->first('phone') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.contactEnquiry.fields.phone_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="email">{{ trans('cruds.contactEnquiry.fields.email') }}</label>
                <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="email" name="email" id="email" value="{{ old('email') }}" required>
                @if($errors->has('email'))
                    <div class="invalid-feedback">
                        {{ $errors->first('email') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.contactEnquiry.fields.email_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="message">{{ trans('cruds.contactEnquiry.fields.message') }}</label>
                <textarea class="form-control {{ $errors->has('message') ? 'is-invalid' : '' }}" name="message" id="message" required>{{ old('message') }}</textarea>
                @if($errors->has('message'))
                    <div class="invalid-feedback">
                        {{ $errors->first('message') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.contactEnquiry.fields.message_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.contactEnquiry.fields.status') }}</label>
                <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="status">
                    <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\ContactEnquiry::STATUS_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('status', 'new') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('status'))
                    <div class="invalid-feedback">
                        {{ $errors->first('status') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.contactEnquiry.fields.status_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="admin_notes">{{ trans('cruds.contactEnquiry.fields.admin_notes') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('admin_notes') ? 'is-invalid' : '' }}" name="admin_notes" id="admin_notes">{!! old('admin_notes') !!}</textarea>
                @if($errors->has('admin_notes'))
                    <div class="invalid-feedback">
                        {{ $errors->first('admin_notes') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.contactEnquiry.fields.admin_notes_helper') }}</span>
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
                xhr.open('POST', '{{ route('admin.contact-enquiries.storeCKEditorImages') }}', true);
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
                data.append('crud_id', '{{ $contactEnquiry->id ?? 0 }}');
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