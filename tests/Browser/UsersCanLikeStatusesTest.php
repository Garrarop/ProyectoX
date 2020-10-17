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
    public function guests_users_cannot_like_statuses()
    {
        $status = factory(Status::class)->create();


        $this->browse(function (Browser $browser) use ($status) {
            $browser->visit('/')
              ->waitForText($status->body)
              ->press('@like-btn')
              ->assertPathIs('/login');
        });
    }

    /**
     * @test
     * @throws \Throwable
     */
    public function users_can_like_and_unlike_statuses()
    {
        $user = factory(User::class)->create();
        $status = factory(Status::class)->create();


        $this->browse(function (Browser $browser) use ($user, $status) {
            $browser->loginAs($user)
              ->visit('/')
              ->waitForText($status->body)
              ->assertSeeIn('@likes-count', 0)
              ->press('@like-btn')
              ->waitForText('TE GUSTA')
              ->assertSee('TE GUSTA')
              ->assertSeeIn('@likes-count', 1)
              ->press('@like-btn')
              ->waitForText('ME GUSTA')
              ->assertSee('ME GUSTA')
              ->assertSeeIn('@likes-count', 0)
              ;

        });
    }
}
