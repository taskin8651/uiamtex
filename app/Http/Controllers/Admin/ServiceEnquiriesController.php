<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyServiceEnquiryRequest;
use App\Http\Requests\StoreServiceEnquiryRequest;
use App\Http\Requests\UpdateServiceEnquiryRequest;
use App\Models\ServiceEnquiry;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ServiceEnquiriesController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('service_enquiry_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $filters = $request->only(['q', 'status', 'sort', 'dir']);

        $query = ServiceEnquiry::query();

        if (!empty($filters['q'])) {
            $q = trim($filters['q']);
            $query->where(function ($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhere('phone', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%")
                    ->orWhere('city', 'like', "%{$q}%")
                    ->orWhere('premises_type', 'like', "%{$q}%")
                    ->orWhere('service_required', 'like', "%{$q}%")
                    ->orWhere('id', $q);
            });
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        $sort = $filters['sort'] ?? 'created_at';
        $dir  = $filters['dir'] ?? 'desc';

        $allowedSort = ['id', 'name', 'status', 'created_at', 'updated_at'];
        if (!in_array($sort, $allowedSort, true)) $sort = 'created_at';
        if (!in_array($dir, ['asc', 'desc'], true)) $dir = 'desc';

        $serviceEnquiries = $query
            ->orderBy($sort, $dir)
            ->paginate(9)
            ->appends($request->query());

        $statusOptions = ServiceEnquiry::STATUS_SELECT;

        return view('admin.serviceEnquiries.index', compact('serviceEnquiries', 'filters', 'statusOptions'));
    }

    public function create()
    {
        abort_if(Gate::denies('service_enquiry_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $statusOptions = ServiceEnquiry::STATUS_SELECT;

        return view('admin.serviceEnquiries.create', compact('statusOptions'));
    }

    public function store(StoreServiceEnquiryRequest $request)
    {
        ServiceEnquiry::create($request->validated());

        return redirect()->route('admin.service-enquiries.index')
            ->with('message', 'Service enquiry created successfully.');
    }

    public function edit(ServiceEnquiry $serviceEnquiry)
    {
        abort_if(Gate::denies('service_enquiry_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $statusOptions = ServiceEnquiry::STATUS_SELECT;

        return view('admin.serviceEnquiries.edit', compact('serviceEnquiry', 'statusOptions'));
    }

    public function update(UpdateServiceEnquiryRequest $request, ServiceEnquiry $serviceEnquiry)
    {
        $serviceEnquiry->update($request->validated());

        return redirect()->route('admin.service-enquiries.index')
            ->with('message', 'Service enquiry updated successfully.');
    }

    public function show(ServiceEnquiry $serviceEnquiry)
    {
        abort_if(Gate::denies('service_enquiry_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $statusOptions = ServiceEnquiry::STATUS_SELECT;

        return view('admin.serviceEnquiries.show', compact('serviceEnquiry', 'statusOptions'));
    }

    public function destroy(ServiceEnquiry $serviceEnquiry)
    {
        abort_if(Gate::denies('service_enquiry_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $serviceEnquiry->delete();

        return back()->with('message', 'Service enquiry deleted successfully.');
    }

    public function massDestroy(MassDestroyServiceEnquiryRequest $request)
    {
        $items = ServiceEnquiry::find(request('ids'));

        foreach ($items as $item) {
            $item->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
