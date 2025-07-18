<?php

namespace App\Http\UseCase\Admin\User;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Item;
use App\Models\ItemUsageHistory;
use App\Enums\Sex;
use App\Enums\BankAccountHolderTypeCode;
use Inertia\Inertia;

class ShowAction
{
    public function __invoke(Request $request, User $user)
    {
        // try {

        // } catch (\Throwable $e) {
        //     logs()->error($e);
        //     return redirect()->back()->withErrors(['message' => 'ユーザー情報の取得に失敗しました。']);
        // }

        return Inertia::render('admin/users/Show', [
            'user' => $user,
        ]);
    }
}
