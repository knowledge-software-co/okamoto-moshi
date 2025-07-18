<?php

namespace App\Http\UseCase\Admin\User;

// use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\JsonResponse;
// use App\Models\User;
use App\Models\BankAccountInformation;
use App\Models\Item;
use App\Models\ItemUsageHistory;
use App\Enums\Models\User\RoleType;
use App\Mail\Admin\UserStored;
use App\Http\Requests\Admin\User\UserStoreRequest;
// use Exception;

class StoreAction
{
    // public function __invoke(?User $user, array $request)
    public function __invoke(UserStoreRequest $request)
    {
        try {
            $user = $request->makeUser();

            // バグを防ぐために簡易的にアサーションを書く
            assert($user->exists);

            DB::transaction(function () use (&$user) {
                $user->save();

                $user->assignRole($user->role);

                // issue #60 Stripe顧客作成機能の追加 会員登録時のみ
                if ($user->role === 'member') {
                    $user->createAsStripeCustomer(['preferred_locales' => ['ja']]);
                }

                // 会社情報登録
                // $this->companyRepository->create($request);
                // Company::create($request);

                // // 銀行口座情報登録
                // // $this->bankAccountInformationRepository->create($request);
                // BankAccountInformation::create([
                //     ...$request->validated(),
                //     'user_id' => $user->id,
                // ]);

                // // 紹介コード登録
                // UserReferralCode::create([
                //     'user_id' => $user->id,
                //     'referral_code' => Str::random(10),
                // ]);

                // // 必須機能のItem全てをUserに紐づける
                // $item = Item::fixed()->get();
                // $item->each(function ($item) use ($user) {
                //     ItemUsageHistory::create([
                //         'user_id' => $user->id,
                //         'item_id' => $item->id,
                //         'start_date' => now(),
                //         // 'end_date' => now()->addYear(),
                //     ]);
                // });
            });

            // Mail::to($user->email)->send(new UserStored($user));

            return redirect()->route('admin.users.index')
                ->with('message', 'ユーザーを追加しました。');
        } catch (\Throwable $e) {
            logs()->error($e);
            // 捕まえた例外はスタックトレースに積む
            // throw new TooManyRequestsHttpException(null, $e->getMessage(), $e);
            return $request->wantsJson()
                ? new JsonResponse('', 500)
                : back()->withErrors(['message' => ' ユーザーの追加に失敗しました。']);
        }
    }
}
