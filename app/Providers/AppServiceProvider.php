<?php

namespace App\Providers;

use App\Http\Controllers\DataForNavbarController;
use App\Http\Controllers\DataUserForUserController;
use App\Models\Order;
use App\Models\User;
use App\Observers\OrderObserver;
use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;

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
        Paginator::useBootstrap();
        config(['app.locale' => 'id']);
	    Carbon::setLocale('id');
        date_default_timezone_set('Asia/Jakarta');



        view()->composer('components.navbar', function ($view) {
            $controller = new DataForNavbarController;
            $route_name = $controller->get_route_name();

            $data = [
                'route_name' => $route_name
            ];

            $view->with($data);
        });

        view()->composer('components.sidebaruser', function ($view) {
            $controller = new DataUserForUserController;
            $users = $controller->view_user();

            $data = [
                'users' => $users
            ];

            $view->with($data);
        });


        view()->composer('components.modalsidebar', function ($view) {
            $controller = new DataUserForUserController;
            $users = $controller->view_user();
            $produks = $controller->produk_contribute();

            $data = [
                'users' => $users,
                'produks' => $produks
            ];

            $view->with($data);
        });

        Gate::define('cust_design' , function(User $user){
            return $user->role == 1201 || $user->role == 1306;
        });
        Gate::define('designer' , function(User $user){
            return  $user->role == 1306;
        });

        Order::observe(OrderObserver::class);

    }
}
