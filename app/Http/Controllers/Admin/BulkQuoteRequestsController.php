<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyBulkQuoteRequestRequest;
use App\Http\Requests\StoreBulkQuoteRequestRequest;
use App\Http\Requests\UpdateBulkQuoteRequestRequest;
use App\Models\BulkQuoteRequest;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class BulkQuoteRequestsController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('bulk_quote_request_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = BulkQuoteRequest::query()->select(sprintf('%s.*', (new BulkQuoteRequest)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'bulk_quote_request_show';
                $editGate      = 'bulk_quote_request_edit';
                $deleteGate    = 'bulk_quote_request_delete';
                $crudRoutePart = 'bulk-quote-requests';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->editColumn('product', function ($row) {
                return $row->product ? $row->product : '';
            });
            $table->editColumn('variant', function ($row) {
                return $row->variant ? $row->variant : '';
            });
            $table->editColumn('qty', function ($row) {
                return $row->qty ? $row->qty : '';
            });
            $table->editColumn('company_name', function ($row) {
                return $row->company_name ? $row->company_name : '';
            });
            $table->editColumn('city', function ($row) {
                return $row->city ? $row->city : '';
            });
            $table->editColumn('phone', function ($row) {
                return $row->phone ? $row->phone : '';
            });
            $table->editColumn('email', function ($row) {
                return $row->email ? $row->email : '';
            });
            $table->editColumn('notes', function ($row) {
                return $row->notes ? $row->notes : '';
            });
            $table->editColumn('status', function ($row) {
                return $row->status ? $row->status : '';
            });
            $table->editColumn('admin_notes', function ($row) {
                return $row->admin_notes ? $row->admin_notes : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.bulkQuoteRequests.index');
    }

    public function create()
    {
        abort_if(Gate::denies('bulk_quote_request_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.bulkQuoteRequests.create');
    }

    public function store(StoreBulkQuoteRequestRequest $request)
    {
        $bulkQuoteRequest = BulkQuoteRequest::create($request->all());

        return redirect()->route('admin.bulk-quote-requests.index');
    }

    public function edit(BulkQuoteRequest $bulkQuoteRequest)
    {
        abort_if(Gate::denies('bulk_quote_request_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.bulkQuoteRequests.edit', compact('bulkQuoteRequest'));
    }

    public function update(UpdateBulkQuoteRequestRequest $request, BulkQuoteRequest $bulkQuoteRequest)
    {
        $bulkQuoteRequest->update($request->all());

        return redirect()->route('admin.bulk-quote-requests.index');
    }

    public function show(BulkQuoteRequest $bulkQuoteRequest)
    {
        abort_if(Gate::denies('bulk_quote_request_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.bulkQuoteRequests.show', compact('bulkQuoteRequest'));
    }

    public function destroy(BulkQuoteRequest $bulkQuoteRequest)
    {
        abort_if(Gate::denies('bulk_quote_request_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $bulkQuoteRequest->delete();

        return back();
    }

    public function massDestroy(MassDestroyBulkQuoteRequestRequest $request)
    {
        $bulkQuoteRequests = BulkQuoteRequest::find(request('ids'));

        foreach ($bulkQuoteRequests as $bulkQuoteRequest) {
            $bulkQuoteRequest->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
