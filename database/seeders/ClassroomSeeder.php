<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClassroomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('classrooms')->insert([
            'name'=>"Laravel Course",
            'section'=>"GSG",
            'code'=>"1kn2f4v3",
            'subject'=>'course',
        ]);
    }
}
