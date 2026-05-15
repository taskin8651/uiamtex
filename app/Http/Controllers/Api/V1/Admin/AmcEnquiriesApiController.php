<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreAmcEnquiryRequest;
use App\Http\Requests\UpdateAmcEnquiryRequest;
use App\Http\Resources\Admin\AmcEnquiryResource;
use App\Models\AmcEnquiry;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AmcEnquiriesApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('amc_enquiry_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new AmcEnquiryResource(AmcEnquiry::all());
    }

    public function store(StoreAmcEnquiryRequest $request)
    {
        $amcEnquiry = AmcEnquiry::create($request->all());

        return (new AmcEnquiryResource($amcEnquiry))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(AmcEnquiry $amcEnquiry)
    {
        abort_if(Gate::denies('amc_enquiry_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new AmcEnquiryResource($amcEnquiry);
    }

    public function update(UpdateAmcEnquiryRequest $request, AmcEnquiry $amcEnquiry)
    {
        $amcEnquiry->update($request->all());

        return (new AmcEnquiryResource($amcEnquiry))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(AmcEnquiry $amcEnquiry)
    {
        abort_if(Gate::denies('amc_enquiry_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $amcEnquiry->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
