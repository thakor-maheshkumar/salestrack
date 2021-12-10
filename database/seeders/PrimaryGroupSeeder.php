<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PrimaryGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (\App\Models\Groups::count() == 0)
        {
            \App\Models\Groups::insert([
                [
                    'group_name' => 'Assets',
                    'under' => 0,
                    'group_type' => 0,
                    'is_affect' => 0,
                ],
                [
                    'group_name' => 'Liabilities',
                    'under' => 0,
                    'group_type' => 0,
                    'is_affect' => 0,
                ],
                [
                    'group_name' => 'Income',
                    'under' => 0,
                    'group_type' => 0,
                    'is_affect' => 0,
                ],
                [
                    'group_name' => 'Expenses',
                    'under' => 0,
                    'group_type' => 0,
                    'is_affect' => 0,
                ]
            ]);

            $primaryGroups = [
                [
                    'group_name' => 'Capital Account',
                    'under' => 1,
                    'group_type' => 2,
                    'is_affect' => 0,
                ],
                [
                    'group_name' => 'Current Assets',
                    'under' => 1,
                    'group_type' => 1,
                    'is_affect' => 0,
                ],
                [
                    'group_name' => 'Current Liabilities',
                    'under' => 1,
                    'group_type' => 2,
                    'is_affect' => 0,
                ],
                [
                    'group_name' => 'Loan',
                    'under' => 1,
                    'group_type' => 2,
                    'is_affect' => 0,
                ],
                [
                    'group_name' => 'Direct Expenses',
                    'under' => 1,
                    'group_type' => 4,
                    'is_affect' => 0,
                ],
                [
                    'group_name' => 'Direct Income',
                    'under' => 1,
                    'group_type' => 3,
                    'is_affect' => 0,
                ],
                [
                    'group_name' => 'Investments',
                    'under' => 1,
                    'group_type' => 1,
                    'is_affect' => 0,
                ],
                [
                    'group_name' => 'Misc. Expenses',
                    'under' => 1,
                    'group_type' => 1,
                    'is_affect' => 0,
                ],
                [
                    'group_name' => 'Purchase Accounts',
                    'under' => 1,
                    'group_type' => 4,
                    'is_affect' => 0,
                ],
                [
                    'group_name' => 'Sales Accounts',
                    'under' => 1,
                    'group_type' => 3,
                    'is_affect' => 0,
                ],
                [
                    'group_name' => 'Suspense A/c',
                    'under' => 1,
                    'group_type' => 2,
                    'is_affect' => 0,
                ]
            ];

            \DB::table('groups')->insert($primaryGroups);

            $subGroups = [
                [
                    'group_name' => 'Reserves & Surplus',
                    'under' => 2,
                    'group_type' => 5,
                    'is_affect' => 0,
                ],
                [
                    'group_name' => 'Cash-in-Hand',
                    'under' => 2,
                    'group_type' => 6,
                    'is_affect' => 0,
                ],
                [
                    'group_name' => 'Deposits',
                    'under' => 2,
                    'group_type' => 6,
                    'is_affect' => 0,
                ],
                [
                    'group_name' => 'Loans & Advances',
                    'under' => 2,
                    'group_type' => 6,
                    'is_affect' => 0,
                ],
                [
                    'group_name' => 'Sundry Debtors',
                    'under' => 2,
                    'group_type' => 6,
                    'is_affect' => 0,
                ],
                [
                    'group_name' => 'Stock-in-Hand',
                    'under' => 2,
                    'group_type' => 6,
                    'is_affect' => 0,
                ],
                [
                    'group_name' => 'Provisions',
                    'under' => 2,
                    'group_type' => 7,
                    'is_affect' => 0,
                ],
                [
                    'group_name' => 'Sundry Creditors',
                    'under' => 2,
                    'group_type' => 7,
                    'is_affect' => 0,
                ],
                [
                    'group_name' => 'Secured Loans',
                    'under' => 2,
                    'group_type' => 8,
                    'is_affect' => 0,
                ],
                [
                    'group_name' => 'Unsecured Loans',
                    'under' => 2,
                    'group_type' => 8,
                    'is_affect' => 0,
                ],
            ];

            \DB::table('groups')->insert($subGroups);
        }
    }
}
