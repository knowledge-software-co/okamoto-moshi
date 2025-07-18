<?php

namespace App\Enums\Models\User;

use App\Traits\EnumTrait;

/**
 * RoleType
 * ユーザーの権限
 * Laravelのシステムを使用する立場別の観点での権限
 */
enum RoleType: string
{
    use EnumTrait;

    case SYSTEM_ADMIN = 'system admin';
    case ADMIN = 'admin';
    case DEVELOPER = 'developer';
    case MEMBER = 'member';

    public static function find(string $key): ?self
    {
        return match ($key) {
            'system admin' => self::SYSTEM_ADMIN,
            'admin' => self::ADMIN,
            'developer' => self::DEVELOPER,
            'member' => self::MEMBER,
            default     => null,
        };
    }

    public function label(): string
    {
        return match ($this) {
            self::SYSTEM_ADMIN  => 'システム管理者',
            self::ADMIN  => '運営者',
            self::DEVELOPER  => '開発者',
            self::MEMBER  => 'ユーザー',
        };
    }
}
