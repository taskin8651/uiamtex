<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyClientRequest;
use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Models\Client;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class ClientsController extends Controller
{
    use MediaUploadingTrait, CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('client_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $query = Client::query();

        // Search (name, id)
        if ($request->filled('q')) {
            $q = trim($request->q);
            $query->where(function ($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%");
                if (is_numeric($q)) {
                    $sub->orWhere('id', (int) $q);
                }
            });
        }

        // Status filter (your DB stores: yes/no)
        if ($request->filled('status')) {
            $query->where('is_active', $request->status);
        }

        // Sorting
        $sort = $request->get('sort', 'sort_order');
        $dir  = $request->get('dir', 'asc');

        $allowedSorts = ['id', 'name', 'sort_order', 'is_active', 'created_at', 'updated_at'];
        if (!in_array($sort, $allowedSorts, true)) {
            $sort = 'sort_order';
        }
        $dir = $dir === 'desc' ? 'desc' : 'asc';

        // Prefer sort_order first (if sorting by sort_order), then id desc for stable listing
        if ($sort === 'sort_order') {
            $query->orderBy('sort_order', $dir)->orderBy('id', 'desc');
        } else {
            $query->orderBy($sort, $dir);
        }

        $clients = $query->paginate(12)->appends($request->query());

        return view('admin.clients.index', [
            'clients' => $clients,
            'isActiveOptions' => Client::IS_ACTIVE_SELECT,
            'filters' => [
                'q' => $request->q,
                'status' => $request->status,
                'sort' => $sort,
                'dir' => $dir,
            ],
        ]);
    }

    public function create()
    {
        abort_if(Gate::denies('client_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.clients.create');
    }

    public function store(StoreClientRequest $request)
    {
        $client = Client::create($request->all());

        if ($request->input('logo', false)) {
            $client->addMedia(storage_path('tmp/uploads/' . basename($request->input('logo'))))->toMediaCollection('logo');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $client->id]);
        }

        return redirect()->route('admin.clients.index');
    }

    public function edit(Client $client)
    {
        abort_if(Gate::denies('client_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.clients.edit', compact('client'));
    }

    public function update(UpdateClientRequest $request, Client $client)
    {
        $client->update($request->all());

        if ($request->input('logo', false)) {
            if (! $client->logo || $request->input('logo') !== $client->logo->file_name) {
                if ($client->logo) {
                    $client->logo->delete();
                }
                $client->addMedia(storage_path('tmp/uploads/' . basename($request->input('logo'))))->toMediaCollection('logo');
            }
        } elseif ($client->logo) {
            $client->logo->delete();
        }

        return redirect()->route('admin.clients.index');
    }

    public function show(Client $client)
    {
        abort_if(Gate::denies('client_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.clients.show', compact('client'));
    }

    public function destroy(Client $client)
    {
        abort_if(Gate::denies('client_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $client->delete();

        return back();
    }

    public function massDestroy(MassDestroyClientRequest $request)
    {
        $clients = Client::find(request('ids'));

        foreach ($clients as $client) {
            $client->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('client_create') && Gate::denies('client_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Client();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
