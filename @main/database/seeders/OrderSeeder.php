<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (file_exists(__DIR__.DIRECTORY_SEPARATOR.'db/orders.sql')) {
            DB::unprepared(file_get_contents(__DIR__.DIRECTORY_SEPARATOR.'db/orders.sql'));
        }
    }
}
