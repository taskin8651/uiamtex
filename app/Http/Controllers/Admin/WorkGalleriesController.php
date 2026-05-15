<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreWorkGalleryRequest;
use App\Http\Requests\UpdateWorkGalleryRequest;
use App\Http\Requests\MassDestroyWorkGalleryRequest;
use App\Models\WorkGallery;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class WorkGalleriesController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('work_gallery_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $workGalleries = WorkGallery::orderBy('sort_order', 'asc')
            ->orderBy('id', 'desc')
            ->paginate(12);

        return view('admin.workGalleries.index', compact('workGalleries'));
    }

    public function create()
    {
        abort_if(Gate::denies('work_gallery_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.workGalleries.create');
    }

    public function store(StoreWorkGalleryRequest $request)
    {
        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $this->uploadImage($request->file('image'));
        }

        WorkGallery::create([
            'title'      => $request->title,
            'image'      => $imagePath,
            'sort_order' => $request->sort_order ?? 0,
            'is_active'  => $request->is_active,
        ]);

        return redirect()->route('admin.work-galleries.index')->with('message', 'Work Gallery created successfully.');
    }

    public function show(WorkGallery $workGallery)
    {
        abort_if(Gate::denies('work_gallery_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.workGalleries.show', compact('workGallery'));
    }

    public function edit(WorkGallery $workGallery)
    {
        abort_if(Gate::denies('work_gallery_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.workGalleries.edit', compact('workGallery'));
    }

    public function update(UpdateWorkGalleryRequest $request, WorkGallery $workGallery)
    {
        $data = [
            'title'      => $request->title,
            'sort_order' => $request->sort_order ?? 0,
            'is_active'  => $request->is_active,
        ];

        if ($request->hasFile('image')) {
            if ($workGallery->image && file_exists(public_path($workGallery->image))) {
                @unlink(public_path($workGallery->image));
            }

            $data['image'] = $this->uploadImage($request->file('image'));
        }

        $workGallery->update($data);

        return redirect()->route('admin.work-galleries.index')->with('message', 'Work Gallery updated successfully.');
    }

    public function destroy(WorkGallery $workGallery)
    {
        abort_if(Gate::denies('work_gallery_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($workGallery->image && file_exists(public_path($workGallery->image))) {
            @unlink(public_path($workGallery->image));
        }

        $workGallery->delete();

        return back()->with('message', 'Work Gallery deleted successfully.');
    }

    public function massDestroy(MassDestroyWorkGalleryRequest $request)
    {
        $items = WorkGallery::whereIn('id', $request->ids)->get();

        foreach ($items as $item) {
            if ($item->image && file_exists(public_path($item->image))) {
                @unlink(public_path($item->image));
            }
            $item->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    private function uploadImage($file): string
    {
        $uploadDir = public_path('uploads/work-gallery');

        if (!is_dir($uploadDir)) {
            @mkdir($uploadDir, 0777, true);
        }

        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move($uploadDir, $filename);

        return 'uploads/work-gallery/' . $filename;
    }
}