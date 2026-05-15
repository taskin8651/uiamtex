<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreDealershipApplicationRequest;
use App\Http\Requests\UpdateDealershipApplicationRequest;
use App\Http\Resources\Admin\DealershipApplicationResource;
use App\Models\DealershipApplication;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DealershipApplicationsApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('dealership_application_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new DealershipApplicationResource(DealershipApplication::all());
    }

    public function store(StoreDealershipApplicationRequest $request)
    {
        $dealershipApplication = DealershipApplication::create($request->all());

        if ($request->input('upload_compay_profile', false)) {
            $dealershipApplication->addMedia(storage_path('tmp/uploads/' . basename($request->input('upload_compay_profile'))))->toMediaCollection('upload_compay_profile');
        }

        if ($request->input('upload_gst', false)) {
            $dealershipApplication->addMedia(storage_path('tmp/uploads/' . basename($request->input('upload_gst'))))->toMediaCollection('upload_gst');
        }

        return (new DealershipApplicationResource($dealershipApplication))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(DealershipApplication $dealershipApplication)
    {
        abort_if(Gate::denies('dealership_application_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new DealershipApplicationResource($dealershipApplication);
    }

    public function update(UpdateDealershipApplicationRequest $request, DealershipApplication $dealershipApplication)
    {
        $dealershipApplication->update($request->all());

        if ($request->input('upload_compay_profile', false)) {
            if (! $dealershipApplication->upload_compay_profile || $request->input('upload_compay_profile') !== $dealershipApplication->upload_compay_profile->file_name) {
                if ($dealershipApplication->upload_compay_profile) {
                    $dealershipApplication->upload_compay_profile->delete();
                }
                $dealershipApplication->addMedia(storage_path('tmp/uploads/' . basename($request->input('upload_compay_profile'))))->toMediaCollection('upload_compay_profile');
            }
        } elseif ($dealershipApplication->upload_compay_profile) {
            $dealershipApplication->upload_compay_profile->delete();
        }

        if ($request->input('upload_gst', false)) {
            if (! $dealershipApplication->upload_gst || $request->input('upload_gst') !== $dealershipApplication->upload_gst->file_name) {
                if ($dealershipApplication->upload_gst) {
                    $dealershipApplication->upload_gst->delete();
                }
                $dealershipApplication->addMedia(storage_path('tmp/uploads/' . basename($request->input('upload_gst'))))->toMediaCollection('upload_gst');
            }
        } elseif ($dealershipApplication->upload_gst) {
            $dealershipApplication->upload_gst->delete();
        }

        return (new DealershipApplicationResource($dealershipApplication))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(DealershipApplication $dealershipApplication)
    {
        abort_if(Gate::denies('dealership_application_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $dealershipApplication->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
