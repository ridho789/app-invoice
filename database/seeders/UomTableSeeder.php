<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Uom;

class UomTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $uoms = [
            ['name' => 'BDL'],
            ['name' => 'CASE'],
            ['name' => 'CSE'],
            ['name' => 'CTN'],
            ['name' => 'PKG'],
            ['name' => 'PLT'],
        ];

        foreach ($uoms as $uom) {
            Uom::create($uom);
        }
    }
}
