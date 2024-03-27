<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

    class BuisnessDayTiming extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        $openingHours = ['09:00 AM', '09:00 AM', '09:00 AM', '09:00 AM', '09:00 AM', '09:00 AM', '09:00 AM'];
        $closingHours = ['05:00 PM', '05:00 PM', '05:00 PM', '05:00 PM', '05:00 PM', '05:00 PM', '05:00 PM'];
        $availability = [true, true, true, true, true, true, true];

        DB::table('buisness_timings')->insert([
            'day' => implode(',', $days),
            'opening_hours' => implode(',', $openingHours),
            'closing_hours' => implode(',', $closingHours),
            'availability' => implode(',', $availability),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
