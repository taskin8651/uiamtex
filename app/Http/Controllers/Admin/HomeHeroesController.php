<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeHero;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HomeHeroesController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('home_hero_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $heroes = HomeHero::query()
            ->orderBy('sort_order', 'asc')
            ->latest('id')
            ->paginate(12);

        // IMPORTANT: match your blade path + variable name
        return view('admin.herobanner.index', compact('heroes'));
    }

    public function create()
    {
        abort_if(Gate::denies('home_hero_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // IMPORTANT: match your created blade path
        return view('admin.herobanner.create');
    }

    public function store(Request $request)
    {
        abort_if(Gate::denies('home_hero_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $data = $request->validate([
            'badge_icon'      => ['nullable', 'string', 'max:255'],
            'badge_text'      => ['nullable', 'string', 'max:255'],
            'title_line_1'    => ['nullable', 'string', 'max:255'],
            'title_highlight' => ['nullable', 'string', 'max:255'],
            'subtitle'        => ['nullable', 'string'],
            'cta_text'        => ['nullable', 'string', 'max:255'],
            'cta_url'         => ['nullable', 'string', 'max:255'],
            'meta_text'       => ['nullable', 'string', 'max:255'],
            'desktop_image'   => ['nullable', 'image', 'max:4096'],
            'mobile_image'    => ['nullable', 'image', 'max:4096'],
            'sort_order'      => ['nullable', 'integer', 'min:0'],
            'is_active'       => ['nullable'],
        ]);

        if ($request->hasFile('desktop_image')) {
            $data['desktop_image'] = $request->file('desktop_image')->store('home-hero', 'public');
        }

        if ($request->hasFile('mobile_image')) {
            $data['mobile_image'] = $request->file('mobile_image')->store('home-hero', 'public');
        }

        $data['is_active']  = $request->boolean('is_active') ? 1 : 0;
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);

        HomeHero::create($data);

        return redirect()->route('admin.home-heroes.index')
            ->with('message', 'Home hero slide created successfully.');
    }

    public function show(HomeHero $home_hero)
    {
        abort_if(Gate::denies('home_hero_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // IMPORTANT: match your blade folder if you create it later
        return view('admin.herobanner.show', ['hero' => $home_hero]);
    }

    public function edit(HomeHero $home_hero)
    {
        abort_if(Gate::denies('home_hero_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // IMPORTANT: match your blade folder if you create it later
        return view('admin.herobanner.edit', ['hero' => $home_hero]);
    }

    public function update(Request $request, HomeHero $home_hero)
    {
        abort_if(Gate::denies('home_hero_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $data = $request->validate([
            'badge_icon'      => ['nullable', 'string', 'max:255'],
            'badge_text'      => ['nullable', 'string', 'max:255'],
            'title_line_1'    => ['nullable', 'string', 'max:255'],
            'title_highlight' => ['nullable', 'string', 'max:255'],
            'subtitle'        => ['nullable', 'string'],
            'cta_text'        => ['nullable', 'string', 'max:255'],
            'cta_url'         => ['nullable', 'string', 'max:255'],
            'meta_text'       => ['nullable', 'string', 'max:255'],
            'desktop_image'   => ['nullable', 'image', 'max:4096'],
            'mobile_image'    => ['nullable', 'image', 'max:4096'],
            'sort_order'      => ['nullable', 'integer', 'min:0'],
            'is_active'       => ['nullable'],
        ]);

        if ($request->hasFile('desktop_image')) {
            $data['desktop_image'] = $request->file('desktop_image')->store('home-hero', 'public');
        }

        if ($request->hasFile('mobile_image')) {
            $data['mobile_image'] = $request->file('mobile_image')->store('home-hero', 'public');
        }

        $data['is_active']  = $request->boolean('is_active') ? 1 : 0;
        $data['sort_order'] = (int) ($data['sort_order'] ?? $home_hero->sort_order);

        $home_hero->update($data);

        return redirect()->route('admin.home-heroes.index')
            ->with('message', 'Home hero slide updated successfully.');
    }

    public function destroy(HomeHero $home_hero)
    {
        abort_if(Gate::denies('home_hero_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $home_hero->delete();

        return back()->with('message', 'Home hero slide deleted.');
    }
}
