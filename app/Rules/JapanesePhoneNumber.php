<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class JapanesePhoneNumber implements ValidationRule
{
    /**
     * 日本の電話番号バリデーションルール
     * - ハイフンなし
     * - 0から始まる
     * - 市外局番1〜4桁 + 市内局番1〜4桁 + 加入者番号3〜4桁
     * - 全部で10桁〜11桁
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
        // 数字のみであることを確認
        if (!preg_match('/^\d+$/', $value)) {
            $fail('電話番号は数字のみを含む必要があります。');
            return;
        }

        // 0から始まることを確認
        if (!str_starts_with($value, '0')) {
            $fail('電話番号は0から始まる必要があります。');
            return;
        }

        // 桁数チェック (10桁または11桁)
        $length = strlen($value);
        if ($length < 10 || $length > 11) {
            $fail('電話番号は10桁または11桁である必要があります。');
            return;
        }

        // 電話番号の形式を確認（固定電話や携帯電話のパターン）
        $valid = false;

        // 固定電話: 0A-BCDE-FGHI形式 (A!=0, 10桁または11桁)
        // 携帯電話: 0AB-CDEF-GHIJ形式 (11桁)
        // IP電話: 050-CDEF-GHIJ形式 (11桁)
        // フリーダイヤル等: 0120-DEF-GHI形式 (10桁)

        // 一般的な固定電話・携帯電話・IP電話のパターン
        $patterns = [
            // 固定電話 (市外局番2桁 + 市内局番2桁 + 加入者番号6桁 = 10桁)
            '/^0[1-9]\d{8}$/',
            // 固定電話 (市外局番3桁 + 市内局番1桁 + 加入者番号6桁 = 10桁)
            '/^0[1-9]\d{1}\d{7}$/',
            // 固定電話 (市外局番4桁 + 市内局番1桁 + 加入者番号5桁 = 10桁)
            '/^0[1-9]\d{2}\d{6}$/',
            // 携帯電話 (090/080/070 + 8桁 = 11桁)
            '/^0[7-9]0\d{8}$/',
            // IP電話 (050 + 8桁 = 11桁)
            '/^050\d{8}$/',
            // フリーダイヤル等 (0120/0800 + 6桁 = 10桁)
            '/^0(120|800)\d{6}$/',
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
