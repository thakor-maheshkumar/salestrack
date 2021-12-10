<?php

namespace App\Helpers;

use App\Models\User;
use Sentinel;

class Helper
{
    /**
     * Get Get user has menu access or not.
     *
     * @param string $data
     * @return string
     */
    public static function isMenuOpen($routes)
    {
        $is_open_class = 'show';

        if(is_array($routes) && !empty($routes))
        {
            foreach($routes as $key => $temp_route)
            {
                if(str_contains(request()->url(), $temp_route))
                {
                    return $is_open_class;
                }
            }
        }
        else {
            return str_contains(request()->url(), $routes) ? $is_open_class : '';
        }

        return '';
    }

    /**
     * Get Get user has menu access or not.
     *
     * @param string $data
     * @return string
     */
    public static function userHasMenuAccess($routes_list)
    {
        if(is_array($routes_list) && !empty($routes_list))
        {
            foreach($routes_list as $key => $temp_route)
            {
                if(\Helper::userHasPageAccess($temp_route))
                {
                    return true;
                }
            }
        }

        return false;
    }
	/**
	 * Get user has page access or not.
	 *
	 * @param string $data
	 * @return string
	 */
	public static function userHasPageAccess($route_name)
	{
		$defaultRoutes = config('default_routes.user');
        $user = \Sentinel::getUser();
        if ($user && $user instanceof User)
        {
            if($user->inRole('admin'))
            {
                return true;
            }
            else if(!empty($defaultRoutes) && in_array($route_name, $defaultRoutes))
            {
            	return true;
            }
            else
            {
                if ($user->hasAccess($route_name)) {
                    if ($user->has('userPermission'))
                    {
                        /*$userPermissions = $user->userPermission()->where('role_permissions', '!=', '')->get();
                        $hasAccess = false;
                        foreach ($userPermissions as $key => $userPermission) {
                            if(!empty($userPermission['role_permissions']) && array_key_exists($route_name, $userPermission['role_permissions'])){
                                $hasAccess = true;
                                return true;
                            }
                        }*/

                        if(!empty($user->permissions))
                        {
                            $hasAccess = false;
                            if(array_key_exists($route_name, $user->permissions)){
                                $hasAccess = true;
                                return true;
                            }
                        }

                        if($hasAccess)
                        {
                            $hasAccess = $user->hasExpiry($route_name);
                        }

                        if(! $hasAccess)
                            return false;
                    }

                    return true;
                }
            }
        }

        return false;
	}
}
