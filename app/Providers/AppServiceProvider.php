<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

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
        Blade::directive('dsdsd', function ($permission) {
          return "<?php echo abc($permission); ?>";
        });

        Blade::if('rolpermission', function ($permission) {
            return rol_permission($permission);
        });

        Blade::if('rolpermissionany', function ($permission) {
            return rol_permission_any($permission);
        });
    }
}
