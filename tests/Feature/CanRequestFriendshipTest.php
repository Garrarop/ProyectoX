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
    public function cand_create_friendship_request()
    {
      $sender = factory(User::class)->create();
      $recipient = factory(User::class)->create();

      $this->actingAs($sender)->postJson(route('friendships.store',$recipient));

      $this->assertDatabaseHas('friendships', [
        'sender_id' => $sender->id,
        'recipient_id' => $recipient->id,
        'status' => 'pending'
      ]);
    }
    /** @test */
    public function cand_delete_friendship_request()
    {
      $sender = factory(User::class)->create();
      $recipient = factory(User::class)->create();

      Friendship::create([
        'sender_id' => $sender->id,
        'recipient_id' => $recipient->id
      ]);

      $this->actingAs($sender)->deleteJson(route('friendships.destroy',$recipient));

      $this->assertDatabaseMissing('friendships', [
        'sender_id' => $sender->id,
        'recipient_id' => $recipient->id
      ]);
    }
    /** @test */
    public function can_accept_friendship_request()
    {
      $sender = factory(User::class)->create();
      $recipient = factory(User::class)->create();

      Friendship::create([
        'sender_id' => $sender->id,
        'recipient_id' => $recipient->id,
        'status' => 'pending'
      ]);

      $this->actingAs($recipient)->postJson(route('accept-friendships.store',$sender));

      $this->assertDatabaseHas('friendships', [
        'sender_id' => $sender->id,
        'recipient_id' => $recipient->id,
        'status' => 'accepted'
      ]);
    }
    /** @test */
    public function can_deny_friendship_request()
    {
      $sender = factory(User::class)->create();
      $recipient = factory(User::class)->create();

      Friendship::create([
        'sender_id' => $sender->id,
        'recipient_id' => $recipient->id,
        'status' => 'pending'
      ]);

      $this->actingAs($recipient)->deleteJson(route('accept-friendships.destroy',$sender));

      $this->assertDatabaseHas('friendships', [
        'sender_id' => $sender->id,
        'recipient_id' => $recipient->id,
        'status' => 'denied'
      ]);
    }
}
