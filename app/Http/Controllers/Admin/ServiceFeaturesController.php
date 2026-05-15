<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyServiceFeatureRequest;
use App\Http\Requests\StoreServiceFeatureRequest;
use App\Http\Requests\UpdateServiceFeatureRequest;
use App\Models\Service;
use App\Models\ServiceFeature;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ServiceFeaturesController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('service_feature_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $filters = $request->only(['q', 'service_id', 'sort', 'dir']);

        $query = ServiceFeature::query()->with(['service']);

        if (!empty($filters['q'])) {
            $q = trim($filters['q']);
            $query->where(function ($sub) use ($q) {
                $sub->where('feature_text', 'like', "%{$q}%")
                    ->orWhere('id', $q);
            });
        }

        if (!empty($filters['service_id'])) {
            $query->where('service_id', $filters['service_id']);
        }

        $sort = $filters['sort'] ?? 'sort_order';
        $dir  = $filters['dir'] ?? 'asc';

        $allowedSort = ['id', 'service_id', 'sort_order', 'created_at', 'updated_at'];
        if (!in_array($sort, $allowedSort, true)) {
            $sort = 'sort_order';
        }
        if (!in_array($dir, ['asc', 'desc'], true)) {
            $dir = 'asc';
        }

        $serviceFeatures = $query
            ->orderBy($sort, $dir)
            ->orderBy('id', 'desc')
            ->paginate(9)
            ->appends($request->query());

        $services = Service::query()->orderBy('title', 'asc')->pluck('title', 'id');

        return view('admin.serviceFeatures.index', compact('serviceFeatures', 'filters', 'services'));
    }

    public function create()
    {
        abort_if(Gate::denies('service_feature_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $services = Service::query()->orderBy('title', 'asc')->pluck('title', 'id');

        return view('admin.serviceFeatures.create', compact('services'));
    }

    public function store(StoreServiceFeatureRequest $request)
    {
        ServiceFeature::create($request->validated());

        return redirect()->route('admin.service-features.index')
            ->with('message', 'Service feature added successfully.');
    }

    public function edit(ServiceFeature $serviceFeature)
    {
        abort_if(Gate::denies('service_feature_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $serviceFeature->load('service');
        $services = Service::query()->orderBy('title', 'asc')->pluck('title', 'id');

        return view('admin.serviceFeatures.edit', compact('serviceFeature', 'services'));
    }

    public function update(UpdateServiceFeatureRequest $request, ServiceFeature $serviceFeature)
    {
        $serviceFeature->update($request->validated());

        return redirect()->route('admin.service-features.index')
            ->with('message', 'Service feature updated successfully.');
    }

    public function show(ServiceFeature $serviceFeature)
    {
        abort_if(Gate::denies('service_feature_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $serviceFeature->load('service');

        return view('admin.serviceFeatures.show', compact('serviceFeature'));
    }

    public function destroy(ServiceFeature $serviceFeature)
    {
        abort_if(Gate::denies('service_feature_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $serviceFeature->delete();

        return back()->with('message', 'Service feature deleted successfully.');
    }

    public function massDestroy(MassDestroyServiceFeatureRequest $request)
    {
        $items = ServiceFeature::find(request('ids'));
        foreach ($items as $item) {
            $item->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
