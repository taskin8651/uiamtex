<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyServiceProcessStepRequest;
use App\Http\Requests\StoreServiceProcessStepRequest;
use App\Http\Requests\UpdateServiceProcessStepRequest;
use App\Models\ServiceProcessStep;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ServiceProcessStepsController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('service_process_step_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $filters = [
            'q'      => $request->get('q'),
            'status' => $request->get('status'),
            'sort'   => $request->get('sort', 'sort_order'),
            'dir'    => $request->get('dir', 'asc'),
        ];

        $query = ServiceProcessStep::query();

        if (!empty($filters['q'])) {
            $q = trim($filters['q']);
            $query->where(function ($sub) use ($q) {
                $sub->where('title', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%")
                    ->orWhere('step_no', $q)
                    ->orWhere('id', $q);
            });
        }

        if (!empty($filters['status'])) {
            $query->where('is_active', $filters['status']);
        }

        $allowedSort = ['sort_order', 'id', 'step_no', 'title', 'is_active', 'updated_at'];
        $sort = in_array($filters['sort'], $allowedSort, true) ? $filters['sort'] : 'sort_order';
        $dir  = strtolower($filters['dir']) === 'desc' ? 'desc' : 'asc';

        $steps = $query
            ->orderBy($sort, $dir)
            ->orderBy('step_no', 'asc')
            ->paginate(9)
            ->appends($request->query());

        $isActiveOptions = ServiceProcessStep::IS_ACTIVE_SELECT;

        return view('admin.serviceProcessSteps.index', compact('steps', 'filters', 'isActiveOptions'));
    }

    public function create()
    {
        abort_if(Gate::denies('service_process_step_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $isActiveOptions = ServiceProcessStep::IS_ACTIVE_SELECT;

        return view('admin.serviceProcessSteps.create', compact('isActiveOptions'));
    }

    public function store(StoreServiceProcessStepRequest $request)
    {
        abort_if(Gate::denies('service_process_step_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        ServiceProcessStep::create($request->validated());

        return redirect()->route('admin.service-process-steps.index')
            ->with('message', 'Process step created successfully.');
    }

    public function edit(ServiceProcessStep $serviceProcessStep)
    {
        abort_if(Gate::denies('service_process_step_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $isActiveOptions = ServiceProcessStep::IS_ACTIVE_SELECT;

        return view('admin.serviceProcessSteps.edit', compact('serviceProcessStep', 'isActiveOptions'));
    }

    public function update(UpdateServiceProcessStepRequest $request, ServiceProcessStep $serviceProcessStep)
    {
        abort_if(Gate::denies('service_process_step_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $serviceProcessStep->update($request->validated());

        return redirect()->route('admin.service-process-steps.index')
            ->with('message', 'Process step updated successfully.');
    }

    public function show(ServiceProcessStep $serviceProcessStep)
    {
        abort_if(Gate::denies('service_process_step_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.serviceProcessSteps.show', compact('serviceProcessStep'));
    }

    public function destroy(ServiceProcessStep $serviceProcessStep)
    {
        abort_if(Gate::denies('service_process_step_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $serviceProcessStep->delete();

        return back()->with('message', 'Process step deleted successfully.');
    }

    public function massDestroy(MassDestroyServiceProcessStepRequest $request)
    {
        abort_if(Gate::denies('service_process_step_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        ServiceProcessStep::whereIn('id', $request->input('ids', []))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
