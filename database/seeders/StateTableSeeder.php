<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class StateTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $states = [
            ['name' => 'HOLD'],
            ['name' => 'CONTINUE'],
        ];

        foreach ($states as $state) {
            State::create($state);
        }
    }
}
