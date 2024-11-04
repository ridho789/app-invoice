<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Origin;

class OriginsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $origins = [
            ['name' => 'BTH-SIN'],
            ['name' => 'BTH-JKT'],
            ['name' => 'SIN-BTH'],
            ['name' => 'SIN-JKT'],
        ];

        foreach ($origins as $origin) {
            Origin::create($origin);
        }
    }
}
