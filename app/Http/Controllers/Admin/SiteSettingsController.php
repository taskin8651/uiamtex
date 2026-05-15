<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroySiteSettingRequest;
use App\Http\Requests\StoreSiteSettingRequest;
use App\Http\Requests\UpdateSiteSettingRequest;
use App\Models\SiteSetting;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;

class SiteSettingsController extends Controller
{
   public function index(Request $request)
    {
        abort_if(Gate::denies('site_setting_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $siteSetting = SiteSetting::first();

        return view('admin.siteSettings.index', compact('siteSetting'));
    }

    public function create()
    {
        abort_if(Gate::denies('site_setting_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // Singleton: if already exists, redirect to edit
        $existing = SiteSetting::first();
        if ($existing) {
            return redirect()->route('admin.site-settings.edit', $existing->id)
                ->with('message', 'Site Settings already exists. You can update it here.');
        }

        return view('admin.siteSettings.create');
    }

    public function store(StoreSiteSettingRequest $request)
    {
        $existing = SiteSetting::first();
        if ($existing) {
            return redirect()->route('admin.site-settings.edit', $existing->id)
                ->with('message', 'Site Settings already exists. You can update it here.');
        }

        $data = $request->all();

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('site-settings', 'public');
        }

        if ($request->hasFile('favicon')) {
            $data['favicon'] = $request->file('favicon')->store('site-settings', 'public');
        }

        SiteSetting::create($data);

        return redirect()->route('admin.site-settings.index')
            ->with('message', 'Site Settings saved successfully.');
    }


    public function edit(SiteSetting $siteSetting)
    {
        abort_if(Gate::denies('site_setting_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.siteSettings.edit', compact('siteSetting'));
    }

    public function update(UpdateSiteSettingRequest $request, SiteSetting $siteSetting)
    {
        $data = $request->all();

        if ($request->hasFile('logo')) {
            if ($siteSetting->logo) {
                Storage::disk('public')->delete($siteSetting->logo);
            }
            $data['logo'] = $request->file('logo')->store('site-settings', 'public');
        }

        if ($request->hasFile('favicon')) {
            if ($siteSetting->favicon) {
                Storage::disk('public')->delete($siteSetting->favicon);
            }
            $data['favicon'] = $request->file('favicon')->store('site-settings', 'public');
        }

        $siteSetting->update($data);

        return redirect()->route('admin.site-settings.index')
            ->with('message', 'Site Settings updated successfully.');
    }


    public function show(SiteSetting $siteSetting)
    {
        abort_if(Gate::denies('site_setting_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.siteSettings.show', compact('siteSetting'));
    }

    public function destroy(SiteSetting $siteSetting)
    {
        abort_if(Gate::denies('site_setting_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $siteSetting->delete();

        return back();
    }

    public function massDestroy(MassDestroySiteSettingRequest $request)
    {
        $siteSettings = SiteSetting::find(request('ids'));

        foreach ($siteSettings as $siteSetting) {
            $siteSetting->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
