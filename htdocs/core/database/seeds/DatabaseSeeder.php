<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(UsersTableSeeder::class);
        $this->call(LocationsTableSeeder::class);
        $this->call(TimeslotsTableSeeder::class);
        
        $this->call(RolesAndUsersTableSeeder::class);

        Model::reguard();
    }
}
