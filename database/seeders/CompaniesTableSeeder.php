<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Company;

class CompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @todo Change company default id
     * @return void
     */
    public function run()
    {
        // 運営者用の会社作成
        Company::create([
            'name' => '株式会社ナレッジソフトウェア',
            'representative' => '代表者名',
            'phone' => '06-6304-2481',
            'address' => '大阪府大阪市淀川区西中島７丁目８−３４ 第２スエヒロビル',
            'comment' => '運営会社のコメント',
            'advertising_payment_date' => now()->addMonth()->format('Y-m-d'),
            'point' => 0,
            'is_paid' => true,
        ]);
    }
}
