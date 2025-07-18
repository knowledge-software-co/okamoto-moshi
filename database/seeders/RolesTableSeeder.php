<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;
use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @todo Change company default id
     * @return void
     */
    public function run()
    {
        $company = Company::where('name', '株式会社ナレッジソフトウェア')->first();

        // マスターデータとして登録
        Role::create(['company_id' => $company->id, 'name' => 'system admin', 'description' => 'システム管理者']);
        Role::create(['company_id' => $company->id, 'name' => 'admin', 'description' => '運営者']);
        Role::create(['company_id' => $company->id, 'name' => 'developer', 'description' => '開発者']);
        Role::create(['company_id' => $company->id, 'name' => 'member', 'description' => '会員']);
        // Role::create(['name' => 'grand master', 'description' => 'グランドマスター']);
        // Role::create(['name' => 'lab master', 'description' => 'ラボマスター']);
        // Role::create(['name' => 'staff', 'description' => 'スタッフ']);
        // Role::create(['name' => 'customer', 'description' => '無料会員']);
    }
}
