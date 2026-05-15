<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyUpgradeRequestRequest;
use App\Http\Requests\StoreUpgradeRequestRequest;
use App\Http\Requests\UpdateUpgradeRequestRequest;
use App\Models\UpgradeRequest;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class UpgradeRequestsController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('upgrade_request_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = UpgradeRequest::query()->select(sprintf('%s.*', (new UpgradeRequest)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'upgrade_request_show';
                $editGate      = 'upgrade_request_edit';
                $deleteGate    = 'upgrade_request_delete';
                $crudRoutePart = 'upgrade-requests';

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
            $table->editColumn('user', function ($row) {
                return $row->user ? $row->user : '';
            });
            $table->editColumn('current_extinguisher_type', function ($row) {
                return $row->current_extinguisher_type ? $row->current_extinguisher_type : '';
            });
            $table->editColumn('qty', function ($row) {
                return $row->qty ? $row->qty : '';
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
            $table->editColumn('message', function ($row) {
                return $row->message ? $row->message : '';
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

        return view('admin.upgradeRequests.index');
    }

    public function create()
    {
        abort_if(Gate::denies('upgrade_request_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.upgradeRequests.create');
    }

    public function store(StoreUpgradeRequestRequest $request)
    {
        $upgradeRequest = UpgradeRequest::create($request->all());

        return redirect()->route('admin.upgrade-requests.index');
    }

    public function edit(UpgradeRequest $upgradeRequest)
    {
        abort_if(Gate::denies('upgrade_request_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.upgradeRequests.edit', compact('upgradeRequest'));
    }

    public function update(UpdateUpgradeRequestRequest $request, UpgradeRequest $upgradeRequest)
    {
        $upgradeRequest->update($request->all());

        return redirect()->route('admin.upgrade-requests.index');
    }

    public function show(UpgradeRequest $upgradeRequest)
    {
        abort_if(Gate::denies('upgrade_request_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.upgradeRequests.show', compact('upgradeRequest'));
    }

    public function destroy(UpgradeRequest $upgradeRequest)
    {
        abort_if(Gate::denies('upgrade_request_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $upgradeRequest->delete();

        return back();
    }

    public function massDestroy(MassDestroyUpgradeRequestRequest $request)
    {
        $upgradeRequests = UpgradeRequest::find(request('ids'));

        foreach ($upgradeRequests as $upgradeRequest) {
            $upgradeRequest->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
