<?php

namespace App\Listeners;

use Laravel\Cashier\Events\WebhookReceived;
use App\Models\User;

class StripeEventListener
{
    /**
     * 受け取ったStripe Webフックの処理
     */
    public function handle(WebhookReceived $event): void
    {
        if ($event->payload['type'] === 'invoice.payment_succeeded') {
            logger('invoice.payment_succeeded');

            // 受信イベントの処理…

            // ユーザーIDを取得
            $userId = $event->payload['data']['object']['customer'];

            // 対応するユーザーを検索
            $user = User::where('stripe_id', $userId)->first();

            if ($user) {
                // 支払い情報を記録
                $invoice = $event->payload['data']['object'];

                // 請求書の詳細を取得
                $amount = $invoice['amount_paid'];
                $currency = $invoice['currency'];
                $invoiceId = $invoice['id'];
                $status = $invoice['status'];

                // // 支払い情報を保存
                // \App\Models\Payment::create([
                //     'user_id' => $user->id,
                //     'invoice_id' => $invoiceId,
                //     'amount' => $amount,
                //     'currency' => $currency,
                //     'status' => $status,
                // ]);

                // // ユーザーに通知
                // $user->notify(new \App\Notifications\PaymentSucceeded($amount, $currency));

                logger("Payment recorded for user: {$user->id}, invoice: {$invoiceId}");
            }
        }
    }
}
