<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyFaqRequest;
use App\Http\Requests\StoreFaqRequest;
use App\Http\Requests\UpdateFaqRequest;
use App\Models\Faq;
use App\Models\FaqCategory;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class FaqsController extends Controller
{
    use MediaUploadingTrait, CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('faq_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $q        = trim($request->get('q', ''));
        $cat      = $request->get('category_id', ''); // faq_categories.id
        $status   = $request->get('status', ''); // '', 'active', 'inactive'
        $sort     = $request->get('sort', 'sort_order_asc'); // sort_order_asc, sort_order_desc, newest, oldest, question_asc, question_desc
        $perPage  = (int) $request->get('per_page', 12);
        $perPage  = in_array($perPage, [12, 24, 48]) ? $perPage : 12;

        $query = Faq::with(['select_category']);

        // Search in question (and optional answer if exists)
        if ($q !== '') {
            $query->where(function ($sub) use ($q) {
                $sub->where('question', 'like', '%' . $q . '%');

                // If your FAQs have "answer" column, uncomment:
                // $sub->orWhere('answer', 'like', '%' . $q . '%');
            });
        }

        // Category filter
        if ($cat !== '') {
            $query->where('select_category_id', $cat);
        }

        // Status filter (assumes 1/0 stored)
        if ($status === 'active') {
            $query->where('is_active', 1);
        } elseif ($status === 'inactive') {
            $query->where('is_active', 0);
        }

        // Sorting
        switch ($sort) {
            case 'sort_order_desc':
                $query->orderBy('sort_order', 'desc')->orderBy('id', 'desc');
                break;
            case 'newest':
                $query->orderBy('id', 'desc');
                break;
            case 'oldest':
                $query->orderBy('id', 'asc');
                break;
            case 'question_asc':
                $query->orderBy('question', 'asc');
                break;
            case 'question_desc':
                $query->orderBy('question', 'desc');
                break;
            case 'sort_order_asc':
            default:
                $query->orderBy('sort_order', 'asc')->orderBy('id', 'desc');
                break;
        }

        $faqs = $query->paginate($perPage)->appends($request->query());

        $categories = FaqCategory::orderBy('sort_order', 'asc')
            ->orderBy('id', 'desc')
            ->get(['id', 'name']);

        return view('admin.faqs.index', compact('faqs', 'categories', 'q', 'cat', 'status', 'sort', 'perPage'));
    }


    public function create()
    {
        abort_if(Gate::denies('faq_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $select_categories = FaqCategory::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.faqs.create', compact('select_categories'));
    }

    public function store(StoreFaqRequest $request)
    {
        $faq = Faq::create($request->all());

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $faq->id]);
        }

        return redirect()->route('admin.faqs.index');
    }

    public function edit(Faq $faq)
    {
        abort_if(Gate::denies('faq_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $select_categories = FaqCategory::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $faq->load('select_category');

        return view('admin.faqs.edit', compact('faq', 'select_categories'));
    }

    public function update(UpdateFaqRequest $request, Faq $faq)
    {
        $faq->update($request->all());

        return redirect()->route('admin.faqs.index');
    }

    public function show(Faq $faq)
    {
        abort_if(Gate::denies('faq_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $faq->load('select_category');

        return view('admin.faqs.show', compact('faq'));
    }

    public function destroy(Faq $faq)
    {
        abort_if(Gate::denies('faq_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $faq->delete();

        return back();
    }

    public function massDestroy(MassDestroyFaqRequest $request)
    {
        $ids = request('ids');

        if (is_string($ids)) {
            $decoded = json_decode($ids, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $ids = $decoded;
            }
        }

        $faqs = Faq::whereIn('id', (array) $ids)->get();

        foreach ($faqs as $faq) {
            $faq->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }


    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('faq_create') && Gate::denies('faq_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Faq();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
