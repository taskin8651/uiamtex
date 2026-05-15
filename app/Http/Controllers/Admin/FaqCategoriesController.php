<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyFaqCategoryRequest;
use App\Http\Requests\StoreFaqCategoryRequest;
use App\Http\Requests\UpdateFaqCategoryRequest;
use App\Models\FaqCategory;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class FaqCategoriesController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('faq_category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $q         = trim($request->get('q', ''));
        $status    = $request->get('status', ''); // '', 'active', 'inactive'
        $sort      = $request->get('sort', 'sort_order_asc'); // sort_order_asc, sort_order_desc, newest, oldest, name_asc, name_desc
        $perPage   = (int) $request->get('per_page', 12);
        $perPage   = in_array($perPage, [12, 24, 48]) ? $perPage : 12;

        $query = FaqCategory::query();

        // Search
        if ($q !== '') {
            $query->where('name', 'like', '%' . $q . '%');
        }

        // Status filter (depends on your stored value of is_active)
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
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            case 'sort_order_asc':
            default:
                $query->orderBy('sort_order', 'asc')->orderBy('id', 'desc');
                break;
        }

        $faqCategories = $query->paginate($perPage)->appends($request->query());

        return view('admin.faqCategories.index', compact('faqCategories', 'q', 'status', 'sort', 'perPage'));
    }

    public function create()
    {
        abort_if(Gate::denies('faq_category_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.faqCategories.create');
    }

    public function store(StoreFaqCategoryRequest $request)
    {
        $faqCategory = FaqCategory::create($request->all());

        return redirect()->route('admin.faq-categories.index');
    }

    public function edit(FaqCategory $faqCategory)
    {
        abort_if(Gate::denies('faq_category_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.faqCategories.edit', compact('faqCategory'));
    }

    public function update(UpdateFaqCategoryRequest $request, FaqCategory $faqCategory)
    {
        $faqCategory->update($request->all());

        return redirect()->route('admin.faq-categories.index');
    }

    public function show(FaqCategory $faqCategory)
    {
        abort_if(Gate::denies('faq_category_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.faqCategories.show', compact('faqCategory'));
    }

    public function destroy(FaqCategory $faqCategory)
    {
        abort_if(Gate::denies('faq_category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $faqCategory->delete();

        return back();
    }

    public function massDestroy(MassDestroyFaqCategoryRequest $request)
    {
        $faqCategories = FaqCategory::find(request('ids'));

        foreach ($faqCategories as $faqCategory) {
            $faqCategory->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
