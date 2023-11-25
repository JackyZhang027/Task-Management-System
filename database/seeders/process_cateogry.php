<?php

namespace Database\Seeders;

use App\Models\ProcessCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class process_cateogry extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProcessCategory::create([
            'name'	=> "Request Data",
    ]);
    }
}
