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
            'description' => 'Hier eine Beschreibung',
            'status' => 'free',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        DB::table('locations')->insert([
            'name' => 'Andere Sporthalle',
            'slug' => 'andere-sporthalle',
            'description' => 'Hier noch eine weitere Beschreibung',
            'status' => 'partial',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        DB::table('locations')->insert([
            'name' => 'Letzte Sporthalle',
            'slug' => 'letzte-sporthalle',
            'description' => 'Lorem ipsum dolor sit amet.',
            'status' => 'occupied',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}