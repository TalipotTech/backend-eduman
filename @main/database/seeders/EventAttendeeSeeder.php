<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventAttendeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (file_exists(__DIR__.DIRECTORY_SEPARATOR.'db/event_attendees.sql')) {
            DB::table('event_attendees')->truncate();
            DB::unprepared(file_get_contents(__DIR__.DIRECTORY_SEPARATOR.'db/event_attendees.sql'));
        }
    }
}