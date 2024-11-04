<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Administrator',
                'email' => 'admin@gmail.com',
                'level' => '0',
                'password' => bcrypt('admin_123'),
            ],
            [
                'name' => 'Billing',
                'email' => 'billing@gmail.com',
                'level' => '1',
                'password' => bcrypt('billing_123'),
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }

}
