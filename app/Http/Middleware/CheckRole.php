<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if ($request->user()->isAdmins() && session()->has('SUPER_ADMIN_IMPERSONATE')) {
            return $next($request);
        }

        if ($request->user()->isAdmins()) {
            return $next($request);
        }

        if ($request->user()->hasRole($roles)) {
            return $next($request);
        }

        if ($request->wantsJson()) {
            return respondError(PERMISSION_DENIED, 403);
        }

        flash('Insufficient Permissions!', 'danger');

        return redirect()->to('/dashboard');
    }
}
