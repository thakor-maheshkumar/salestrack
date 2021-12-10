<?php

namespace App\Permissions;

use App\Models\PermissionScreen;
use Sentinel;

class DefaultPermission
{
    protected $default_admin_permission = [
        'create',
        'edit',
        'view',
        'other'
    ];

    protected $default_user_permission = [
        'view'
    ];

    /**
     * Get default user access list
     *
     * @param       $table_name
     * @param array $fields
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDefaultUserAccess()
    {
       return $this->default_user_permission;
    }

    /**
     * Get default user access list
     *
     * @return array
     */
    public function getDefaultAdminAccess()
    {
       return $this->default_admin_permission;
    }

    /**
     * Get default permission list
     *
     * @param array $access_list
     *
     * @return array
     */
    public function getDefaultPermission($access_list)
    {
        $screens_data = PermissionScreen::active()->get()->toArray();

        $permission_list = $screen_list = [];

        if(!empty($screens_data))
        {
            foreach ($screens_data as $key_1 => $screen)
            {
                foreach ($access_list as $key_2 => $access)
                {
                    if(isset($screen[$access]) && !empty($screen[$access]))
                    {
                        $all_permissions = array_values(explode(',',$screen[$access]));
                        foreach ($all_permissions as $key_3 => $temp_permission) {
                            $permission_list[$temp_permission] = true;
                        }
                    }
                }

                $screen_list[] = $screen['id'];
            }
        }

        return [
            'permissions' => $permission_list,
            'screens' => $screen_list
        ];
    }

    /**
     * Get default admin permission list
     *
     * @return array
     */
    public function getDefaultAdminPermission()
    {
        return $this->getDefaultPermission($this->default_admin_permission);
    }

    /**
     * Get default user permission list
     *
     * @return array
     */
    public function getDefaultUserPermission()
    {
       return $this->getDefaultPermission($this->default_user_permission);
    }

    /**
     * Get user permission list
     *
     * @param array $user
     * @param array $roles
     * @param array $access
     * @param array $access_start
     * @param array $access_end
     *
     * @return array
     */
    public function getUserPermission($user, $roles, $access, $access_start, $access_end)
    {
        $screens_data = PermissionScreen::active()->get()->toArray();
        $permission_list = $user_permission = [];
        
        if(!empty($screens_data))
        {
            foreach ($roles as $key_1 => $role_id) {
                $role = Sentinel::findRoleById($role_id);
                $role_permission_list = [];

                if($role)
                {
                    //$role->users()->attach($user);

                    if(!empty($role->screens))
                    {
                        foreach ($role->screens as $key_2 => $screen)
                        {
                            $screen_key = array_search($screen, array_column($screens_data, 'id'));
                            if(isset($screens_data[$screen_key]))
                            {
                                if(!(empty($access[$key_1])) && (!in_array('view',$access[$key_1])))
                                {
                                    $access[$key_1][] = 'view';
                                }
                    
                                foreach ($access[$key_1] as $key_3 => $permission) 
                                {
                                    if(isset($screens_data[$screen_key][$permission]) && !empty($screens_data[$screen_key][$permission]))
                                    {
                                        $all_permissions = array_values(explode(',',$screens_data[$screen_key][$permission]));
                                        
                                        foreach ($all_permissions as $key_4 => $temp_permission) {
                                            $permission_list[$temp_permission] = true;
                                            $role_permission_list[$temp_permission] = true;
                                        }
                                    }
                                }
                            }
                        }

                        if(isset($access_start[$key_1]) && isset($access_end[$key_1]))
                        {
                            $user_permission[] = [
                                'user_id' => $user->id,
                                'role_id' => $role_id,
                                'start_date' => $access_start[$key_1],
                                'expiry_date' => $access_end[$key_1],
                                'role_permissions' => $role_permission_list,
                                'created_at' => date('Y-m-d H:i:s'),
                                'updated_at' => date('Y-m-d H:i:s'),
                            ];
                        }
                    }
                }
            } 
        }

        return [
            'permission_list' => $permission_list,
            'user_permission' => $user_permission
        ];
    }

    /**
     * Get role permission list
     *
     * @param array $roles
     * @param array $access_start
     * @param array $access_end
     *
     * @return array
     */
    public function getRolePermission($screens, $access)
    {
        $screens_data = PermissionScreen::active()->get()->toArray();
        $permission_list = $screen_list = [];

        if(!empty($screens_data))
        {
            foreach ($screens as $key => $screen) {
                $screen_key = array_search($screen, array_column($screens_data, 'id'));
                if(isset($screens_data[$screen_key]))
                {
                    if(!(empty($access[$key])) && (!in_array('view',$access[$key])))
                    {
                        $access[$key][] = 'view';
                    }

                    foreach ($access[$key] as $key_1 => $permission) 
                    {
                        if(isset($screens_data[$screen_key][$permission]))
                        {
                            $all_permissions = array_values(explode(',',$screens_data[$screen_key][$permission]));
                            
                            foreach ($all_permissions as $key_2 => $temp_permission) {
                                $permission_list[$temp_permission] = true;
                            }
                        }
                    }

                    $screen_list[] = $screen;
                }
            }
        }

        return [
            'permission_list' => $permission_list,
            'screen_list' => $screen_list
        ];
    }
}