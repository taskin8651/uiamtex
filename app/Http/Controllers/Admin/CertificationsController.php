<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyCertificationRequest;
use App\Http\Requests\StoreCertificationRequest;
use App\Http\Requests\UpdateCertificationRequest;
use App\Models\Certification;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class CertificationsController extends Controller
{
    use MediaUploadingTrait, CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('certification_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $query = Certification::query();

        // Search
        if ($request->filled('q')) {
            $q = trim($request->q);
            $query->where(function ($sub) use ($q) {
                $sub->where('title', 'like', "%{$q}%")
                    ->orWhere('id', $q);
            });
        }

        // Status filter (expects stored key)
        if ($request->filled('status')) {
            $query->where('is_active', $request->status);
        }

        // Sorting
        $sort = $request->get('sort', 'sort_order');
        $dir  = $request->get('dir', 'asc');

        $allowedSorts = ['id', 'title', 'sort_order', 'is_active', 'created_at', 'updated_at'];
        if (!in_array($sort, $allowedSorts, true)) {
            $sort = 'sort_order';
        }
        $dir = $dir === 'desc' ? 'desc' : 'asc';

        $certifications = $query
            ->orderBy($sort, $dir)
            ->orderBy('id', 'desc')
            ->paginate(12)
            ->appends($request->query());

        return view('admin.certifications.index', [
            'certifications' => $certifications,
            'isActiveOptions' => Certification::IS_ACTIVE_SELECT,
            'filters' => [
                'q' => $request->q,
                'status' => $request->status,
                'sort' => $sort,
                'dir' => $dir,
            ],
        ]);
    }

    public function create()
    {
        abort_if(Gate::denies('certification_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.certifications.create');
    }

    public function store(StoreCertificationRequest $request)
    {
        $certification = Certification::create($request->all());

        if ($request->input('image', false)) {
            $certification->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $certification->id]);
        }

        return redirect()->route('admin.certifications.index');
    }

    public function edit(Certification $certification)
    {
        abort_if(Gate::denies('certification_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.certifications.edit', compact('certification'));
    }

    public function update(UpdateCertificationRequest $request, Certification $certification)
    {
        $certification->update($request->all());

        if ($request->input('image', false)) {
            if (! $certification->image || $request->input('image') !== $certification->image->file_name) {
                if ($certification->image) {
                    $certification->image->delete();
                }
                $certification->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
            }
        } elseif ($certification->image) {
            $certification->image->delete();
        }

        return redirect()->route('admin.certifications.index');
    }

    public function show(Certification $certification)
    {
        abort_if(Gate::denies('certification_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.certifications.show', compact('certification'));
    }

    public function destroy(Certification $certification)
    {
        abort_if(Gate::denies('certification_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $certification->delete();

        return back();
    }

    public function massDestroy(MassDestroyCertificationRequest $request)
    {
        $certifications = Certification::find(request('ids'));

        foreach ($certifications as $certification) {
            $certification->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('certification_create') && Gate::denies('certification_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Certification();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
