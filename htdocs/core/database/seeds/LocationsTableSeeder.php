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
        Location::create([
            'name' => 'Und noch eine Sporthalle',
            'slug' => 'und-noch-eine-sporthalle',
            'country' => 'Deutschland',
            'city' => 'Stadt',
            'street' => 'Straße Z 4'
        ]);
        Location::create([
            'name' => 'Star Trek Halle',
            'slug' => 'star-trek-halle',
            'country' => 'Space',
            'city' => 'None',
            'street' => 'Flur 1337'
        ]);
        Location::create([
            'name' => 'Super Gym',
            'slug' => 'super-gym',
            'country' => 'Deutschland',
            'city' => 'Super City',
            'street' => 'Superstraße S 1'
        ]);
    }
}