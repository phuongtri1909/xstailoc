<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('frontend.layouts._footer', function ($view) {
            $links_footer = \App\Models\LinkFooter::get();
            $view->with('links_footer', $links_footer);
        });

        View::composer('frontend.layouts._header', function ($view) {
            $linkHeaders = \App\Models\LinkHeader::get();
            $view->with('linkHeaders', $linkHeaders);
        });
    }
}
