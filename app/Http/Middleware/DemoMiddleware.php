<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DemoMiddleware {
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(Request): (Response|RedirectResponse) $next
     * @return RedirectResponse|JsonResponse
     */
    public function handle(Request $request, Closure $next) {
        $exclude_uri = array(
            '/user-signup',
            '/api/user-signup',
            '/logout',
            '/api/manage-favourite'
        );

        // This URI will be accessible in Demo mode , regardless of any user
        $includeUri = array(
            '/settings/store',
        );

        if (!config('app.demo_mode')) {
            return $next($request);
        }


        if (in_array($request->getRequestUri(), $exclude_uri) && !in_array($request->getRequestUri(), $includeUri)) {
            return $next($request);
        }

        if (Auth::user() === null) {
            return $next($request);
        }

        if ($request->isMethod('get')) {
            return $next($request);
        }

        //In APP Demo User should not be allowed to access but in panel demo off user should be allowed to access
        if (Auth::user()->mobile != "9876598765" && Auth::user()->hasRole('User')) {
            return $next($request);
        }

        if (Auth::user()->email == "demooff@gmail.com" && Auth::user()->hasRole('Super Admin')) {
            return $next($request);
        }


        if ($request->is('api/*') || $request->ajax()) {
            return response()->json(array(
                'error'   => true,
                'message' => "This is not allowed in the Demo Version.",
                'code'    => 112
            ));
        }

        return redirect()->back()->withErrors([
            'message' => "This is not allowed in the Demo Version"
        ]);
    }
}
