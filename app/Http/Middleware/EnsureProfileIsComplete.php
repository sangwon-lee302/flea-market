<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureProfileIsComplete
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $profile = auth()->user()->profile;

        $requiredFields = ['nickname', 'postal_code', 'address'];

        $isIncompleteProfile = collect($requiredFields)->contains(fn ($field) => empty($profile->{$field}));

        if ($isIncompleteProfile && ! $request->routeIs('profiles.edit', 'profiles.update')) {
            return redirect()->guest(route('profiles.edit', ['profile' => $profile]));
        }

        return $next($request);
    }
}
