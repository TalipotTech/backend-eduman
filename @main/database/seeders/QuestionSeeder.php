<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (file_exists(__DIR__.DIRECTORY_SEPARATOR.'db/questions.sql')) {
            DB::table('questions')->truncate();
            DB::unprepared(file_get_contents(__DIR__.DIRECTORY_SEPARATOR.'db/questions.sql'));
        }
    }
}
