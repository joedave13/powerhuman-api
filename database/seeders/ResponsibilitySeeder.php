<?php

namespace Database\Seeders;

use App\Models\Responsibility;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ResponsibilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Responsibility::factory()
            ->count(5)
            ->create();
    }
}
