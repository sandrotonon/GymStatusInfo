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
          'name' => 'Test Admin User',
          'team' => 'Mannschaft 1',
          'slug' => 'mannschaft-1',
          'email' => 'admin@bar.com',
          'password' => bcrypt('test12')
        ]);

        User::create([
          'name' => 'Test Mannschaftsführer User',
          'team' => 'Mannschaft 2',
          'slug' => 'mannschaft-2',
          'email' => 'teamer@bar.com',
          'password' => bcrypt('test12')
        ]);

        User::create([
          'name' => 'Test Mannschaftsführer User Zwei',
          'team' => 'Jugend',
          'slug' => 'jugend',
          'email' => 'teamer2@bar.com',
          'password' => bcrypt('test12')
        ]);
    }
}