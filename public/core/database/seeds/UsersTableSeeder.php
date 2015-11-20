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
          'name' => 'Test User',
          'team' => 'Mannschaft 1',
          'email' => 'foo@bar.com',
          'password' => bcrypt('test12')
        ]);
    }
}