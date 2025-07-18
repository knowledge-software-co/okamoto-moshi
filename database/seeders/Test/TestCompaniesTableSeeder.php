<?php

namespace Database\Seeders\Test;

use Illuminate\Database\Seeder;
use App\Models\Company;

class TestCompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Company::factory(100)->create();
    }
}
