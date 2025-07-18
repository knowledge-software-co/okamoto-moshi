<?php

namespace Tests\Browser\Pages\Guest;

use Tests\Browser\Pages\Page;
use Laravel\Dusk\Browser;

class HomePage extends Page
{
    /**
     * Get the URL for the page.
     */
    public function url()
    {
        return '/';
    }

    /**
     * Assert that the browser is on the page.
     */
    public function assert(Browser $browser): void
    {
        $browser
            ->waitFor('@app')
            ->assertSee('ログイン')
        ;
    }

    /**
     * Get the element shortcuts for the page.
     */
    public function elements(): array
    {
        return [
            '@app' => '#app',
            '@element' => '#selector',
        ];
    }
}
