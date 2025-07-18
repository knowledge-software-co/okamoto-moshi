<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Image64 implements ValidationRule
{
    /**
     * __construct
     */
    public function __construct(private array $parameters)
    {
        //
    }

    /**
     * バリデーションルールの実行
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $type = explode('/', explode(':', substr($value, 0, strpos($value, ';')))[1])[1];

        // NOTE: in_arrayで大文字・小文字を区別しない
        if (!in_array(strtolower($type), array_map('strtolower', $this->parameters))) {
            $allowedTypes = implode(', ', $this->parameters);
            $fail(":attribute のフォーマットは次のいずれかである必要があります: $allowedTypes");
        }
    }
}
