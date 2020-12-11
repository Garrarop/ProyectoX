<?php

namespace Tests\Browser;

use App\User;
use App\Models\Status;
use App\Models\Friendship;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UsersCanRequestFriendshipTest extends DuskTestCase
{
    use DatabaseMigrations;
   /**
   * @test
   * @throws \Throwable
   */
    public function senders_can_create_and_delete_friendship_requests()
    {
        $sender = factory(User::class)->create();
        $recipient = factory(User::class)->create();
        factory(Status::class)->create(['user_id' => $recipient->id]);

        $this->browse(function (Browser $browser) use ($sender, $recipient) {
            $browser->loginAs($sender)
                    ->visit("/@{$recipient->name}")
                    ->press('@request-friendship')
                    ->waitForText('Cancelar solicitud')
                    ->assertSee('Cancelar solicitud')
                    ->visit("/@{$recipient->name}")
                    ->assertSee('Cancelar solicitud')
                    ->press('@request-friendship')
                    ->waitForText('Solicitar amistad')
                    ->assertSee('Solicitar amistad');
        });
    }
    /**
    * @test
    * @throws \Throwable
    */
    public function senders_can_delete_accepted_friendship_requests()
    {
        $sender = factory(User::class)->create();
        $recipient = factory(User::class)->create();
        factory(Status::class)->create(['user_id' => $recipient->id]);

        Friendship::create([
          'sender_id' => $sender->id,
          'recipient_id' => $recipient->id,
          'status' => 'accepted'
        ]);

        $this->browse(function (Browser $browser) use ($sender, $recipient) {
            $browser->loginAs($sender)
                    ->visit("/@{$recipient->name}")
                    ->assertSee('Eliminar de mis amigos')
                    ->press('@request-friendship')
                    ->waitForText('Solicitar amistad')
                    ->assertSee('Solicitar amistad')
                    ->visit("/@{$recipient->name}")
                    ->assertSee('Solicitar amistad');
        });
    }
    /**
    * @test
    * @throws \Throwable
    */
    public function senders_cannot_delete_denied_friendship_requests()
    {
        $sender = factory(User::class)->create();
        $recipient = factory(User::class)->create();
        factory(Status::class)->create(['user_id' => $recipient->id]);

        Friendship::create([
          'sender_id' => $sender->id,
          'recipient_id' => $recipient->id,
          'status' => 'denied'
        ]);

        $this->browse(function (Browser $browser) use ($sender, $recipient) {
            $browser->loginAs($sender)
                    ->visit("/@{$recipient->name}")
                    ->assertSee('Solicitud denegada')
                    ->press('@request-friendship')
                    ->waitForText('Solicitud denegada')
                    ->assertSee('Solicitud denegada')
                    ->visit("/@{$recipient->name}")
                    ->assertSee('Solicitud denegada');
        });
    }

    /**
    * @test
    * @throws \Throwable
    */
    public function recipients_can_accept_friendship_requests()
    {
        $sender = factory(User::class)->create();
        $recipient = factory(User::class)->create();

        Friendship::create([
          'sender_id' => $sender->id,
          'recipient_id' => $recipient->id,
        ]);

        $this->browse(function (Browser $browser) use ($sender, $recipient) {
            $browser->loginAs($recipient)
                    ->visit(route('accept-friendships.index'))
                    ->assertSee($sender->name)
                    ->press('@accept-friendship')
                    ->screenshot('asd')
                    ->waitForText("Tú y $sender->name son amigos")
                    ->assertSee("Tú y $sender->name son amigos")
                    ;
        });
    }

    /**
    * @test
    * @throws \Throwable
    */
    public function recipients_can_deny_friendship_requests()
    {
        $sender = factory(User::class)->create();
        $recipient = factory(User::class)->create();

        Friendship::create([
          'sender_id' => $sender->id,
          'recipient_id' => $recipient->id,
        ]);

        $this->browse(function (Browser $browser) use ($sender, $recipient) {
            $browser->loginAs($recipient)
                    ->visit(route('accept-friendships.index'))
                    ->assertSee($sender->name)
                    ->press('@deny-friendship')
                    ->waitForText('Solicitud denegada')
                    ->assertSee('Solicitud denegada')
                    ->visit(route('accept-friendships.index'))
                    ->assertSee('Solicitud denegada')
                    ;
        });
    }

    /**
    * @test
    * @throws \Throwable
    */
    public function recipients_can_delete_friendship_requests()
    {
        $sender = factory(User::class)->create();
        $recipient = factory(User::class)->create();

        Friendship::create([
          'sender_id' => $sender->id,
          'recipient_id' => $recipient->id,
        ]);

        $this->browse(function (Browser $browser) use ($sender, $recipient) {
            $browser->loginAs($recipient)
                    ->visit(route('accept-friendships.index'))
                    ->assertSee($sender->name)
                    ->press('@delete-friendship')
                    ->waitForText('Solicitud eliminada')
                    ->assertSee('Solicitud eliminada')
                    ->visit(route('accept-friendships.index'))
                    ->assertDontSee('Solicitud eliminada')
                    ;
        });
    }
}
