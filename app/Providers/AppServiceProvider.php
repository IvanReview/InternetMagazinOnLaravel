<?php

namespace App\Providers;

use App\Models\Product;
use App\Observers\ProductObserver;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

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
        Blade::directive('routeactive', function ($route){
            /*dd(\Route::currentRouteName($route));*/
            return "<?php echo \Route::currentRouteName($route) ? 'class=\"active\"'  : '' ?>";
        });

        Blade::if('admin', function (){
            return Auth::check() && Auth::user()->isAdmin();
        });

        Product::observe(ProductObserver::class);
    }
}
