<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Permissions\DefaultPermission;
use DB;
use Sentinel;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(DB::table('users')->get()->count() == 0)
        {
            /*$defalitPermissionObj = new DefaultPermission();
            $admin_permission = $defalitPermissionObj->getDefaultAdminPermission();*/

            /**
        	 * Set the admin user credential
        	 *
        	 */
            $credentials = [
                'email'    => 'admin@admin.com',
                'password' => 'admin',
                'first_name' => 'admin',
                'last_name' => 'admin',
                'country_id' => 1,
                'active' => 1,
                /*'permissions' => (isset($admin_permission['permissions']) && !empty($admin_permission['permissions'])) ? $admin_permission['permissions'] : null,*/
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            /**
             * Register and Activate user and inserting all data into database
             *
             */
            $user = Sentinel::registerAndActivate($credentials);

            /**
             *  Attach the user with the admin role
             *
             */
            if ($user)
            {
            	$role = Sentinel::findRoleBySlug('admin');
            	$role->users()->attach($user);
            }
        }
        else
        {
            echo "\e[31mTable is not empty, therefore NOT ";
        }
    }
}
