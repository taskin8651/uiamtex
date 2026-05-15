<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyIndustryRequest;
use App\Models\Industry;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IndustriesController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('industry_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $query = Industry::query();

        // Filters used by blade
        $filters = [
            'q'      => $request->get('q'),
            'status' => $request->get('status'),
            'sort'   => $request->get('sort', 'sort_order'),
            'dir'    => $request->get('dir', 'asc'),
        ];

        if (!empty($filters['q'])) {
            $search = trim($filters['q']);
            $query->where(function ($qB) use ($search) {
                $qB->where('title', 'like', "%{$search}%")
                   ->orWhere('id', $search);
            });
        }

        if (!empty($filters['status'])) {
            $query->where('is_active', $filters['status']);
        }

        $allowedSort = ['sort_order', 'id', 'title', 'icon', 'is_active', 'updated_at']; // ✅ icon included
        $sort = in_array($filters['sort'], $allowedSort) ? $filters['sort'] : 'sort_order';
        $dir  = $filters['dir'] === 'desc' ? 'desc' : 'asc';

        $industries = $query->orderBy($sort, $dir)->paginate(12);

        $isActiveOptions = Industry::IS_ACTIVE_SELECT;

        return view('admin.industries.index', compact('industries', 'filters', 'isActiveOptions'));
    }

    public function create()
    {
        abort_if(Gate::denies('industry_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.industries.create');
    }

    public function store(Request $request)
    {
        abort_if(Gate::denies('industry_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $request->validate([
            'title'      => ['required', 'string', 'max:255'],
            'icon'       => ['nullable', 'string', 'max:255'], // ✅ added
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active'  => ['required', 'in:yes,no'],
        ]);

        Industry::create([
            'title'      => $request->title,
            'icon'       => $request->icon, // ✅ added
            'sort_order' => $request->sort_order ?? 0,
            'is_active'  => $request->is_active,
        ]);

        return redirect()->route('admin.industries.index')
            ->with('message', 'Industry created successfully');
    }

    public function show(Industry $industry)
    {
        abort_if(Gate::denies('industry_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.industries.show', compact('industry'));
    }

    public function edit(Industry $industry)
    {
        abort_if(Gate::denies('industry_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.industries.edit', compact('industry'));
    }

    public function update(Request $request, Industry $industry)
    {
        abort_if(Gate::denies('industry_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $request->validate([
            'title'      => ['required', 'string', 'max:255'],
            'icon'       => ['nullable', 'string', 'max:255'], // ✅ added
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active'  => ['required', 'in:yes,no'],
        ]);

        $industry->update([
            'title'      => $request->title,
            'icon'       => $request->icon, // ✅ added
            'sort_order' => $request->sort_order ?? 0,
            'is_active'  => $request->is_active,
        ]);

        return redirect()->route('admin.industries.index')
            ->with('message', 'Industry updated successfully');
    }

    public function destroy(Industry $industry)
    {
        abort_if(Gate::denies('industry_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $industry->delete();

        return back()->with('message', 'Industry deleted successfully');
    }

    public function massDestroy(MassDestroyIndustryRequest $request)
    {
        abort_if(Gate::denies('industry_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        Industry::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * ✅ REQUIRED because your blade uses:
     * route('admin.industries.parseCsvImport')
     */
    public function parseCsvImport(Request $request)
    {
        abort_if(Gate::denies('industry_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // CsvImportTrait handles parsing via a separate controller method in some setups.
        // If your CsvImportTrait expects a "model" request param, keep it consistent.
        // If your trait uses a specific method signature, this is the safest fallback:
        return $this->csvImportParse($request);
    }
}
