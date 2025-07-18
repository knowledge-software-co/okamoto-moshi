<?php

use Laravel\Dusk\Browser;
use Tests\Browser\Pages\Guest\LoginPage;
use App\Models\User;

test('test page transition at login for admin', function () {
    if (config('ngrok.free_plan')) {
        $this->pressVisitSiteButtonForNgrok();
    }

    $authUser = User::where('role', 'admin')->first();

    $this->browse(function (Browser $browser) use ($authUser) {
        $browser
            ->visit(new LoginPage)
            ->type('@email', $authUser->email)
            ->type('@password', 'password')
            ->press('@submit')
            ->waitForLink('ダッシュボード', 60)
            ->assertPathIs('/admin');
    });
});
