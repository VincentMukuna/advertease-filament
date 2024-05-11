<?php

namespace Database\Seeders;

use App\Models\Billboard;
use Illuminate\Database\Seeder;

class BillboardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Billboard::factory()->count(5)->create();
    }
}
