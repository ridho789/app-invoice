<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Desc;

class DescTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $descs = [
            ['name' => 'BL'],
            ['name' => 'INSURANCE'],
            ['name' => 'PERMIT'],
            ['name' => 'TRANSPORT'],
        ];

        foreach ($descs as $desc) {
            Desc::create($desc);
        }
    }
}
