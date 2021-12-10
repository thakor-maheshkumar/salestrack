<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(CountriesTableSeeder::class);
        $this->call(StatesTableSeeder::class);
        //$this->call(PermissionScreensSeeder::class);
        $this->call(RolesSeeder::class);
        $this->call(UsersSeeder::class);
        $this->call(ModuleSeeder::class);
        $this->call(PrimaryGroupSeeder::class);
        $this->call(UnitDataSeeder::class);
        //$this->call(CustomerPrimaryGroupSeeder::class);
        //$this->call(SupplierPrimaryGroupSeeder::class);
        $this->call(TransferTypesSeeder::class);
        $this->call(PermissionScreens2Seeder::class);
        $this->call(CityTableSeeder::class);
    }
}
