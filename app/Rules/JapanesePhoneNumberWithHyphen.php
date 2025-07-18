<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class JapanesePhoneNumberWithHyphen implements ValidationRule
{
    /**
     * 日本の電話番号バリデーションルール（ハイフンあり）
     * - ハイフンあり
     * - 0から始まる
     * - 市外局番1〜4桁 + 市内局番1〜4桁 + 加入者番号3〜4桁
     * - 全部で10桁〜11桁（ハイフン除く）
     */
    public function __construct()
    {
        //
    }

    /**
     * バリデーションルールを実行
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure  $fail
     * @return void
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // ハイフンが含まれているか確認
        if (substr_count($value, '-') !== 2) {
            $fail('電話番号はハイフン（-）を2つ含む必要があります。例: 03-1234-5678');
            return;
        }

        // 数字とハイフンのみであることを確認
        if (!preg_match('/^[0-9\-]+$/', $value)) {
            $fail('電話番号は数字とハイフン（-）のみを含む必要があります。');
            return;
        }

        // 0から始まることを確認
        if (!str_starts_with($value, '0')) {
            $fail('電話番号は0から始まる必要があります。');
            return;
        }

        // 電話番号をパートに分解
        $parts = explode('-', $value);
        if (count($parts) !== 3) {
            $fail('電話番号は「市外局番-市内局番-加入者番号」の形式である必要があります。');
            return;
        }

        // 市外局番（1〜4桁）
        $areaCode = $parts[0];
        if (strlen($areaCode) < 2 || strlen($areaCode) > 5 || !str_starts_with($areaCode, '0')) {
            $fail('市外局番は0で始まる2〜5桁の数字である必要があります。');
            return;
        }

        // 市内局番（1〜4桁）
        $cityCode = $parts[1];
        if (strlen($cityCode) < 1 || strlen($cityCode) > 4) {
            $fail('市内局番は1〜4桁の数字である必要があります。');
            return;
        }

        // 加入者番号（3〜4桁）
        $subscriberNumber = $parts[2];
        if (strlen($subscriberNumber) < 3 || strlen($subscriberNumber) > 4) {
            $fail('加入者番号は3〜4桁の数字である必要があります。');
            return;
        }

        // ハイフンを除いた数字部分のみの桁数を確認（10桁または11桁）
        $digitsOnly = $areaCode . $cityCode . $subscriberNumber;
        $length = strlen($digitsOnly);
        if ($length < 10 || $length > 11) {
            $fail('電話番号は（ハイフンを除いて）10桁または11桁である必要があります。');
            return;
        }

        // 電話番号の形式を確認（固定電話や携帯電話のパターン）
        $valid = false;

        // パターンチェック
        $patterns = [
            // 固定電話 (市外局番2桁)
            '/^0[1-9]\-\d{1,4}\-\d{3,4}$/',
            // 固定電話 (市外局番3桁)
            '/^0[1-9]\d\-\d{1,4}\-\d{3,4}$/',
            // 固定電話 (市外局番4桁)
            '/^0[1-9]\d{2}\-\d{1,4}\-\d{3,4}$/',
            // 携帯電話 (090/080/070)
            '/^0[7-9]0\-\d{4}\-\d{4}$/',
            // IP電話 (050)
            '/^050\-\d{4}\-\d{4}$/',
            // フリーダイヤル等 (0120/0800)
            '/^0(?:120|800)\-\d{3}\-\d{3}$/',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $value)) {
                $valid = true;
                break;
            }
        }

        if (!$valid) {
            $fail('有効な日本の電話番号形式ではありません。');
        }
    }
}
