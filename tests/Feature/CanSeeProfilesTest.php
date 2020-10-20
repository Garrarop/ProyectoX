<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CanSeeProfilesTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function can_see_profiles_test()
    {
        factory(User::class)->create(['name' => 'Garraro']);

        $this->get('@Garraro')->assertSee('Garraro');
    }
}
