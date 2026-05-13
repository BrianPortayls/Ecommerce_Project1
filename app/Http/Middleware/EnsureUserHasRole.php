<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    public function handle(Request $request, Closure $next, string ...$roles): Response|RedirectResponse
    {
        if (! $request->user()) {
            abort(Response::HTTP_FORBIDDEN);
        }

        if (! in_array($request->user()->role, $roles, true)) {
            return redirect()->route($this->dashboardRoute($request->user()->role));
        }

        return $next($request);
    }

    protected function dashboardRoute(string $role): string
    {
        return match ($role) {
            'admin' => 'admin.dashboard',
            'manager' => 'manager.dashboard',
            default => 'dashboard',
        };
    }
}
