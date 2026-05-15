<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyAmcEnquiryRequest;
use App\Http\Requests\StoreAmcEnquiryRequest;
use App\Http\Requests\UpdateAmcEnquiryRequest;
use App\Models\AmcEnquiry;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class AmcEnquiriesController extends Controller
{
    use MediaUploadingTrait, CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('amc_enquiry_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = AmcEnquiry::query()->select(sprintf('%s.*', (new AmcEnquiry)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'amc_enquiry_show';
                $editGate      = 'amc_enquiry_edit';
                $deleteGate    = 'amc_enquiry_delete';
                $crudRoutePart = 'amc-enquiries';

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
            $table->editColumn('plan_type', function ($row) {
                return $row->plan_type ? $row->plan_type : '';
            });
            $table->editColumn('city', function ($row) {
                return $row->city ? $row->city : '';
            });
            $table->editColumn('site_type', function ($row) {
                return $row->site_type ? $row->site_type : '';
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

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.amcEnquiries.index');
    }

    public function create()
    {
        abort_if(Gate::denies('amc_enquiry_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.amcEnquiries.create');
    }

    public function store(StoreAmcEnquiryRequest $request)
    {
        $amcEnquiry = AmcEnquiry::create($request->all());

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $amcEnquiry->id]);
        }

        return redirect()->route('admin.amc-enquiries.index');
    }

    public function edit(AmcEnquiry $amcEnquiry)
    {
        abort_if(Gate::denies('amc_enquiry_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.amcEnquiries.edit', compact('amcEnquiry'));
    }

    public function update(UpdateAmcEnquiryRequest $request, AmcEnquiry $amcEnquiry)
    {
        $amcEnquiry->update($request->all());

        return redirect()->route('admin.amc-enquiries.index');
    }

    public function show(AmcEnquiry $amcEnquiry)
    {
        abort_if(Gate::denies('amc_enquiry_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.amcEnquiries.show', compact('amcEnquiry'));
    }

    public function destroy(AmcEnquiry $amcEnquiry)
    {
        abort_if(Gate::denies('amc_enquiry_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $amcEnquiry->delete();

        return back();
    }

    public function massDestroy(MassDestroyAmcEnquiryRequest $request)
    {
        $amcEnquiries = AmcEnquiry::find(request('ids'));

        foreach ($amcEnquiries as $amcEnquiry) {
            $amcEnquiry->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('amc_enquiry_create') && Gate::denies('amc_enquiry_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new AmcEnquiry();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
