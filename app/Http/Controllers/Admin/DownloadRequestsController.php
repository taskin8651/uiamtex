<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyDownloadRequestRequest;
use App\Http\Requests\StoreDownloadRequestRequest;
use App\Http\Requests\UpdateDownloadRequestRequest;
use App\Models\DownloadRequest;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class DownloadRequestsController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('download_request_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // Filters
        $filters = [
            'q'     => trim((string) $request->get('q', '')),
            'sort'  => $request->get('sort', 'id'),
            'dir'   => $request->get('dir', 'desc'),
            'from'  => $request->get('from', null),
            'to'    => $request->get('to', null),
        ];

        $allowedSorts = ['id', 'name', 'phone', 'email', 'company', 'city', 'purpose', 'created_at'];
        $sort = in_array($filters['sort'], $allowedSorts, true) ? $filters['sort'] : 'id';
        $dir  = in_array(strtolower($filters['dir']), ['asc', 'desc'], true) ? strtolower($filters['dir']) : 'desc';

        $query = DownloadRequest::query()
            ->with(['downloadRelation']) // relation from DownloadRequest model
            ->when($filters['q'] !== '', function ($q) use ($filters) {
                $term = $filters['q'];
                $q->where(function ($qq) use ($term) {
                    $qq->where('id', $term)
                    ->orWhere('name', 'like', "%{$term}%")
                    ->orWhere('phone', 'like', "%{$term}%")
                    ->orWhere('email', 'like', "%{$term}%")
                    ->orWhere('company', 'like', "%{$term}%")
                    ->orWhere('city', 'like', "%{$term}%")
                    ->orWhere('purpose', 'like', "%{$term}%")
                    ->orWhere('download', 'like', "%{$term}%");
                });
            })
            ->when($filters['from'], function ($q) use ($filters) {
                $q->whereDate('created_at', '>=', $filters['from']);
            })
            ->when($filters['to'], function ($q) use ($filters) {
                $q->whereDate('created_at', '<=', $filters['to']);
            })
            ->orderBy($sort, $dir);

        $downloadRequests = $query->paginate(12)->appends($request->query());

        return view('admin.downloadRequests.index', [
            'downloadRequests' => $downloadRequests,
            'filters'          => $filters,
        ]);
    }


    public function create()
    {
        abort_if(Gate::denies('download_request_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.downloadRequests.create');
    }

    public function store(StoreDownloadRequestRequest $request)
    {
        $downloadRequest = DownloadRequest::create($request->all());

        return redirect()->route('admin.download-requests.index');
    }

    public function edit(DownloadRequest $downloadRequest)
    {
        abort_if(Gate::denies('download_request_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.downloadRequests.edit', compact('downloadRequest'));
    }

    public function update(UpdateDownloadRequestRequest $request, DownloadRequest $downloadRequest)
    {
        $downloadRequest->update($request->all());

        return redirect()->route('admin.download-requests.index');
    }

    public function show(DownloadRequest $downloadRequest)
    {
        abort_if(Gate::denies('download_request_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.downloadRequests.show', compact('downloadRequest'));
    }

    public function destroy(DownloadRequest $downloadRequest)
    {
        abort_if(Gate::denies('download_request_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $downloadRequest->delete();

        return back();
    }

    public function massDestroy(MassDestroyDownloadRequestRequest $request)
    {
        $downloadRequests = DownloadRequest::find(request('ids'));

        foreach ($downloadRequests as $downloadRequest) {
            $downloadRequest->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
