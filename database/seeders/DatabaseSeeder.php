<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\ProcessCategory::create([
            'name'	=> "Request Data"
        ]);

        \App\Models\ProcessCategoryState::create([
            'process_id' => '1',
            'state' => 'Not yet requested',
            'sequence_no' => '10',
        ]);
        \App\Models\ProcessCategoryState::create([
            'process_id' => '2',
            'state' => 'Data Requested',
            'sequence_no' => '20',
        ]);
    }
}
