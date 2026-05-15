<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyPageRequest;
use App\Http\Requests\StorePageRequest;
use App\Http\Requests\UpdatePageRequest;
use App\Models\Page;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class PagesController extends Controller
{
    use MediaUploadingTrait, CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('page_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $query = Page::query();

        // Search (title, slug, seo_title)
        if ($request->filled('q')) {
            $q = trim($request->q);
            $query->where(function ($sub) use ($q) {
                $sub->where('title', 'like', "%{$q}%")
                    ->orWhere('slug', 'like', "%{$q}%")
                    ->orWhere('seo_title', 'like', "%{$q}%");
            });
        }

        // Status filter (expects exact stored key of is_active)
        if ($request->filled('status')) {
            $query->where('is_active', $request->status);
        }

        // NEW: Placement filters
        // navbar=1 or 0
        if ($request->filled('navbar')) {
            $query->where('show_in_navbar', (int) $request->navbar);
        }

        // footer=1 or 0
        if ($request->filled('footer')) {
            $query->where('show_in_footer', (int) $request->footer);
        }

        // footer_bottom=1 or 0
        if ($request->filled('footer_bottom')) {
            $query->where('show_in_footer_bottom', (int) $request->footer_bottom);
        }

        // Sorting
        $sort = $request->get('sort', 'id');
        $dir  = $request->get('dir', 'desc');

        $allowedSorts = [
            'id',
            'title',
            'slug',
            'seo_title',
            'is_active',
            'show_in_navbar',
            'show_in_footer',
            'show_in_footer_bottom',
            'created_at',
            'updated_at',
        ];

        if (!in_array($sort, $allowedSorts, true)) {
            $sort = 'id';
        }

        $dir = $dir === 'asc' ? 'asc' : 'desc';

        $pages = $query->orderBy($sort, $dir)->paginate(12)->appends($request->query());

        return view('admin.pages.index', [
            'pages' => $pages,
            'isActiveOptions' => Page::IS_ACTIVE_SELECT,
            'yesNoOptions' => defined(Page::class.'::YES_NO_SELECT') ? Page::YES_NO_SELECT : ['0' => 'NO', '1' => 'YES'],
            'filters' => [
                'q' => $request->q,
                'status' => $request->status,
                'navbar' => $request->navbar,
                'footer' => $request->footer,
                'footer_bottom' => $request->footer_bottom,
                'sort' => $sort,
                'dir' => $dir,
            ],
        ]);
    }

    public function create()
    {
        abort_if(Gate::denies('page_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.pages.create');
    }

    public function store(StorePageRequest $request)
    {
        // Ensure toggles are stored as 0/1 even if checkboxes are unchecked (missing from request)
        $data = $request->all();
        $data['show_in_navbar'] = (int) $request->boolean('show_in_navbar');
        $data['show_in_footer'] = (int) $request->boolean('show_in_footer');
        $data['show_in_footer_bottom'] = (int) $request->boolean('show_in_footer_bottom');

        $page = Page::create($data);

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $page->id]);
        }

        return redirect()->route('admin.pages.index');
    }

    public function edit(Page $page)
    {
        abort_if(Gate::denies('page_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.pages.edit', compact('page'));
    }

    public function update(UpdatePageRequest $request, Page $page)
    {
        // Ensure toggles are stored as 0/1 even if checkboxes are unchecked (missing from request)
        $data = $request->all();
        $data['show_in_navbar'] = (int) $request->boolean('show_in_navbar');
        $data['show_in_footer'] = (int) $request->boolean('show_in_footer');
        $data['show_in_footer_bottom'] = (int) $request->boolean('show_in_footer_bottom');

        $page->update($data);

        return redirect()->route('admin.pages.index');
    }

    public function show(Page $page)
    {
        abort_if(Gate::denies('page_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.pages.show', compact('page'));
    }

    public function destroy(Page $page)
    {
        abort_if(Gate::denies('page_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $page->delete();

        return back();
    }

    public function massDestroy(MassDestroyPageRequest $request)
    {
        $pages = Page::find(request('ids'));

        foreach ($pages as $page) {
            $page->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('page_create') && Gate::denies('page_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Page();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;

        $media = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
