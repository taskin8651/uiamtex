<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreContactEnquiryRequest;
use App\Http\Requests\UpdateContactEnquiryRequest;
use App\Http\Resources\Admin\ContactEnquiryResource;
use App\Models\ContactEnquiry;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ContactEnquiriesApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('contact_enquiry_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ContactEnquiryResource(ContactEnquiry::all());
    }

    public function store(StoreContactEnquiryRequest $request)
    {
        $contactEnquiry = ContactEnquiry::create($request->all());

        return (new ContactEnquiryResource($contactEnquiry))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(ContactEnquiry $contactEnquiry)
    {
        abort_if(Gate::denies('contact_enquiry_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ContactEnquiryResource($contactEnquiry);
    }

    public function update(UpdateContactEnquiryRequest $request, ContactEnquiry $contactEnquiry)
    {
        $contactEnquiry->update($request->all());

        return (new ContactEnquiryResource($contactEnquiry))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(ContactEnquiry $contactEnquiry)
    {
        abort_if(Gate::denies('contact_enquiry_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $contactEnquiry->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
