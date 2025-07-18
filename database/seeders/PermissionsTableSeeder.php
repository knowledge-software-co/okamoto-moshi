<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;
use Spatie\Permission\Models\Permission;

class PermissionsTableSeeder extends Seeder
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

        // 権限
        Permission::create(['company_id' => $company->id, 'name' => 'super_admin', 'description' => 'スーパー管理者']);
        Permission::create(['company_id' => $company->id, 'name' => 'admin', 'description' => '管理者']);
        Permission::create(['company_id' => $company->id, 'name' => 'user', 'description' => 'ユーザー']);
        Permission::create(['company_id' => $company->id, 'name' => 'guest', 'description' => 'ゲスト']);

        // 役職
        Permission::create(['company_id' => $company->id, 'name' => 'president', 'description' => '社長']);
        Permission::create(['company_id' => $company->id, 'name' => 'officer', 'description' => '役員']);
        Permission::create(['company_id' => $company->id, 'name' => 'manager', 'description' => '部長']);
        Permission::create(['company_id' => $company->id, 'name' => 'lerdar', 'description' => 'リーダー']);

        // 部署
        Permission::create(['company_id' => $company->id, 'name' => 'sales', 'description' => '営業']);
        Permission::create(['company_id' => $company->id, 'name' => 'development', 'description' => '開発']);
        Permission::create(['company_id' => $company->id, 'name' => 'management', 'description' => '管理']);
        Permission::create(['company_id' => $company->id, 'name' => 'general_affairs', 'description' => '総務']);
        Permission::create(['company_id' => $company->id, 'name' => 'accounting', 'description' => '経理']);
        Permission::create(['company_id' => $company->id, 'name' => 'human_resources', 'description' => '人事']);
        Permission::create(['company_id' => $company->id, 'name' => 'system', 'description' => 'システム']);
        Permission::create(['company_id' => $company->id, 'name' => 'planning', 'description' => '企画']);
        Permission::create(['company_id' => $company->id, 'name' => 'design', 'description' => 'デザイン']);
        Permission::create(['company_id' => $company->id, 'name' => 'marketing', 'description' => 'マーケティング']);
        Permission::create(['company_id' => $company->id, 'name' => 'public_relations', 'description' => '広報']);
        Permission::create(['company_id' => $company->id, 'name' => 'legal_affairs', 'description' => '法務']);

        // 事務所
        Permission::create(['company_id' => $company->id, 'name' => 'osaka_head_office', 'description' => '大阪本社']);
        Permission::create(['company_id' => $company->id, 'name' => 'tokyo_branch_office', 'description' => '東京支社']);
    }
}
