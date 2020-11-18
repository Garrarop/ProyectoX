<?php

namespace Tests\Browser;

use App\User;
use App\Models\Status;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class UsersCanSeeProfilesTest extends DuskTestCase
{
    /**
     * @test
     * @throws \Throwable
     */
    public function users_can_see_profiles()
    {
        $user = factory(User::class)->create();
        $statuses = factory(Status::class,2)->create(['user_id' => $user->id]);
        $otherStatus = factory(Status::class)->create();

        $this->browse(function (Browser $browser) use ($user, $statuses, $otherStatus) {
            $browser->visit("/@{$user->name}")
                    ->assertSee($user->name)
                    ->waitForText($statuses->first()->body)
                    ->assertSee($statuses->first()->body)
                    ->assertSee($statuses->last()->body)
                    ->assertDontSee($otherStatus->body);
        });
    }
}
