<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class HtmlContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('html_contents')->insert([
            [
                'key' => 'header',
                'content' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'footer',
                'content' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
