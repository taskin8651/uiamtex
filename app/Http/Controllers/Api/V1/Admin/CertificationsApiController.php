<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreCertificationRequest;
use App\Http\Requests\UpdateCertificationRequest;
use App\Http\Resources\Admin\CertificationResource;
use App\Models\Certification;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CertificationsApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('certification_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CertificationResource(Certification::all());
    }

    public function store(StoreCertificationRequest $request)
    {
        $certification = Certification::create($request->all());

        if ($request->input('image', false)) {
            $certification->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
        }

        return (new CertificationResource($certification))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Certification $certification)
    {
        abort_if(Gate::denies('certification_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CertificationResource($certification);
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

        return (new CertificationResource($certification))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Certification $certification)
    {
        abort_if(Gate::denies('certification_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $certification->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
