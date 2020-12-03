<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use App\Models\Status;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ListStatusesTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function can_get_all_statuses()
    {
        // $this->whitoutExceptionHandling();

        $status1 = factory(Status::class)->create(['created_at' => now()->subDays(4)]);
        $status2 = factory(Status::class)->create(['created_at' => now()->subDays(3)]);
        $status3 = factory(Status::class)->create(['created_at' => now()->subDays(2)]);
        $status4 = factory(Status::class)->create(['created_at' => now()->subDays(1)]);

        $response = $this->getJson(route('statuses.index'));

        $response->assertSuccessful();

        $response->assertJson([
          'meta' => ['total' => 4]
        ]);

        $response->assertJsonStructure([
          'data', 'links' => ['prev', 'next']
        ]);

        // dd($response->json('data'));

        $this->assertEquals(
          $status4->body,
          $response->json('data.0.body')
        );
    }
    /** @test */
    public function can_get_statuses_for_a_specfic_user()
    {
      $user = factory(User::class)->create();

      $status1 = factory(Status::Class)->create(['user_id' => $user->id, 'created_at' => now()->subDays(1)]);
      $status2 = factory(Status::Class)->create(['user_id' => $user->id, 'created_at' => now()]);

      $otherStatuses = factory(Status::class, 2)->create();

      $response = $this->actingAs($user)
          ->getJson(route('users.statuses.index', $user));

      $this->assertEquals(
        $status2->body,
        $response->json('data.0.body')
      );
    }
}
