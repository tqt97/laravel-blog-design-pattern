<?php

namespace App\Providers;

use App\Supports\SlugRouteResolver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class SlugBindingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        foreach (config('slug.bindings') as $param => $config) {
            Route::bind($param, function ($value) use ($config, $param): Model {
                $resolved = SlugRouteResolver::resolve(
                    slug: $value,
                    modelClass: $config['model'],
                    routeName: $config['route'],
                    routeParam: $param,
                );

                // if it's a redirect, send it
                if ($resolved instanceof RedirectResponse) {
                    $resolved->send();
                    exit;
                }

                return $resolved;
            });
        }
    }
}
