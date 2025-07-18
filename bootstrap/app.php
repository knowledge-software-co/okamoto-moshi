<?php

use App\Http\Middleware\HandleAppearance;
use App\Http\Middleware\HandleInertiaRequests;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Sentry\Laravel\Integration;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            Route::middleware([
                'web',
                'auth',
                'verified',
                'role:system admin|admin',
                'precognitive',
            ])
                ->prefix('admin')
                ->namespace('App\Http\Controllers\Admin')
                ->as('admin.')
                ->group(base_path('routes/web-admin.php'))
            ;
        },
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->encryptCookies(except: ['appearance']);

        $middleware->web(append: [
            HandleAppearance::class,
            HandleInertiaRequests::class,
            AddLinkHeadersForPreloadedAssets::class,
        ]);

        // https://readouble.com/laravel/12.x/ja/requests.html
        // 信頼するプロキシの設定
        // TLS/SSL証明書を末端とするロードバランサーの背後でアプリケーションを実行している場合、
        // urlヘルパを使用するとアプリケーションがHTTPSリンクを生成しないことがあります。
        // 通常、これは、アプリケーションがポート80でロードバランサーからトラフィックを転送していて、
        // 安全なリンクを生成する必要があることを認識していないためです。
        $middleware->trustProxies(at: '*');
        $middleware->trustProxies(headers:
            Request::HEADER_X_FORWARDED_FOR |
            Request::HEADER_X_FORWARDED_HOST |
            Request::HEADER_X_FORWARDED_PORT |
            Request::HEADER_X_FORWARDED_PROTO |
            Request::HEADER_X_FORWARDED_AWS_ELB
        );

        $middleware->validateCsrfTokens(except: [
            'stripe/*',
        ]);

        $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        /*
         * 画面を放置するなどでCSRFトークンが切れてCSRF保護のエラーになるときに、セッション切れである旨のエラーを返す
         */
        $exceptions->render(function (HttpException $e) {
            // 302のままだと、PUTやDELETEのリクエストがエラーになるため、303に変更
            if ($e->getStatusCode() === 419) {
                return back(303)->withErrors(['セッションが切れました。画面を再読み込みしてください。']);
            }
            return back(303)->withErrors(['エラーが発生しました。']);
        });

        // Sentry
        Integration::handles($exceptions);
    })
    ->create();
