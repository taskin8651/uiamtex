@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.dealershipApplication.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.dealership-applications.update", [$dealershipApplication->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="full_name">{{ trans('cruds.dealershipApplication.fields.full_name') }}</label>
                <input class="form-control {{ $errors->has('full_name') ? 'is-invalid' : '' }}" type="text" name="full_name" id="full_name" value="{{ old('full_name', $dealershipApplication->full_name) }}">
                @if($errors->has('full_name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('full_name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.dealershipApplication.fields.full_name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="mobile">{{ trans('cruds.dealershipApplication.fields.mobile') }}</label>
                <input class="form-control {{ $errors->has('mobile') ? 'is-invalid' : '' }}" type="text" name="mobile" id="mobile" value="{{ old('mobile', $dealershipApplication->mobile) }}">
                @if($errors->has('mobile'))
                    <div class="invalid-feedback">
                        {{ $errors->first('mobile') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.dealershipApplication.fields.mobile_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="email">{{ trans('cruds.dealershipApplication.fields.email') }}</label>
                <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="email" name="email" id="email" value="{{ old('email', $dealershipApplication->email) }}">
                @if($errors->has('email'))
                    <div class="invalid-feedback">
                        {{ $errors->first('email') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.dealershipApplication.fields.email_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="city_state">{{ trans('cruds.dealershipApplication.fields.city_state') }}</label>
                <input class="form-control {{ $errors->has('city_state') ? 'is-invalid' : '' }}" type="text" name="city_state" id="city_state" value="{{ old('city_state', $dealershipApplication->city_state) }}">
                @if($errors->has('city_state'))
                    <div class="invalid-feedback">
                        {{ $errors->first('city_state') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.dealershipApplication.fields.city_state_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="business_type">{{ trans('cruds.dealershipApplication.fields.business_type') }}</label>
                <input class="form-control {{ $errors->has('business_type') ? 'is-invalid' : '' }}" type="text" name="business_type" id="business_type" value="{{ old('business_type', $dealershipApplication->business_type) }}">
                @if($errors->has('business_type'))
                    <div class="invalid-feedback">
                        {{ $errors->first('business_type') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.dealershipApplication.fields.business_type_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="sales_focus">{{ trans('cruds.dealershipApplication.fields.sales_focus') }}</label>
                <input class="form-control {{ $errors->has('sales_focus') ? 'is-invalid' : '' }}" type="text" name="sales_focus" id="sales_focus" value="{{ old('sales_focus', $dealershipApplication->sales_focus) }}">
                @if($errors->has('sales_focus'))
                    <div class="invalid-feedback">
                        {{ $errors->first('sales_focus') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.dealershipApplication.fields.sales_focus_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="experience">{{ trans('cruds.dealershipApplication.fields.experience') }}</label>
                <input class="form-control {{ $errors->has('experience') ? 'is-invalid' : '' }}" type="text" name="experience" id="experience" value="{{ old('experience', $dealershipApplication->experience) }}">
                @if($errors->has('experience'))
                    <div class="invalid-feedback">
                        {{ $errors->first('experience') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.dealershipApplication.fields.experience_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="upload_compay_profile">{{ trans('cruds.dealershipApplication.fields.upload_compay_profile') }}</label>
                <div class="needsclick dropzone {{ $errors->has('upload_compay_profile') ? 'is-invalid' : '' }}" id="upload_compay_profile-dropzone">
                </div>
                @if($errors->has('upload_compay_profile'))
                    <div class="invalid-feedback">
                        {{ $errors->first('upload_compay_profile') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.dealershipApplication.fields.upload_compay_profile_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="upload_gst">{{ trans('cruds.dealershipApplication.fields.upload_gst') }}</label>
                <div class="needsclick dropzone {{ $errors->has('upload_gst') ? 'is-invalid' : '' }}" id="upload_gst-dropzone">
                </div>
                @if($errors->has('upload_gst'))
                    <div class="invalid-feedback">
                        {{ $errors->first('upload_gst') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.dealershipApplication.fields.upload_gst_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="status">{{ trans('cruds.dealershipApplication.fields.status') }}</label>
                <input class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" type="text" name="status" id="status" value="{{ old('status', $dealershipApplication->status) }}">
                @if($errors->has('status'))
                    <div class="invalid-feedback">
                        {{ $errors->first('status') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.dealershipApplication.fields.status_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="admin_notes">{{ trans('cruds.dealershipApplication.fields.admin_notes') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('admin_notes') ? 'is-invalid' : '' }}" name="admin_notes" id="admin_notes">{!! old('admin_notes', $dealershipApplication->admin_notes) !!}</textarea>
                @if($errors->has('admin_notes'))
                    <div class="invalid-feedback">
                        {{ $errors->first('admin_notes') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.dealershipApplication.fields.admin_notes_helper') }}</span>
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
    Dropzone.options.uploadCompayProfileDropzone = {
    url: '{{ route('admin.dealership-applications.storeMedia') }}',
    maxFilesize: 100, // MB
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 100
    },
    success: function (file, response) {
      $('form').find('input[name="upload_compay_profile"]').remove()
      $('form').append('<input type="hidden" name="upload_compay_profile" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="upload_compay_profile"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($dealershipApplication) && $dealershipApplication->upload_compay_profile)
      var file = {!! json_encode($dealershipApplication->upload_compay_profile) !!}
          this.options.addedfile.call(this, file)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="upload_compay_profile" value="' + file.file_name + '">')
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
<script>
    Dropzone.options.uploadGstDropzone = {
    url: '{{ route('admin.dealership-applications.storeMedia') }}',
    maxFilesize: 100, // MB
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 100
    },
    success: function (file, response) {
      $('form').find('input[name="upload_gst"]').remove()
      $('form').append('<input type="hidden" name="upload_gst" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="upload_gst"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($dealershipApplication) && $dealershipApplication->upload_gst)
      var file = {!! json_encode($dealershipApplication->upload_gst) !!}
          this.options.addedfile.call(this, file)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="upload_gst" value="' + file.file_name + '">')
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
                xhr.open('POST', '{{ route('admin.dealership-applications.storeCKEditorImages') }}', true);
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
                data.append('crud_id', '{{ $dealershipApplication->id ?? 0 }}');
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