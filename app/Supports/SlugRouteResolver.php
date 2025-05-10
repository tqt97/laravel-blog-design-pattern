<?php

namespace App\Supports;

use App\Models\SlugRedirect;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SlugRouteResolver
{
    /**
     * Resolve model by slug or redirect if an old slug is found.
     *
     * @param  string  $slug  The slug to resolve.
     * @param  string  $modelClass  The model class to search.
     * @param  string  $routeName  The route name to redirect if needed.
     * @param  string  $routeParam  The route parameter for redirection.
     *
     * @throws NotFoundHttpException If no model or redirect is found.
     */
    public static function resolve(string $slug, string $modelClass, string $routeName, string $routeParam): Model|RedirectResponse
    {
        $model = self::resolveModelBySlug($slug, $modelClass);

        if ($model instanceof Model) {
            return $model;
        }

        return self::handleRedirect($slug, $modelClass, $routeName, $routeParam);
    }

    /**
     * Resolve the model by slug.
     */
    protected static function resolveModelBySlug(string $slug, string $modelClass): ?Model
    {
        return $modelClass::where('slug', $slug)->first();
    }

    /**
     * Handle the redirect logic if an old slug is found.
     */
    protected static function handleRedirect(string $slug, string $modelClass, string $routeName, string $routeParam): RedirectResponse
    {
        $redirect = SlugRedirect::query()
            ->where('old_slug', $slug)
            ->where('model_type', $modelClass)
            ->latest()
            ->first();

        if ($redirect) {
            return to_route($routeName, [$routeParam => $redirect->new_slug], 301);
        }

        abort(404);
    }
}
