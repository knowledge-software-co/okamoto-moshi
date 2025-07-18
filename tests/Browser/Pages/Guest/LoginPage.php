<?php

namespace Tests\Browser\Pages\Guest;

use Tests\Browser\Pages\Page;
use Laravel\Dusk\Browser;

class LoginPage extends Page
{
    /**
     * Get the URL for the page.
     */
    public function url(): string
    {
        return '/login';
    }

    /**
     * Assert that the browser is on the page.
     */
    public function assert(Browser $browser): void
    {
        $browser
            ->waitFor('@app')
            // ->assertTitleContains('ログイン') // i18nVueが有効になる前に確認するとエラーになるのでコメントアウト
            ->assertPresent('#email')
            ->assertPresent('#password')
            ->assertButtonEnabled('button[type=submit]')
        ;
    }

    /**
     * Get the element shortcuts for the page.
     */
    public function elements(): array
    {
        return [
            '@app' => '#app',
            '@email' => '#email',
            '@password' => '#password',
            '@submit' => 'button[type=submit]',
        ];
    }
}
