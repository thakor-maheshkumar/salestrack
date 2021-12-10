<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use App\Models\UserPermission;

class PermissionMiddleware
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
        /*$user = \Sentinel::getUser();
        if ($user && $user instanceof User) {
            if ($user->hasAccess($request->route()->getName())) {
                return $next($request);
            }
        }

        abort(403);*/

        /*$user = \Sentinel::getUser();
        if ($user && $user instanceof User) {
            if ($user->hasAccess($request->route()->getName())) {
                if ($user->has('userPermission')) {
                    $hasAccess = $user->hasExpiry($request->route()->getName());
                    
                    if(! $hasAccess)
                        abort(403);
                }

                return $next($request);
            }
        }

        abort(403);*/

        /*$user = \Sentinel::getUser();
        if ($user && $user instanceof User) {
            if ($user->hasAccess($request->route()->getName())) {
                if ($user->has('userPermission')) {
                    $hasAccess = $user->hasExpiry($request->route()->getName());
                    
                    if(! $hasAccess)
                        abort(403);
                }

                return $next($request);
            }
        }

        abort(403);*/

        /*$defaultRoutes = config('default_routes.user');

        $user = \Sentinel::getUser();
        if ($user && $user instanceof User)
        {
            if(($user->inRole('admin')) || (!empty($defaultRoutes) && in_array($request->route()->getName(), $defaultRoutes)))
            {
                return $next($request);
            }
            else
            {
                if ($user->hasAccess($request->route()->getName())) {
                    if ($user->has('userPermission')) {
                        $hasAccess = $user->hasExpiry($request->route()->getName());
                        
                        if(! $hasAccess)
                            abort(403);
                    }

                    return $next($request);
                }
            }
        }

        abort(403);*/

        $hasAccess = \Helper::userHasPageAccess($request->route()->getName());

        if(! $hasAccess)
            abort(403);

        return $next($request);
    }
}
