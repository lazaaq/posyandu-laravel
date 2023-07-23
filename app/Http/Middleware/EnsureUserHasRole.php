<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, string ...$roles)
    {
        $prohibited = true;
        foreach($roles as $role) {
            if ($request->user()->role == $role) {
                $prohibited = false;
                break;
            }
        }
        if ($prohibited) {
            $user = getUser();
            return responseAPI(401, 'Unauthorized', $request->user());
        }

        return $next($request);
    }
}
