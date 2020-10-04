<?php

namespace Tests\Browser;

use App\User;
use App\Models\Status;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UsersCanLikeStatusesTest extends DuskTestCase
{
    use DatabaseMigrations;
    /**
     * @test
     * @throws \Throwable
     */
    public function users_can_like_statuses()
    {
        $user = factory(User::class)->create();
        $status = factory(Status::class)->create();


        $this->browse(function (Browser $browser) use ($user, $status) {
            $browser->loginAs($user)
              ->visit('/')
              ->waitForText($status->body)
              ->press('@like-btn')
              ->waitForText('TE GUSTA')
              ->assertSee('TE GUSTA');
        });
    }
}
