<?php

use Illuminate\Database\Seeder;
use App\User as User;

class UsersTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();

        User::create([
          'name' => 'Default Admin User',
          'team' => 'Mannschaft 1',
          'slug' => 'mannschaft-1',
          'email' => 'admin@bar.com',
          'password' => bcrypt('test12')
        ]);
    }
}