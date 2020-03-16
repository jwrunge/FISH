<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;


class MustBeApproved
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!Auth::user()->can('dostuff')) {
            abort(401, 'You are not yet approved to write, edit, or delete posts! Please contact a site administrator.');
        }

        return $next($request);
    }
}
