<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyDownloadRequest;
use App\Http\Requests\StoreDownloadRequest;
use App\Http\Requests\UpdateDownloadRequest;
use App\Models\Download;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class DownloadsController extends Controller
{
    use MediaUploadingTrait, CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('download_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // Filters
        $filters = [
            'q'      => $request->get('q', ''),
            'status' => $request->get('status', ''),
            'sort'   => $request->get('sort', 'id'),
            'dir'    => $request->get('dir', 'desc'),
        ];

        $allowedSorts = ['id', 'title', 'is_active', 'updated_at', 'created_at'];
        $sort = in_array($filters['sort'], $allowedSorts, true) ? $filters['sort'] : 'id';

        $dir = strtolower($filters['dir']) === 'asc' ? 'asc' : 'desc';

        $query = Download::query();

        if (!empty($filters['q'])) {
            $q = trim($filters['q']);
            $query->where(function ($sub) use ($q) {
                $sub->where('title', 'like', "%{$q}%")
                    ->orWhere('id', $q);
            });
        }

        if ($filters['status'] !== '' && $filters['status'] !== null) {
            $query->where('is_active', $filters['status']);
        }

        $downloads = $query
            ->orderBy($sort, $dir)
            ->paginate(12)
            ->appends($request->query());

        return view('admin.downloads.index', [
            'downloads' => $downloads,
            'filters' => $filters,
            'isActiveOptions' => Download::IS_ACTIVE_SELECT,
        ]);
    }


    public function create()
    {
        abort_if(Gate::denies('download_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.downloads.create');
    }

    public function store(StoreDownloadRequest $request)
    {
        $download = Download::create($request->all());

        if ($request->input('file', false)) {
            $download->addMedia(storage_path('tmp/uploads/' . basename($request->input('file'))))->toMediaCollection('file');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $download->id]);
        }

        return redirect()->route('admin.downloads.index');
    }

    public function edit(Download $download)
    {
        abort_if(Gate::denies('download_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.downloads.edit', compact('download'));
    }

    public function update(UpdateDownloadRequest $request, Download $download)
    {
        $download->update($request->all());

        if ($request->input('file', false)) {
            if (! $download->file || $request->input('file') !== $download->file->file_name) {
                if ($download->file) {
                    $download->file->delete();
                }
                $download->addMedia(storage_path('tmp/uploads/' . basename($request->input('file'))))->toMediaCollection('file');
            }
        } elseif ($download->file) {
            $download->file->delete();
        }

        return redirect()->route('admin.downloads.index');
    }

    public function show(Download $download)
    {
        abort_if(Gate::denies('download_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.downloads.show', compact('download'));
    }

    public function destroy(Download $download)
    {
        abort_if(Gate::denies('download_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $download->delete();

        return back();
    }

    public function massDestroy(MassDestroyDownloadRequest $request)
    {
        $downloads = Download::find(request('ids'));

        foreach ($downloads as $download) {
            $download->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('download_create') && Gate::denies('download_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Download();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
