<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyDealershipApplicationRequest;
use App\Http\Requests\StoreDealershipApplicationRequest;
use App\Http\Requests\UpdateDealershipApplicationRequest;
use App\Models\DealershipApplication;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class DealershipApplicationsController extends Controller
{
    use MediaUploadingTrait, CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('dealership_application_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = DealershipApplication::query()->select(sprintf('%s.*', (new DealershipApplication)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'dealership_application_show';
                $editGate      = 'dealership_application_edit';
                $deleteGate    = 'dealership_application_delete';
                $crudRoutePart = 'dealership-applications';

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
            $table->editColumn('full_name', function ($row) {
                return $row->full_name ? $row->full_name : '';
            });
            $table->editColumn('mobile', function ($row) {
                return $row->mobile ? $row->mobile : '';
            });
            $table->editColumn('email', function ($row) {
                return $row->email ? $row->email : '';
            });
            $table->editColumn('city_state', function ($row) {
                return $row->city_state ? $row->city_state : '';
            });
            $table->editColumn('business_type', function ($row) {
                return $row->business_type ? $row->business_type : '';
            });
            $table->editColumn('sales_focus', function ($row) {
                return $row->sales_focus ? $row->sales_focus : '';
            });
            $table->editColumn('experience', function ($row) {
                return $row->experience ? $row->experience : '';
            });
            $table->editColumn('upload_compay_profile', function ($row) {
                return $row->upload_compay_profile ? '<a href="' . $row->upload_compay_profile->getUrl() . '" target="_blank">' . trans('global.downloadFile') . '</a>' : '';
            });
            $table->editColumn('upload_gst', function ($row) {
                return $row->upload_gst ? '<a href="' . $row->upload_gst->getUrl() . '" target="_blank">' . trans('global.downloadFile') . '</a>' : '';
            });
            $table->editColumn('status', function ($row) {
                return $row->status ? $row->status : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'upload_compay_profile', 'upload_gst']);

            return $table->make(true);
        }

        return view('admin.dealershipApplications.index');
    }

    public function create()
    {
        abort_if(Gate::denies('dealership_application_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.dealershipApplications.create');
    }

    public function store(StoreDealershipApplicationRequest $request)
    {
        $dealershipApplication = DealershipApplication::create($request->all());

        if ($request->input('upload_compay_profile', false)) {
            $dealershipApplication->addMedia(storage_path('tmp/uploads/' . basename($request->input('upload_compay_profile'))))->toMediaCollection('upload_compay_profile');
        }

        if ($request->input('upload_gst', false)) {
            $dealershipApplication->addMedia(storage_path('tmp/uploads/' . basename($request->input('upload_gst'))))->toMediaCollection('upload_gst');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $dealershipApplication->id]);
        }

        return redirect()->route('admin.dealership-applications.index');
    }

    public function edit(DealershipApplication $dealershipApplication)
    {
        abort_if(Gate::denies('dealership_application_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.dealershipApplications.edit', compact('dealershipApplication'));
    }

    public function update(UpdateDealershipApplicationRequest $request, DealershipApplication $dealershipApplication)
    {
        $dealershipApplication->update($request->all());

        if ($request->input('upload_compay_profile', false)) {
            if (! $dealershipApplication->upload_compay_profile || $request->input('upload_compay_profile') !== $dealershipApplication->upload_compay_profile->file_name) {
                if ($dealershipApplication->upload_compay_profile) {
                    $dealershipApplication->upload_compay_profile->delete();
                }
                $dealershipApplication->addMedia(storage_path('tmp/uploads/' . basename($request->input('upload_compay_profile'))))->toMediaCollection('upload_compay_profile');
            }
        } elseif ($dealershipApplication->upload_compay_profile) {
            $dealershipApplication->upload_compay_profile->delete();
        }

        if ($request->input('upload_gst', false)) {
            if (! $dealershipApplication->upload_gst || $request->input('upload_gst') !== $dealershipApplication->upload_gst->file_name) {
                if ($dealershipApplication->upload_gst) {
                    $dealershipApplication->upload_gst->delete();
                }
                $dealershipApplication->addMedia(storage_path('tmp/uploads/' . basename($request->input('upload_gst'))))->toMediaCollection('upload_gst');
            }
        } elseif ($dealershipApplication->upload_gst) {
            $dealershipApplication->upload_gst->delete();
        }

        return redirect()->route('admin.dealership-applications.index');
    }

    public function show(DealershipApplication $dealershipApplication)
    {
        abort_if(Gate::denies('dealership_application_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.dealershipApplications.show', compact('dealershipApplication'));
    }

    public function destroy(DealershipApplication $dealershipApplication)
    {
        abort_if(Gate::denies('dealership_application_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $dealershipApplication->delete();

        return back();
    }

    public function massDestroy(MassDestroyDealershipApplicationRequest $request)
    {
        $dealershipApplications = DealershipApplication::find(request('ids'));

        foreach ($dealershipApplications as $dealershipApplication) {
            $dealershipApplication->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('dealership_application_create') && Gate::denies('dealership_application_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new DealershipApplication();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
