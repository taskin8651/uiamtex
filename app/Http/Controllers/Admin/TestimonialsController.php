<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyTestimonialRequest;
use App\Http\Requests\StoreTestimonialRequest;
use App\Http\Requests\UpdateTestimonialRequest;
use App\Models\Testimonial;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class TestimonialsController extends Controller
{
    use MediaUploadingTrait, CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('testimonial_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $filters = [
            'q'      => $request->get('q'),
            'status' => $request->get('status'),
            'sort'   => $request->get('sort', 'sort_order'),
            'dir'    => $request->get('dir', 'asc'),
        ];

        $allowedSort = ['sort_order','id','name','is_active','updated_at'];
        $sort = in_array($filters['sort'], $allowedSort, true) ? $filters['sort'] : 'sort_order';
        $dir  = strtolower($filters['dir']) === 'desc' ? 'desc' : 'asc';

        $query = Testimonial::query();

        if (!empty($filters['q'])) {
            $q = trim($filters['q']);
            $query->where(function ($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhere('company_designation', 'like', "%{$q}%")
                    ->orWhere('review', 'like', "%{$q}%")
                    ->orWhere('id', $q);
            });
        }

        if (!empty($filters['status'])) {
            $query->where('is_active', $filters['status']);
        }

        $testimonials = $query
            ->orderBy($sort, $dir)
            ->paginate(9)
            ->appends($request->query());

        $isActiveOptions = Testimonial::IS_ACTIVE_SELECT;

        return view('admin.testimonials.index', compact('testimonials', 'filters', 'isActiveOptions'));
    }

    public function create()
    {
        abort_if(Gate::denies('testimonial_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.testimonials.create');
    }

    public function store(StoreTestimonialRequest $request)
    {
        $testimonial = Testimonial::create($request->only([
            'name','company_designation','review','is_active','sort_order'
        ]));

        if ($request->input('photo', false)) {
            $testimonial->addMedia(storage_path('tmp/uploads/' . basename($request->input('photo'))))
                ->toMediaCollection('photo');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $testimonial->id]);
        }

        return redirect()->route('admin.testimonials.index')->with('message', 'Testimonial created successfully.');
    }

    public function edit(Testimonial $testimonial)
    {
        abort_if(Gate::denies('testimonial_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.testimonials.edit', compact('testimonial'));
    }

    public function update(UpdateTestimonialRequest $request, Testimonial $testimonial)
    {
        $testimonial->update($request->only([
            'name','company_designation','review','is_active','sort_order'
        ]));

        if ($request->input('photo', false)) {
            if (!$testimonial->photo || $request->input('photo') !== $testimonial->photo->file_name) {
                if ($testimonial->photo) {
                    $testimonial->photo->delete();
                }
                $testimonial->addMedia(storage_path('tmp/uploads/' . basename($request->input('photo'))))
                    ->toMediaCollection('photo');
            }
        } elseif ($testimonial->photo) {
            $testimonial->photo->delete();
        }

        return redirect()->route('admin.testimonials.index')->with('message', 'Testimonial updated successfully.');
    }

    public function show(Testimonial $testimonial)
    {
        abort_if(Gate::denies('testimonial_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.testimonials.show', compact('testimonial'));
    }

    public function destroy(Testimonial $testimonial)
    {
        abort_if(Gate::denies('testimonial_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $testimonial->delete();

        return back()->with('message', 'Testimonial deleted successfully.');
    }

    public function massDestroy(MassDestroyTestimonialRequest $request)
    {
        $testimonials = Testimonial::find(request('ids'));
        foreach ($testimonials as $testimonial) {
            $testimonial->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(
            Gate::denies('testimonial_create') && Gate::denies('testimonial_edit'),
            Response::HTTP_FORBIDDEN,
            '403 Forbidden'
        );

        $model         = new Testimonial();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;

        $media = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
