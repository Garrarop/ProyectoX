<?php

namespace Tests\Unit;

use App\User;
use Tests\TestCase;

class UserTest extends TestCase
{

    /** @test */
    public function route_key_name_is_set_to_name()
    {
        $user = factory(User::class)->make();

        $this->assertEquals('name', $user->getRouteKeyName());
    }

    /** @test */
    public function user_has_link_to_their_profile()
    {
      $user = factory(User::class)->make();

      $this->assertEquals(route('users.show', $user), $user->link());
    }

    /** @test */
    public function users_has_an_avatar()
    {
      $user = factory(User::class)->make();

      $this->assertEquals('https://i.ibb.co/HtZWgQj/default-avatar.jpg', $user->avatar());
    }
}
