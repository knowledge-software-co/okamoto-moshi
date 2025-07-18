<?php

namespace App\Enums\Models\User;

use App\Traits\EnumTrait;

/**
 * Sex
 * ISO 5218に準拠する
 * https://ja.wikipedia.org/wiki/ISO_5218
 */
enum SexType: string
{
    use EnumTrait;

    case NOT_KNOWN = '0';
    case MALE = '1';
    case FEMALE = '2';
    case NOT_APPLICABLE = '9';

    public static function find(string $key): ?self
    {
        return match ($key) {
            '不明' => self::NOT_KNOWN,
            '男性' => self::MALE,
            '女性' => self::FEMALE,
            '男' => self::MALE,
            '女' => self::FEMALE,
            '適用不能' => self::NOT_APPLICABLE,
            default     => null,
        };
    }

    public function label(): string
    {
        return match ($this) {
            self::NOT_KNOWN  => '不明',
            self::MALE  => '男性',
            self::FEMALE => '女性',
            self::NOT_APPLICABLE => '適用不能',
        };
    }
}
