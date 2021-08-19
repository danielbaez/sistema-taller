<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use DB;
use Log;

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

        Blade::if('hasallpermissions', function ($permission) {
            return hasAllPermissions($permission);
        });

        Blade::if('hasanypermission', function ($permission) {
            return hasAnyPermission($permission);
        });

        DB::listen(function($query) {
            Log::info(
                $query->sql,
                $query->bindings,
                $query->time
            );
        });
    }
}
