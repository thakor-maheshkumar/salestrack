<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Permissions\DefaultPermission;
use DB;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(DB::table('roles')->get()->count() == 0)
        {
            /*$defalitPermissionObj = new DefaultPermission();
            $admin_permission = $defalitPermissionObj->getDefaultAdminPermission();
            $user_permission = $defalitPermissionObj->getDefaultUserPermission();*/

        	$Roles = [
                [
                    'slug' => 'admin',
                    'name' => 'admin',
                    /*'permissions' => (isset($admin_permission['permissions']) && !empty($admin_permission['permissions'])) ? json_encode($admin_permission['permissions']) : null,
                    'screens' => (isset($admin_permission['screens']) && !empty($admin_permission['screens'])) ? json_encode($admin_permission['screens']) : null,*/
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),

                ],
                [
                    'slug' => 'user',
                    'name' => 'user',
                    /*'permissions' => (isset($user_permission['permissions']) && !empty($user_permission['permissions'])) ? json_encode($user_permission['permissions']) : null,
                    'screens' => (isset($user_permission['screens']) && !empty($user_permission['screens'])) ? json_encode($user_permission['screens']) : null,*/
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]
            ];

            DB::table('roles')->insert($Roles);
        }
        else
        {
            echo "\e[31mTable is not empty, therefore NOT ";
        }
    }
}
