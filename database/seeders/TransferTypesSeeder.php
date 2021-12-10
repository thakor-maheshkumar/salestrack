<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TransferTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (\App\Models\TransferType::count() == 0)
        {
            \App\Models\TransferType::insert([
                [
                    'name' => 'Stock'
                ],
                [
                    'name' => 'Purchase'
                ],
                [
                    'name' => 'Sales'
                ]
            ]);
        }
    }
}
