<?php

namespace App\Providers;

use App\Models\Page;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class SiteSettingServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Share site settings + CMS pages globally with frontend views
        View::composer('frontend.*', function ($view) {

            // Site settings (single row)
            $siteSetting = SiteSetting::query()->first();

            // Navbar Pages
            $navbarPages = Page::query()
                ->where('is_active', 1)
                ->where('show_in_navbar', 1)
                ->orderBy('title', 'asc')
                ->get(['id', 'title', 'slug']);

            // Footer Pages
            $footerPages = Page::query()
                ->where('is_active', 1)
                ->where('show_in_footer', 1)
                ->orderBy('title', 'asc')
                ->get(['id', 'title', 'slug']);

            // Footer Bottom Pages
            $footerBottomPages = Page::query()
                ->where('is_active', 1)
                ->where('show_in_footer_bottom', 1)
                ->orderBy('title', 'asc')
                ->get(['id', 'title', 'slug']);

            $view->with(compact(
                'siteSetting',
                'navbarPages',
                'footerPages',
                'footerBottomPages'
            ));
        });
    }
}
