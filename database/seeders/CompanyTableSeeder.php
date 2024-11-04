<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Company;

class CompanyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $companies = [
            ['name' => 'PT SURYA MAKMUR KREASI', 'shorter' => 'SMK'],
            ['name' => 'PT SEHATI MULIA ABADI', 'shorter' => 'SMD'],
            ['name' => 'PT KARYA PUTRA NATUNA', 'shorter' => 'KPN'],
            ['name' => 'PT BEVI MARGI MULYA', 'shorter' => 'BMM'],
            ['name' => 'PT BIEMAN MAKMUR ABADI', 'shorter' => 'BMA'],
            ['name' => 'PT SETIA NEGARA MAJU', 'shorter' => 'SNM'],
        ];

        foreach ($companies as $companyData) {
            Company::create($companyData);
        }
    }
}
