<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Prefecture;

class PrefecturesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @todo Change company default id
     * @return void
     */
    public function run()
    {
        // マスターデータとして登録
        Prefecture::create(['id' => 1, 'prefecture_region_id' => 1, 'name' => '北海道', 'name_kana' => 'ホッカイドウ']);
        Prefecture::create(['id' => 2, 'prefecture_region_id' => 2, 'name' => '青森県', 'name_kana' => 'アオモリケン']);
        Prefecture::create(['id' => 3, 'prefecture_region_id' => 2, 'name' => '岩手県', 'name_kana' => 'イワテケン']);
        Prefecture::create(['id' => 4, 'prefecture_region_id' => 2, 'name' => '宮城県', 'name_kana' => 'ミヤギケン']);
        Prefecture::create(['id' => 5, 'prefecture_region_id' => 2, 'name' => '秋田県', 'name_kana' => 'アキタケン']);
        Prefecture::create(['id' => 6, 'prefecture_region_id' => 2, 'name' => '山形県', 'name_kana' => 'ヤマガタケン']);
        Prefecture::create(['id' => 7, 'prefecture_region_id' => 2, 'name' => '福島県', 'name_kana' => 'フクシマケン']);
        Prefecture::create(['id' => 8, 'prefecture_region_id' => 3, 'name' => '茨城県', 'name_kana' => 'イバラキケン']);
        Prefecture::create(['id' => 9, 'prefecture_region_id' => 3, 'name' => '栃木県', 'name_kana' => 'トチギケン']);
        Prefecture::create(['id' => 10, 'prefecture_region_id' => 3, 'name' => '群馬県', 'name_kana' => 'グンマケン']);
        Prefecture::create(['id' => 11, 'prefecture_region_id' => 3, 'name' => '埼玉県', 'name_kana' => 'サイタマケン']);
        Prefecture::create(['id' => 12, 'prefecture_region_id' => 3, 'name' => '千葉県', 'name_kana' => 'チバケン']);
        Prefecture::create(['id' => 13, 'prefecture_region_id' => 3, 'name' => '東京都', 'name_kana' => 'トウキョウト']);
        Prefecture::create(['id' => 14, 'prefecture_region_id' => 3, 'name' => '神奈川県', 'name_kana' => 'カナガワケン']);
        Prefecture::create(['id' => 15, 'prefecture_region_id' => 4, 'name' => '新潟県', 'name_kana' => 'ニイガタケン']);
        Prefecture::create(['id' => 16, 'prefecture_region_id' => 4, 'name' => '富山県', 'name_kana' => 'トヤマケン']);
        Prefecture::create(['id' => 17, 'prefecture_region_id' => 4, 'name' => '石川県', 'name_kana' => 'イシカワケン']);
        Prefecture::create(['id' => 18, 'prefecture_region_id' => 4, 'name' => '福井県', 'name_kana' => 'フクイケン']);
        Prefecture::create(['id' => 19, 'prefecture_region_id' => 4, 'name' => '山梨県', 'name_kana' => 'ヤマナシケン']);
        Prefecture::create(['id' => 20, 'prefecture_region_id' => 4, 'name' => '長野県', 'name_kana' => 'ナガノケン']);
        Prefecture::create(['id' => 21, 'prefecture_region_id' => 4, 'name' => '岐阜県', 'name_kana' => 'ギフケン']);
        Prefecture::create(['id' => 22, 'prefecture_region_id' => 4, 'name' => '静岡県', 'name_kana' => 'シズオカケン']);
        Prefecture::create(['id' => 23, 'prefecture_region_id' => 4, 'name' => '愛知県', 'name_kana' => 'アイチケン']);
        Prefecture::create(['id' => 24, 'prefecture_region_id' => 5, 'name' => '三重県', 'name_kana' => 'ミエケン']);
        Prefecture::create(['id' => 25, 'prefecture_region_id' => 5, 'name' => '滋賀県', 'name_kana' => 'シガケン']);
        Prefecture::create(['id' => 26, 'prefecture_region_id' => 5, 'name' => '京都府', 'name_kana' => 'キョウトフ']);
        Prefecture::create(['id' => 27, 'prefecture_region_id' => 5, 'name' => '大阪府', 'name_kana' => 'オオサカフ']);
        Prefecture::create(['id' => 28, 'prefecture_region_id' => 5, 'name' => '兵庫県', 'name_kana' => 'ヒョウゴケン']);
        Prefecture::create(['id' => 29, 'prefecture_region_id' => 5, 'name' => '奈良県', 'name_kana' => 'ナラケン']);
        Prefecture::create(['id' => 30, 'prefecture_region_id' => 5, 'name' => '和歌山県', 'name_kana' => 'ワカヤマケン']);
        Prefecture::create(['id' => 31, 'prefecture_region_id' => 6, 'name' => '鳥取県', 'name_kana' => 'トットリケン']);
        Prefecture::create(['id' => 32, 'prefecture_region_id' => 6, 'name' => '島根県', 'name_kana' => 'シマネケン']);
        Prefecture::create(['id' => 33, 'prefecture_region_id' => 6, 'name' => '岡山県', 'name_kana' => 'オカヤマケン']);
        Prefecture::create(['id' => 34, 'prefecture_region_id' => 6, 'name' => '広島県', 'name_kana' => 'ヒロシマケン']);
        Prefecture::create(['id' => 35, 'prefecture_region_id' => 6, 'name' => '山口県', 'name_kana' => 'ヤマグチケン']);
        Prefecture::create(['id' => 36, 'prefecture_region_id' => 7, 'name' => '徳島県', 'name_kana' => 'トクシマケン']);
        Prefecture::create(['id' => 37, 'prefecture_region_id' => 7, 'name' => '香川県', 'name_kana' => 'カガワケン']);
        Prefecture::create(['id' => 38, 'prefecture_region_id' => 7, 'name' => '愛媛県', 'name_kana' => 'エヒメケン']);
        Prefecture::create(['id' => 39, 'prefecture_region_id' => 7, 'name' => '高知県', 'name_kana' => 'コウチケン']);
        Prefecture::create(['id' => 40, 'prefecture_region_id' => 8, 'name' => '福岡県', 'name_kana' => 'フクオカケン']);
        Prefecture::create(['id' => 41, 'prefecture_region_id' => 8, 'name' => '佐賀県', 'name_kana' => 'サガケン']);
        Prefecture::create(['id' => 42, 'prefecture_region_id' => 8, 'name' => '長崎県', 'name_kana' => 'ナガサキケン']);
        Prefecture::create(['id' => 43, 'prefecture_region_id' => 8, 'name' => '熊本県', 'name_kana' => 'クマモトケン']);
        Prefecture::create(['id' => 44, 'prefecture_region_id' => 8, 'name' => '大分県', 'name_kana' => 'オオイタケン']);
        Prefecture::create(['id' => 45, 'prefecture_region_id' => 8, 'name' => '宮崎県', 'name_kana' => 'ミヤザキケン']);
        Prefecture::create(['id' => 46, 'prefecture_region_id' => 8, 'name' => '鹿児島県', 'name_kana' => 'カゴシマケン']);
        Prefecture::create(['id' => 47, 'prefecture_region_id' => 8, 'name' => '沖縄県', 'name_kana' => 'オキナワケン']);
    }
}
