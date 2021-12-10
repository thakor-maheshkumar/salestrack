<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CustomerPrimaryGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (\App\Models\CustomerGroup::count() == 0)
        {
            \App\Models\CustomerGroup::insert([
                [
                    'group_name' => 'Assets',
                    'under' => 0,
                    'group_type' => 0
                ],
                [
                    'group_name' => 'Liabilities',
                    'under' => 0,
                    'group_type' => 0
                ],
                [
                    'group_name' => 'Income',
                    'under' => 0,
                    'group_type' => 0
                ],
                [
                    'group_name' => 'Expenses',
                    'under' => 0,
                    'group_type' => 0
                ]]);
        }
    }
}
