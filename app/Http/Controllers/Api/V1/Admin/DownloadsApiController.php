<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreDownloadRequest;
use App\Http\Requests\UpdateDownloadRequest;
use App\Http\Resources\Admin\DownloadResource;
use App\Models\Download;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DownloadsApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('download_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new DownloadResource(Download::all());
    }

    public function store(StoreDownloadRequest $request)
    {
        $download = Download::create($request->all());

        if ($request->input('file', false)) {
            $download->addMedia(storage_path('tmp/uploads/' . basename($request->input('file'))))->toMediaCollection('file');
        }

        return (new DownloadResource($download))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Download $download)
    {
        abort_if(Gate::denies('download_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new DownloadResource($download);
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

        return (new DownloadResource($download))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Download $download)
    {
        abort_if(Gate::denies('download_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $download->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
