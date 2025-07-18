<?php

namespace App\Enums\Models\User;

use App\Traits\EnumTrait;

enum IsApprovedType: string
{
    use EnumTrait;

    case UNCONFIRMED = 'unconfirmed';
    case APPROVED = 'approved';
    case REJECT = 'reject';

    public function label(): string
    {
        return match ($this) {
            self::UNCONFIRMED => '未確認',
            self::APPROVED => '承認',
            self::REJECT => '却下',
        };
    }
}
