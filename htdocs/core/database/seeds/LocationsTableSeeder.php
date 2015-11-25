<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Location as Location;

class LocationsTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('locations')->delete();

        Location::create([
            'name' => 'Stadthalle Stühlingen',
            'slug' => 'stadthalle-stuehlingen',
            'country' => 'Deutschland',
            'city' => 'Stühlingen',
            'street' => 'Straße X 1'
        ]);
        Location::create([
            'name' => 'Andere Sporthalle',
            'slug' => 'andere-sporthalle',
            'country' => 'Deutschland',
            'city' => 'Andere',
            'street' => 'Straße Y 2'
        ]);
        Location::create([
            'name' => 'Letzte Sporthalle',
            'slug' => 'letzte-sporthalle',
            'country' => 'Deutschland',
            'city' => 'Letzte',
            'street' => 'Straße Z 3'
        ]);
    }
}