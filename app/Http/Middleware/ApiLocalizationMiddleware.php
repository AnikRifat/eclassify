<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiLocalizationMiddleware {
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(Request): (Response|RedirectResponse) $next
     * @return JsonResponse
     */
    public function handle(Request $request, Closure $next) {
//        $request->headers->set('Accept', 'application/json');
//        $request->headers->set('Content-Type', 'application/json');
        $localization = $request->header('Content-Language');
        app()->setLocale($localization);

        return $next($request);
    }
}
