<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (file_exists(__DIR__.DIRECTORY_SEPARATOR.'db/menus.sql')) {
            DB::table('menus')->truncate();
            DB::unprepared(file_get_contents(__DIR__.DIRECTORY_SEPARATOR.'db/menus.sql'));
        }
    }
}
