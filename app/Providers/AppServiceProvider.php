<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Session;
use Auth;
use DB;

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
        // View::share('process_code', DB::table('process_info')->orderBy('sequence','asc')->get());
        // View::share('user_id', Session::get('user_id'));
        Schema::defaultStringLength(191);
        // Passport::routes();
        // Paginator::useBootstrap();
    }
}
