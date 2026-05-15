<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDownloadRequestRequest;
use App\Http\Requests\UpdateDownloadRequestRequest;
use App\Http\Resources\Admin\DownloadRequestResource;
use App\Models\DownloadRequest;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DownloadRequestsApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('download_request_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new DownloadRequestResource(DownloadRequest::all());
    }

    public function store(StoreDownloadRequestRequest $request)
    {
        $downloadRequest = DownloadRequest::create($request->all());

        return (new DownloadRequestResource($downloadRequest))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(DownloadRequest $downloadRequest)
    {
        abort_if(Gate::denies('download_request_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new DownloadRequestResource($downloadRequest);
    }

    public function update(UpdateDownloadRequestRequest $request, DownloadRequest $downloadRequest)
    {
        $downloadRequest->update($request->all());

        return (new DownloadRequestResource($downloadRequest))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(DownloadRequest $downloadRequest)
    {
        abort_if(Gate::denies('download_request_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $downloadRequest->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
