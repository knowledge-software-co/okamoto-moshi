<?php
/**
 * @copyright   Knowledge Software Co.,Ltd. All Rights Reserved.
 * @since       2023/02/14
 * @author      Kazuki Kimura <kazu-kimura@knsw.co.jp>
 */

namespace App\Observers;

use App\Models\User;
use App\Facades\Sequence;

class UserObserver
{
    public function creating(User $user)
    {
        $user->membership_number = Sequence::getNewUserNo($user->role, $user->company_id);
    }
}
