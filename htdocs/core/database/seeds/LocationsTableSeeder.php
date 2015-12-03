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
        Location::create([
            'name' => 'Super Gym2',
            'slug' => 'super-gym-2',
            'country' => 'Deutschland',
            'city' => 'Super City',
            'street' => 'Superstraße S 1'
        ]);
        Location::create([
            'name' => 'Super Gym3',
            'slug' => 'super-gym-3',
            'country' => 'Deutschland',
            'city' => 'Super City',
            'street' => 'Superstraße S 1'
        ]);
        Location::create([
            'name' => 'Super Gym4',
            'slug' => 'super-gym-4',
            'country' => 'Deutschland',
            'city' => 'Super City',
            'street' => 'Superstraße S 1'
        ]);
        Location::create([
            'name' => 'Super Gym5',
            'slug' => 'super-gym-5',
            'country' => 'Deutschland',
            'city' => 'Super City',
            'street' => 'Superstraße S 1'
        ]);
        Location::create([
            'name' => 'Super Gym6',
            'slug' => 'super-gym-6',
            'country' => 'Deutschland',
            'city' => 'Super City',
            'street' => 'Superstraße S 1'
        ]);
        Location::create([
            'name' => 'Super Gym7',
            'slug' => 'super-gym-7',
            'country' => 'Deutschland',
            'city' => 'Super City',
            'street' => 'Superstraße S 1'
        ]);
    }
}