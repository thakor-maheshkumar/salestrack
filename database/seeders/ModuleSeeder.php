<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(DB::table('modules')->get()->count() == 0)
        {
            /**
        	 * Set the admin user credential
        	 *
        	 */
            $modules = [
                [
                    'name' => 'Country',
                    'slug' => 'country',
                    'alias' => 'CO',
                    'table' => 'countries',
                    'is_default_module' => 1,
                    'type' => 1,
                    'parent_module' => 0,
                    'status' => 1,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ],
            	[
	                'name' => 'Company',
                    'slug' => 'company',
	                'alias' => 'C',
	                'table' => 'companies',
                    'is_default_module' => 1,
	                'type' => 1,
                    'parent_module' => 0,
	                'status' => 1,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ],
                [
                    'name' => 'Department',
	                'slug' => 'department',
	                'alias' => 'D',
	                'table' => 'departments',
                    'is_default_module' => 1,
	                'type' => 1,
                    'parent_module' => 2,
	                'status' => 1,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ],
                [
	                'name' => 'Warehouse',
                    'slug' => 'warehouse',
	                'alias' => 'W',
	                'table' => 'warehouse',
                    'is_default_module' => 1,
	                'type' => 1,
                    'parent_module' => 2,
	                'status' => 1,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ],
            ];

            DB::table('modules')->insert($modules);
        }
        else
        {
            echo "\e[31mTable is not empty, therefore NOT ";
        }
    }
}
