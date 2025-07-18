<?php

namespace Database\Seeders\Test;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Enums\Models\User\RoleType;
use App\Enums\Models\User\SexType;

class TestUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 運営者
        $admin = User::factory()
            ->admin()
            ->create([
                'email' => 'admin@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'role' => RoleType::ADMIN->value,
                'created_by' => 1,
            ]);

        // 開発者
        $developer = User::factory()
            ->developer()
            ->create([
                'email' => 'developer@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'role' => RoleType::DEVELOPER->value,
            ]);

        // 会員
        $member = User::factory()
            ->member()
            ->create([
                'email' => 'member@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'role' => RoleType::MEMBER->value,
            ]);

        /**
         * ランダムアカウント
         */

        // Admin user - 自動的にプロフィールも作成される
        User::factory(10)
            ->admin()
            ->create();

        // Developer user - 自動的にプロフィールも作成される
        User::factory(3)
            ->developer()
            ->create();

        // Member user - 自動的にプロフィールも作成される
        User::factory(20)
            ->member()
            ->create();
    }
}
