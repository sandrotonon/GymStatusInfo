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
            'date' => date('Y-m-d', strtotime('2016-01-01')),
            'time' => date('H:i:s', strtotime('4:00 PM')),
            'available' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
