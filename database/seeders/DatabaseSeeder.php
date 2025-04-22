<?php

namespace Database\Seeders;

use App\Models\{Company, Candidate};
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Company::factory()->create(['email' => 'company@mail.com']);
        Company::factory()->create(['email' => 'company2@mail.com']);

        Candidate::factory()->create(['email' => 'candidate@mail.com']);
        Candidate::factory()->create(['email' => 'candidate2@mail.com']);
    }
}
