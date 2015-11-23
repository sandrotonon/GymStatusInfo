<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

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

        DB::table('timeslots')->insert([
            'user_id' => null,
            'location_id' => '1',
            'date' => date('Y-m-d', strtotime('2016-01-01')),
            'time' => date('H:i:s', strtotime('4:00 PM')),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        DB::table('timeslots')->insert([
            'user_id' => '1',
            'location_id' => '1',
            'date' => date('Y-m-d', strtotime('2016-01-01')),
            'time' => date('H:i:s', strtotime('4:00 PM')),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        DB::table('timeslots')->insert([
            'user_id' => null,
            'location_id' => '1',
            'date' => date('Y-m-d', strtotime('2016-01-01')),
            'time' => date('H:i:s', strtotime('7:00 PM')),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        DB::table('timeslots')->insert([
            'user_id' => null,
            'location_id' => '1',
            'date' => date('Y-m-d', strtotime('2016-01-01')),
            'time' => date('H:i:s', strtotime('4:00 PM')),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        DB::table('timeslots')->insert([
            'user_id' => '1',
            'location_id' => '2',
            'date' => date('Y-m-d', strtotime('2016-01-01')),
            'time' => date('H:i:s', strtotime('5:00 PM')),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        DB::table('timeslots')->insert([
            'user_id' => '1',
            'location_id' => '3',
            'date' => date('Y-m-d', strtotime('2016-01-08')),
            'time' => date('H:i:s', strtotime('4:00 PM')),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
