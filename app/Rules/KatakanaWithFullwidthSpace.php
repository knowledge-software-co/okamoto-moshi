<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class KatakanaWithFullwidthSpace implements ValidationRule
{
    /**
     * カタカナと全角スペースのみを許可するバリデーションルール
     * - カタカナ（全角）
     * - 全角スペース
     * - 少なくとも1文字以上のカタカナを含む
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
        // 文字列が空の場合はバリデーションを通過（required等の他のルールと組み合わせて使用）
        if (empty($value)) {
            return;
        }

        // 文字列がカタカナと全角スペースのみで構成されているか確認
        if (!preg_match('/\A[ァ-ヶー 　]+\z/mu', $value)) {
            $fail('カタカナと全角スペースのみを入力してください。');
            return;
        }
    }
}
