<?php

namespace Modules\Translations\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class ForceLocaleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        if ($request->has("_l") and !empty($request->get("_l"))) {
            App::setLocale($request->get("_l"));
        } else {
            App::setLocale(config("app.locale"));
        }
        return $next($request);
    }
}
