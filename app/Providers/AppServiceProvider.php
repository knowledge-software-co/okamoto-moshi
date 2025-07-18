<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;
use Laravel\Cashier\Cashier;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Eloquent「厳格モード」の有効化
        // NOTE: 下記有効にするとプロフィール画像のアップデートができなくなるので無効にする
        // Model::shouldBeStrict(! $this->app->isProduction());

        // Preventing Lazy Loading (N+1 checker)
        Model::preventLazyLoading(! $this->app->isProduction());

        // NOTE: プロダクション環境のみに適応するため、ここで登録する
        // if ($this->app->environment('production')) {
        //     URL::forceScheme('https');
        // }

        if (request()->isSecure()) {
            URL::forceScheme('https');
        }

        // NOTE: Cashierの税金計算を上書きする
        // Cashier::calculateTaxes();

        // // stripeのAPIBASEが指定されていればここでセットする
        // if (config('services.stripe.apiBase') !== NULL) {
        //     \Stripe\Stripe::$apiBase = config('services.stripe.apiBase');
        //     \Laravel\Cashier\Cashier::$apiBaseUrl = config('services.stripe.apiBase');
        // }

        // // NOTE: dedoc/scramble 用
        // Scramble::routes(function (Route $route) {
        //     logger($route->uri);
        //     return Str::startsWith($route->uri, 'api/');
        // });

        // NOTE: AWS Beanstalk ワーカー環境用
        /** @phpstan-ignore-next-line  */
        if (env('REGISTER_WORKER_ROUTES', true)) {
            URL::forceRootUrl(config('app.url'));
        }
    }
}
