<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        $role = [
            'local',
            'testing',
            'development',
            'staging',
            'production', // MEMO: 開発中のため、本番環境にも適応
        ];

        if (app()->environment($role)) {
            $this->beforeTestSeeders();
        }

        $this->masterSeeders();

        if (app()->environment($role)) {
            $this->afterTestSeeders();
        }
    }

    /**
     * テストデータのSeeder
     */
    private function beforeTestSeeders(): void
    {
        // $this->call(Test\TestServicePlansTableSeeder::class);
    }

    /**
     * マスタデータのSeeder
     */
    private function masterSeeders(): void
    {
        $this->call(PrefectureRegionsTableSeeder::class);
        $this->call(PrefecturesTableSeeder::class);
        $this->call(CompaniesTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(PermissionsTableSeeder::class);

        $this->call(UsersTableSeeder::class);
    }

    /**
     * テストデータのSeeder
     */
    private function afterTestSeeders(): void
    {
        $this->call(Test\TestCompaniesTableSeeder::class);

        $this->call(Test\TestUsersTableSeeder::class);
    }
}
