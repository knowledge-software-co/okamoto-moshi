<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Storage;

abstract class TestCase extends BaseTestCase
{
    /**
     * デフォルトのシーダーが各テストの前に実行するかを示す
     *
     * @var bool
     */
    protected $seed = true;

    protected function setUp(): void
    {
        parent::setUp();

        /**
         * テストの前に実行する処理
         */

        // NOTE: 疑似本番環境などのローカル環境以外でテスト時は
        //       トラブルを避けるため強制的に全てモックする
        //       (現在当プロジェクトではローカル環境とCI環境でのみテストを行っているためコメントアウト)
        // $this->mockAll();
    }

    // protected function tearDown(): void
    // {
    //     parent::tearDown();

    //     /**
    //      * テストの後に実行する処理
    //      */
    // }

    /**
     * テスト時は強制的に全てモックする
     */
    protected function mockAll()
    {
        // モックの設定
        Http::fake();
        Http::preventStrayRequests();
        Storage::fake();
        Notification::fake();
        Queue::fake();

        // Note: note Event::fake()を呼び出したあとは、イベントリスナは実行されなくなります。
        // そのため例えば、モデルのcreatingイベントでUUIDを生成するなど、
        // イベントに結びつけたモデルファクトリの使用をテストする場合は、
        // ファクトリを呼び出した後に、Event::fake()を呼び出す必要があります。
        // Event::fake();

        Bus::fake();
        Mail::fake();

        // $this->mock('App\Services\Api\Line\MessagingApiApiService');
        // $this->mock('App\Services\Api\Line\LineApiService');
        // $this->mock('App\Services\Api\Line\LineWebhookApiService');
    }
}
