<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
// use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Profile;
use App\Enums\Models\User\RoleType;
use App\Enums\Models\User\SexType;
use App\Enums\Models\User\IsApprovedType;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @todo Change company default id
     * @return void
     */
    public function run()
    {
        // システム管理者のプロフィールを作成
        $profile = Profile::create([
            // 'profilable_id' => $systemAdmin->id,
            // 'profilable_type' => User::class,
            'last_name' => '木村',
            'first_name' => '一樹',
            'last_name_kana' => 'キムラ',
            'first_name_kana' => 'カズキ',
            'sex_code' => SexType::MALE,
            'created_by' => 1,
        ]);

        // システム管理者ユーザーを作成
        $systemAdmin = User::create([
            // 'membership_number' => \Sequence::getNewUserNo('system admin'),
            'company_id' => 1,
            'profile_id' => $profile->id,
            // 'name' => '木村 一樹',
            'email' => 'kidsc0me@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2y$12$MwSq7i5VsGUPf25Xq6dI1e0LlKR5kZpIF9wfGMV6Mz7S.t9ph2qxC',
            'role' => RoleType::SYSTEM_ADMIN->value,
            'is_approved' => IsApprovedType::APPROVED,
            'created_by' => 1,
        ]);

        // 権限を割り当て
        $systemAdmin->assignRole('system admin');

        // // 開発者のプロフィールを作成
        // $profile = Profile::create([
        //     // 'profilable_id' => $developer->id,
        //     // 'profilable_type' => User::class,
        //     'last_name' => '木村',
        //     'first_name' => '一樹',
        //     'last_name_kana' => 'キムラ',
        //     'first_name_kana' => 'カズキ',
        //     'sex_code' => SexType::MALE,
        //     'created_by' => 1,
        // ]);

        // // 開発者ユーザーを作成
        // $developer = User::create([
        //     // 'membership_number' => \Sequence::getNewUserNo('developer'),
        //     'company_id' => 1,
        //     'profile_id' => $profile->id,
        //     // 'name' => '木村 一樹',
        //     'email' => 'kidsc0me+developer@gmail.com',
        //     'email_verified_at' => now(),
        //     'password' => '$2y$12$MwSq7i5VsGUPf25Xq6dI1e0LlKR5kZpIF9wfGMV6Mz7S.t9ph2qxC',
        //     'role' => RoleType::DEVELOPER->value,
        //     'is_approved' => IsApprovedType::APPROVED,
        //     'created_by' => 1,
        // ]);

        // // 権限を割り当て
        // $developer->assignRole('developer');
    }
}
