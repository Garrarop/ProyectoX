<?php

namespace Tests\Browser;

use App\User;
use App\Models\Comment;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UsersCanLikeCommentsTest extends DuskTestCase
{
      use DatabaseMigrations;

      /** @test
       * @throws \Throwable
       */
      public function users_can_like_and_unlike_comment()
      {
          $user = factory(User::class)->create();
          $comment = factory(Comment::class)->create();

          $this->browse(function (Browser $browser) use ($user, $comment) {
              $browser->loginAs($user)
                ->visit('/')
                ->waitForText($comment->body)
                ->assertSeeIn('@comment-likes-count', 0)
                ->press('@comment-like-btn')
                ->waitForText('TE GUSTA')
                ->assertSee('TE GUSTA')
                ->assertSeeIn('@comment-likes-count', 1)
                ->press('@comment-like-btn')
                ->waitForText('ME GUSTA')
                ->assertSee('ME GUSTA')
                ->screenshot('SiLeSacoEstoFallaSinSentido')
                ->assertSeeIn('@comment-likes-count', 0)
                ;
          });
      }
}
