<?php

/**
 * @copyright   Knowledge Software Co.,Ltd. All Rights Reserved.
 * @since       2022/10/03
 * @author      Kazuki Kimura <kazu-kimura@knsw.co.jp>
 */

namespace App\Enums;

use App\Traits\EnumTrait;

enum BankAccountHolderTypeCode: string
{
    use EnumTrait;

    case CurrentAccount = '1';
    case OrdinaryDeposit = '2';

    public function label(): string
    {
        return match ($this) {
            self::CurrentAccount  => '当座預金',
            self::OrdinaryDeposit  => '普通預金',
        };
    }
}
