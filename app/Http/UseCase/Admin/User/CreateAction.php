<?php

namespace App\Http\UseCase\Admin\User;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
// use App\Models\User;
// use App\Models\Item;
// use App\Models\ItemUsageHistory;
use App\Enums\Models\User\SexType;
use App\Enums\BankAccountHolderTypeCode;
use App\Enums\Models\User\RoleType;
use Inertia\Inertia;

class CreateAction
{
    public function __invoke(Request $request)
    {
        try {
            // 性別Enum取得
            $sexOptions = collect(SexType::cases())->map(
                fn($item) => [
                    'value' => $item->value,
                    'name' => $item->label(),
                ]
            )->toArray();

            // // 承認状況Enum取得
            // $isApprovedOptions = collect(IsApproved::cases())->map(
            //     fn($item) => [
            //         'value' => $item->value,
            //         'name' => $item->label(),
            //     ]
            // )->toArray();

            // 口座種別Enum取得
            $bankAccountHolderTypeCodeOptions = collect(BankAccountHolderTypeCode::cases())->map(
                fn($item) => [
                    'value' => $item->value,
                    'name' => $item->label(),
                ]
            )->toArray();

            $userRoles = RoleType::toArray();
            $userRoles = Arr::except($userRoles, ['system admin']);
        } catch (\Throwable $e) {
            logs()->error($e);
            return redirect()->back()->withErrors(['message' => 'カテゴリーの取得に失敗しました。']);
        }

        return Inertia::render('Admin/Users/Create', compact(
            'sexOptions',
            // 'isApprovedOptions',
            'bankAccountHolderTypeCodeOptions',
            'userRoles',
        ));
    }
}
