<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View; // 追記
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
        // 追記
        View::composer('*', function ($view) {
            $view->with('user', auth()->user());
        });
        
        // Bootstrap でpagination を綺麗に表示するための設定
        Paginator::useBootstrap();
    }
}
