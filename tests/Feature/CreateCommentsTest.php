<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use App\Models\Status;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateCommentsTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function guest_users_cannot_create_comments()
    {
      $status = factory(Status::class)->create();
      $comment = ['body' => 'Mi primer estado'];

      $response =  $this->postJson(route('statuses.comments.store', $status), $comment);

      $response->assertStatus(401);
    }
    /** @test */
    public function authenticated_users_can_comment_statuses()
    {
        $status = factory(Status::class)->create();
        $user = factory(User::class)->create();
        $comment = ['body' => 'Mi primer estado'];

        $response = $this->actingAs($user)->postJson(route('statuses.comments.store', $status), $comment);

        $response->assertJson([
          'data' => ['body' => $comment['body']]
        ]);

        $this->assertDatabaseHas('comments', [
          'user_id' => $user->id,
          'status_id' => $status->id,
          'body' => $comment['body']
        ]);
    }
}
