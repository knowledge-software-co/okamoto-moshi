<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\PrefectureRegion;
use Spatie\Permission\Models\Role;

class PrefectureRegionsTableSeeder extends Seeder
{
    private const PREFECTURE_REGIONS = [
        ['name' => '北海道地方', 'name_kana' => 'ホッカイドウ'],
        ['name' => '東北地方', 'name_kana' => 'トウホクチホウ'],
        ['name' => '関東地方', 'name_kana' => 'カントウチホウ'],
        ['name' => '中部地方', 'name_kana' => 'チュウブチホウ'],
        ['name' => '近畿地方', 'name_kana' => 'キンキチホウ'],
        ['name' => '中国地方', 'name_kana' => 'チュウゴクチホウ'],
        ['name' => '四国地方', 'name_kana' => 'シコクチホウ'],
        ['name' => '九州地方', 'name_kana' => 'キュウシュウチホウ'],
    ];
    /**
     * Run the database seeds.
     *
     * @todo Change company default id
     * @return void
     */
    public function run()
    {
        // マスターデータとして登録
        PrefectureRegion::upsert(self::PREFECTURE_REGIONS, [
            'name',
            'name_kana',
        ]);
    }
}
