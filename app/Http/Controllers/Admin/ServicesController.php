<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyServiceRequest;
use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Models\Service;
use App\Models\ServiceFeature;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ServicesController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('service_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $filters = [
            'q'      => $request->get('q'),
            'status' => $request->get('status'),
            'sort'   => $request->get('sort', 'sort_order'),
            'dir'    => $request->get('dir', 'asc'),
        ];

        $query = Service::query();

        if (!empty($filters['q'])) {
            $q = trim($filters['q']);
            $query->where(function ($sub) use ($q) {
                $sub->where('title', 'like', "%{$q}%")
                    ->orWhere('category', 'like', "%{$q}%")
                    ->orWhere('short_description', 'like', "%{$q}%")
                    ->orWhere('id', $q);
            });
        }

        if (!empty($filters['status'])) {
            $query->where('is_active', $filters['status']);
        }

        $allowedSort = ['sort_order', 'id', 'title', 'category', 'is_active', 'updated_at'];
        $sort = in_array($filters['sort'], $allowedSort, true) ? $filters['sort'] : 'sort_order';

        $dir = strtolower($filters['dir']) === 'desc' ? 'desc' : 'asc';

        $services = $query
            ->orderBy($sort, $dir)
            ->orderBy('id', 'desc')
            ->paginate(9)
            ->appends($request->query());

        $isActiveOptions = Service::IS_ACTIVE_SELECT;

        return view('admin.services.index', compact('services', 'filters', 'isActiveOptions'));
    }

    public function create()
    {
        abort_if(Gate::denies('service_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $isActiveOptions = Service::IS_ACTIVE_SELECT;

        return view('admin.services.create', compact('isActiveOptions'));
    }

    public function store(StoreServiceRequest $request)
    {
        abort_if(Gate::denies('service_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $service = Service::create($request->validated());

        $this->syncFeatures($service, $request);

        return redirect()->route('admin.services.index')->with('message', 'Service created successfully.');
    }

    public function edit(Service $service)
    {
        abort_if(Gate::denies('service_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $service->load(['features']);
        $isActiveOptions = Service::IS_ACTIVE_SELECT;

        return view('admin.services.edit', compact('service', 'isActiveOptions'));
    }

    public function update(UpdateServiceRequest $request, Service $service)
    {
        abort_if(Gate::denies('service_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $service->update($request->validated());

        $this->syncFeatures($service, $request);

        return redirect()->route('admin.services.index')->with('message', 'Service updated successfully.');
    }

    public function show(Service $service)
    {
        abort_if(Gate::denies('service_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $service->load(['features']);

        return view('admin.services.show', compact('service'));
    }

    public function destroy(Service $service)
    {
        abort_if(Gate::denies('service_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $service->delete();

        return back()->with('message', 'Service deleted successfully.');
    }

    public function massDestroy(MassDestroyServiceRequest $request)
    {
        abort_if(Gate::denies('service_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        Service::whereIn('id', $request->input('ids', []))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    private function syncFeatures(Service $service, Request $request): void
    {
        $features = $request->input('features', []);
        $features = array_values(array_filter($features, function ($row) {
            return !empty(trim($row['feature_text'] ?? ''));
        }));

        // delete old
        $service->features()->delete();

        foreach ($features as $i => $row) {
            ServiceFeature::create([
                'service_id'    => $service->id,
                'feature_text'  => trim($row['feature_text']),
                'sort_order'    => (int)($row['sort_order'] ?? ($i + 1)),
            ]);
        }
    }
}
