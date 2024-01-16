<?php
namespace App\Providers;

use App\Http\Kernel;
use Carbon\CarbonInterval;
use Illuminate\Database\Connection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Exception when call non-existing fields
        Model::shouldBeStrict(!app()->isProduction());

        if (app()->isProduction()) {
            // For every sql-query
            DB::listen(function ($query) {
                if ($query->time > 100) {
                    logger()
                        ->channel('telegram')
                        ->debug('query longer than 1ms:' . $query->sql, $query->bindings);
                }
            });

            app(Kernel::class)->whenRequestLifecycleIsLongerThan(
                CarbonInterval::seconds(4),
                function () {
                    logger()
                        ->channel('telegram')
                        ->debug('whenQueryingForLongerThan:' . request()->url());
                }
            );
        }
    }
}
