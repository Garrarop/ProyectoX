<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use App\Models\Friendship;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CanRequestFriendshipTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function cand_send_friendship_request()
    {
      $this->withoutExceptionHandling();
      $sender = factory(User::class)->create();
      $recipient = factory(User::class)->create();

      $this->actingAs($sender)->postJson(route('friendships.store',$recipient));

      $this->assertDatabaseHas('friendships', [
        'sender_id' => $sender->id,
        'recipient_id' => $recipient->id,
        'accepted' => false
      ]);
    }
    /** @test */
    public function can_accept_friendship_request()
    {
      $this->withoutExceptionHandling();
      $sender = factory(User::class)->create();
      $recipient = factory(User::class)->create();

      Friendship::create([
        'sender_id' => $sender->id,
        'recipient_id' => $recipient->id,
        'accepted' => false
      ]);

      $this->actingAs($recipient)->postJson(route('request-friendships.store',$sender));

      $this->assertDatabaseHas('friendships', [
        'sender_id' => $sender->id,
        'recipient_id' => $recipient->id,
        'accepted' => true
      ]);
    }
}
