<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyEndUserRequest;
use App\Http\Requests\StoreEndUserRequest;
use App\Http\Requests\UpdateEndUserRequest;
use App\Models\EndUser;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class EndUsersController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('end_user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = EndUser::query()->select(sprintf('%s.*', (new EndUser)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'end_user_show';
                $editGate      = 'end_user_edit';
                $deleteGate    = 'end_user_delete';
                $crudRoutePart = 'end-users';

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
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : '';
            });
            $table->editColumn('phone', function ($row) {
                return $row->phone ? $row->phone : '';
            });
            $table->editColumn('email', function ($row) {
                return $row->email ? $row->email : '';
            });
            $table->editColumn('status', function ($row) {
                return $row->status ? EndUser::STATUS_SELECT[$row->status] : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.endUsers.index');
    }

    public function create()
    {
        abort_if(Gate::denies('end_user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.endUsers.create');
    }

    public function store(StoreEndUserRequest $request)
    {
        $endUser = EndUser::create($request->all());

        return redirect()->route('admin.end-users.index');
    }

    public function edit(EndUser $endUser)
    {
        abort_if(Gate::denies('end_user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.endUsers.edit', compact('endUser'));
    }

    public function update(UpdateEndUserRequest $request, EndUser $endUser)
    {
        $endUser->update($request->all());

        return redirect()->route('admin.end-users.index');
    }

    public function show(EndUser $endUser)
    {
        abort_if(Gate::denies('end_user_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.endUsers.show', compact('endUser'));
    }

    public function destroy(EndUser $endUser)
    {
        abort_if(Gate::denies('end_user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $endUser->delete();

        return back();
    }

    public function massDestroy(MassDestroyEndUserRequest $request)
    {
        $endUsers = EndUser::find(request('ids'));

        foreach ($endUsers as $endUser) {
            $endUser->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
