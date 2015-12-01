<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Timeslot as Timeslot;

class TimeslotsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('timeslots')->delete();

        /*Timeslot::create([
            'user_id' => '1',
            'location_id' => '1',
            'date' => date('Y-m-d', strtotime('2016-01-01')),
            'time' => date('H:i:s', strtotime('4:00 PM')),
        ]);
        Timeslot::create([
            'user_id' => '1',
            'location_id' => '1',
            'date' => date('Y-m-d', strtotime('2016-01-01')),
            'time' => date('H:i:s', strtotime('4:00 PM')),
        ]);
        Timeslot::create([
            'user_id' => '1',
            'location_id' => '1',
            'date' => date('Y-m-d', strtotime('2016-01-08')),
            'time' => date('H:i:s', strtotime('7:00 PM')),
        ]); */  
    }
}
