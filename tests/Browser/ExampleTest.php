<?php

use Laravel\Dusk\Browser;

test('basic example', function () {
    if (config('ngrok.free_plan')) {
        $this->pressVisitSiteButtonForNgrok();
    }

    $this->browse(function (Browser $browser) {
        $browser->visit('/')
                ->waitForText('Laravel');
    });
});
