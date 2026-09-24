<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Foundation\Vite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(Request $request): void
    {
        Paginator::useBootstrapFive();

        if (! app()->runningInConsole()) {
            URL::forceRootUrl(
                $request->getSchemeAndHttpHost().rtrim($request->getBaseUrl(), '/')
            );
        }

        app(Vite::class)->createAssetPathsUsing(function (string $path) {
            return rtrim(request()->getBaseUrl(), '/').'/'.ltrim($path, '/');
        });
    }
}
