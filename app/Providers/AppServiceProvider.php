<?php

namespace App\Providers;

use App\Http\Kernel;
use Carbon\CarbonInterval;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Connection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    /**
     * @throws BindingResolutionException
     */
    public function boot(): void
    {
        Model::preventLazyLoading(! app()->isProduction());
        Model::preventSilentlyDiscardingAttributes(! app()->isProduction());

        DB::whenQueryingForLongerThan(CarbonInterval::milliseconds(500), function (Connection $connection) {
            // todo: Notify development team...
        });

        /** @var Kernel $kernel */
        $kernel = app()->make(Kernel::class);

        $kernel->whenRequestLifecycleIsLongerThan(CarbonInterval::seconds(4), function (Connection $connection) {
            // todo: Notify development team...
        });
    }
}
