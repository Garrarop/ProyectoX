<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateStatusTest extends TestCase
{

    use RefreshDatabase;

    /** @test  */
    public function guests_users_can_not_create_statuses()
    {

      $response = $this->post(route('statuses.store'), ['body' => 'Mi primer status']);

      $response->assertRedirect('login');
    }

    /** @test  */
    public function an_authenticated_user_can_create_statuses()
    {
        // $this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $this->actingAs($user);

        $response = $this->postJson(route('statuses.store'), ['body' => 'Mi primer status']);

        $response->assertJson([
          'body' => 'Mi primer status'
        ]);

        $this->assertDatabaseHas('statuses', [
          'user_id' => $user->id,
          'body' => 'Mi primer status'
        ]);
    }
    /** @test */
    public function a_status_requires_a_body()
    {

      $user = factory(User::class)->create();
      $this->actingAs($user);

      $response = $this->postJson(route('statuses.store'), ['body' => '']);

      $response->assertStatus(422);

      $response->assertJsonStructure([
        'message', 'errors' => ['body']
      ]);

    }

    /** @test */
    public function a_status_body_requires_a_minimum_body()
    {

      $user = factory(User::class)->create();
      $this->actingAs($user);

      $response = $this->postJson(route('statuses.store'), ['body' => 'asdf']);

      $response->assertStatus(422);

      $response->assertJsonStructure([
        'message', 'errors' => ['body']
      ]);

    }
}
