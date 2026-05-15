<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBulkQuoteRequestRequest;
use App\Http\Requests\UpdateBulkQuoteRequestRequest;
use App\Http\Resources\Admin\BulkQuoteRequestResource;
use App\Models\BulkQuoteRequest;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BulkQuoteRequestsApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('bulk_quote_request_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new BulkQuoteRequestResource(BulkQuoteRequest::all());
    }

    public function store(StoreBulkQuoteRequestRequest $request)
    {
        $bulkQuoteRequest = BulkQuoteRequest::create($request->all());

        return (new BulkQuoteRequestResource($bulkQuoteRequest))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(BulkQuoteRequest $bulkQuoteRequest)
    {
        abort_if(Gate::denies('bulk_quote_request_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new BulkQuoteRequestResource($bulkQuoteRequest);
    }

    public function update(UpdateBulkQuoteRequestRequest $request, BulkQuoteRequest $bulkQuoteRequest)
    {
        $bulkQuoteRequest->update($request->all());

        return (new BulkQuoteRequestResource($bulkQuoteRequest))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(BulkQuoteRequest $bulkQuoteRequest)
    {
        abort_if(Gate::denies('bulk_quote_request_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $bulkQuoteRequest->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
