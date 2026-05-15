@extends('layouts.admin')
@section('content')

<div class="amtex-faq-form">

    <div class="af-header">
        <div>
            <h3 class="af-title">{{ trans('global.create') }} {{ trans('cruds.faq.title_singular') }}</h3>
            <p class="af-subtitle">Create a new FAQ entry and assign it to a category.</p>
        </div>

        <a href="{{ route('admin.faqs.index') }}" class="btn btn-outline-secondary">
            ← Back to list
        </a>
    </div>

    <form method="POST" action="{{ route('admin.faqs.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="row">
            <!-- Left: Main content -->
            <div class="col-lg-8 mb-3">
                <div class="card af-card">
                    <div class="card-header">
                        <div>
                            <div class="af-section-title">FAQ Content</div>
                            <div class="af-section-hint">Category, question and answer.</div>
                        </div>
                    </div>

                    <div class="card-body">
                        <!-- Category -->
                        <div class="form-group af-field">
                            <label class="required af-label" for="select_category_id">{{ trans('cruds.faq.fields.select_category') }}</label>
                            <select
                                class="form-control select2 {{ $errors->has('select_category') ? 'is-invalid' : '' }}"
                                name="select_category_id"
                                id="select_category_id"
                                required
                            >
                                @foreach($select_categories as $id => $entry)
                                    <option value="{{ $id }}" {{ old('select_category_id') == $id ? 'selected' : '' }}>
                                        {{ $entry }}
                                    </option>
                                @endforeach
                            </select>

                            @if($errors->has('select_category'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('select_category') }}
                                </div>
                            @endif

                            <div class="af-help">{{ trans('cruds.faq.fields.select_category_helper') }}</div>
                        </div>

                        <!-- Question -->
                        <div class="form-group af-field">
                            <label class="required af-label" for="question">{{ trans('cruds.faq.fields.question') }}</label>
                            <textarea
                                class="form-control {{ $errors->has('question') ? 'is-invalid' : '' }}"
                                name="question"
                                id="question"
                                rows="4"
                                placeholder="Type the question here..."
                                required
                            >{{ old('question') }}</textarea>

                            @if($errors->has('question'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('question') }}
                                </div>
                            @endif

                            <div class="af-help">{{ trans('cruds.faq.fields.question_helper') }}</div>
                        </div>

                        <!-- Answer -->
                        <div class="form-group af-field">
                            <label class="af-label" for="answer">{{ trans('cruds.faq.fields.answer') }}</label>
                            <textarea
                                class="form-control ckeditor {{ $errors->has('answer') ? 'is-invalid' : '' }}"
                                name="answer"
                                id="answer"
                            >{!! old('answer') !!}</textarea>

                            @if($errors->has('answer'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('answer') }}
                                </div>
                            @endif

                            <div class="af-help">{{ trans('cruds.faq.fields.answer_helper') }}</div>
                        </div>

                        <div class="af-note">
                            <strong>Tip</strong>
                            Keep the question short and clear. Use the answer section for detailed steps, bullets, and links.
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Publishing -->
            <div class="col-lg-4 mb-3">
                <div class="card af-card">
                    <div class="card-header">
                        <div class="af-section-title">Publishing</div>
                        <div class="af-section-hint">Visibility and ordering.</div>
                    </div>

                    <div class="card-body">
                        <!-- Sort order -->
                        <div class="form-group af-field">
                            <label class="required af-label" for="sort_order">{{ trans('cruds.faq.fields.sort_order') }}</label>
                            <input
                                class="form-control {{ $errors->has('sort_order') ? 'is-invalid' : '' }}"
                                type="number"
                                name="sort_order"
                                id="sort_order"
                                value="{{ old('sort_order', '') }}"
                                placeholder="e.g. 1"
                                required
                            >

                            @if($errors->has('sort_order'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('sort_order') }}
                                </div>
                            @endif

                            <div class="af-help">{{ trans('cruds.faq.fields.sort_order_helper') }}</div>
                        </div>

                        <!-- Status -->
                        <div class="form-group af-field">
                            <label class="af-label" for="is_active">{{ trans('cruds.faq.fields.is_active') }}</label>
                            <select class="form-control {{ $errors->has('is_active') ? 'is-invalid' : '' }}" name="is_active" id="is_active">
                                <option value disabled {{ old('is_active', null) === null ? 'selected' : '' }}>
                                    {{ trans('global.pleaseSelect') }}
                                </option>
                                @foreach(App\Models\Faq::IS_ACTIVE_SELECT as $key => $label)
                                    <option value="{{ $key }}" {{ old('is_active', 'yes') === (string) $key ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>

                            @if($errors->has('is_active'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('is_active') }}
                                </div>
                            @endif

                            <div class="af-help">{{ trans('cruds.faq.fields.is_active_helper') }}</div>
                        </div>

                        <div class="af-actions">
                            <a href="{{ route('admin.faqs.index') }}" class="btn btn-light">
                                Cancel
                            </a>

                            <button class="btn btn-danger" type="submit">
                                {{ trans('global.save') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </form>

</div>
@endsection

@section('scripts')
@parent
<script>
$(document).ready(function () {
  function SimpleUploadAdapter(editor) {
    editor.plugins.get('FileRepository').createUploadAdapter = function(loader) {
      return {
        upload: function() {
          return loader.file
            .then(function (file) {
              return new Promise(function(resolve, reject) {
                var xhr = new XMLHttpRequest();
                xhr.open('POST', '{{ route('admin.faqs.storeCKEditorImages') }}', true);
                xhr.setRequestHeader('x-csrf-token', window._token);
                xhr.setRequestHeader('Accept', 'application/json');
                xhr.responseType = 'json';

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

                var data = new FormData();
                data.append('upload', file);

                // For create page it should be 0
                data.append('crud_id', 0);

                xhr.send(data);
              });
            })
        }
      };
    }
  }

  var allEditors = document.querySelectorAll('.ckeditor');
  for (var i = 0; i < allEditors.length; ++i) {
    ClassicEditor.create(allEditors[i], {
      extraPlugins: [SimpleUploadAdapter]
    });
  }
});
</script>
@endsection
