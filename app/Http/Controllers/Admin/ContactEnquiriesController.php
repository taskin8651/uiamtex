<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyContactEnquiryRequest;
use App\Http\Requests\StoreContactEnquiryRequest;
use App\Http\Requests\UpdateContactEnquiryRequest;
use App\Models\ContactEnquiry;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class ContactEnquiriesController extends Controller
{
    use MediaUploadingTrait, CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('contact_enquiry_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = ContactEnquiry::query()->select(sprintf('%s.*', (new ContactEnquiry)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'contact_enquiry_show';
                $editGate      = 'contact_enquiry_edit';
                $deleteGate    = 'contact_enquiry_delete';
                $crudRoutePart = 'contact-enquiries';

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
            $table->editColumn('enquiry_type', function ($row) {
                return $row->enquiry_type ? $row->enquiry_type : '';
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
            $table->editColumn('message', function ($row) {
                return $row->message ? $row->message : '';
            });
            $table->editColumn('status', function ($row) {
                return $row->status ? ContactEnquiry::STATUS_SELECT[$row->status] : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.contactEnquiries.index');
    }

    public function create()
    {
        abort_if(Gate::denies('contact_enquiry_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.contactEnquiries.create');
    }

    public function store(StoreContactEnquiryRequest $request)
    {
        $contactEnquiry = ContactEnquiry::create($request->all());

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $contactEnquiry->id]);
        }

        return redirect()->route('admin.contact-enquiries.index');
    }

    public function edit(ContactEnquiry $contactEnquiry)
    {
        abort_if(Gate::denies('contact_enquiry_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.contactEnquiries.edit', compact('contactEnquiry'));
    }

    public function update(UpdateContactEnquiryRequest $request, ContactEnquiry $contactEnquiry)
    {
        $contactEnquiry->update($request->all());

        return redirect()->route('admin.contact-enquiries.index');
    }

    public function show(ContactEnquiry $contactEnquiry)
    {
        abort_if(Gate::denies('contact_enquiry_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.contactEnquiries.show', compact('contactEnquiry'));
    }

    public function destroy(ContactEnquiry $contactEnquiry)
    {
        abort_if(Gate::denies('contact_enquiry_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $contactEnquiry->delete();

        return back();
    }

    public function massDestroy(MassDestroyContactEnquiryRequest $request)
    {
        $contactEnquiries = ContactEnquiry::find(request('ids'));

        foreach ($contactEnquiries as $contactEnquiry) {
            $contactEnquiry->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('contact_enquiry_create') && Gate::denies('contact_enquiry_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new ContactEnquiry();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
