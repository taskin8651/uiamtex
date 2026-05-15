<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpgradeRequestRequest;
use App\Http\Requests\UpdateUpgradeRequestRequest;
use App\Http\Resources\Admin\UpgradeRequestResource;
use App\Models\UpgradeRequest;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UpgradeRequestsApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('upgrade_request_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new UpgradeRequestResource(UpgradeRequest::all());
    }

    public function store(StoreUpgradeRequestRequest $request)
    {
        $upgradeRequest = UpgradeRequest::create($request->all());

        return (new UpgradeRequestResource($upgradeRequest))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(UpgradeRequest $upgradeRequest)
    {
        abort_if(Gate::denies('upgrade_request_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new UpgradeRequestResource($upgradeRequest);
    }

    public function update(UpdateUpgradeRequestRequest $request, UpgradeRequest $upgradeRequest)
    {
        $upgradeRequest->update($request->all());

        return (new UpgradeRequestResource($upgradeRequest))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(UpgradeRequest $upgradeRequest)
    {
        abort_if(Gate::denies('upgrade_request_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $upgradeRequest->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
