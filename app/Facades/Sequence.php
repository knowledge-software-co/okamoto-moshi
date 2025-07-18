<?php
/**
 * @copyright   Knowledge Software Co.,Ltd. All Rights Reserved.
 * @since       2023/02/14
 * @author      Kazuki Kimura <kazu-kimura@knsw.co.jp>
 */

namespace App\Facades;

use Illuminate\Support\Facades\Facade;
use App\Services\SequenceService;

class Sequence extends Facade
{
    protected static function getFacadeAccessor()
    {
        return SequenceService::class;
    }
}
