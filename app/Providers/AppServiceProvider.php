<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('*', function ($view) {
            $wishlistCount = auth()->check()
                ? auth()->user()->wishlists()->count()
                : 0;

            $view->with('wishlistCount', $wishlistCount);
        });
    }
}
