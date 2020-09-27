<?php

namespace Tests\Browser;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class UsersCanCreateStatusesTest extends DuskTestCase
{
    use DatabaseMigrations;
    /**
     * A Dusk test example.
     *
     * @test
     * @throws \Throwable
     */
    public function users_can_create_statuses()
    {
        $user = factory(User::class)->create();

        $this->browse(function (Browser $browser) use ($user) {

            $browser->loginAs($user)
                    ->visit('/')
                    ->type('body', 'Mi primer status')
                    ->press('#create-status')
                    ->screenshot('create-status')
                    ->assertSee('Mi primer status');
        });
    }
}
