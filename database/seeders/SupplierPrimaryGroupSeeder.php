<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SupplierPrimaryGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (\App\Models\SupplierGroup::count() == 0)
        {
            \App\Models\SupplierGroup::insert([
                [
                    'group_name' => 'Assets',
                    'under' => 0,
                    'group_type' => 0
                ],
                [
                    'group_name' => 'Liabilities',
                    'under' => 0,
                    'group_type' => 0,
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
                ]
            ]);
        }
    }
}
