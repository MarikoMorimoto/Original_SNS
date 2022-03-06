<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
// Bootstrap でpagination を綺麗に表示するための設定
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Bootstrap でpagination を綺麗に表示するための設定
        Paginator::useBootstrap();
    }
}
