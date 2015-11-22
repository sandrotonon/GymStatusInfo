<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class LocationsTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('locations')->delete();

        DB::table('locations')->insert([
            'name' => 'Stadthalle Stühlingen',
            'slug' => 'stadthalle-stuehlingen',
            'country' => 'Deutschland',
            'city' => 'Stühlingen',
            'street' => 'Straße X 1',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        DB::table('locations')->insert([
            'name' => 'Andere Sporthalle',
            'slug' => 'andere-sporthalle',
            'country' => 'Deutschland',
            'city' => 'Andere',
            'street' => 'Straße Y 2',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        DB::table('locations')->insert([
            'name' => 'Letzte Sporthalle',
            'slug' => 'letzte-sporthalle',
            'country' => 'Deutschland',
            'city' => 'Letzte',
            'street' => 'Straße Z 3',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}