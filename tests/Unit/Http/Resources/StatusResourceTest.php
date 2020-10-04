<?php

namespace Tests\Unit\Http\Resources;


use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Status;
use Tests\TestCase;
use App\Http\Resources\StatusResource;

class StatusResourceTest extends TestCase
{
  use RefreshDatabase;
    /**
     * @test
     */
    public function a_status_resources_must_have_the_necessary_fields()
    {
        $status = factory(Status::class)->create();

        $statusResource = StatusResource::make($status)->resolve();

        $this->assertEquals($status->id, $statusResource['id']);
        $this->assertEquals($status->body, $statusResource['body']);
        $this->assertEquals($status->user->name, $statusResource['user_name']);
        $this->assertEquals('https://i.ibb.co/HtZWgQj/default-avatar.jpg', $statusResource['user_avatar']);
        $this->assertEquals($status->created_at->diffForHumans(), $statusResource['ago']);
        $this->assertEquals(false, $statusResource['is_liked']);
    }
}
