<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function users_can_register()
    {
        $userData = [
          'name' => 'Garraro',
          'first_name' => 'Gary',
          'last_name' => 'Shacklebolt',
          'email' => 'asd@asd.com',
          'password' => 'password',
          'password_confirmation' => 'password'
        ];

        $response = $this->post(route('register'), $userData);

        $response->assertRedirect('/');

        $this->assertDatabaseHas('users', [
          'name' => 'Garraro',
          'first_name' => 'Gary',
          'last_name' => 'Shacklebolt',
          'email' => 'asd@asd.com'
        ]);

        $this->assertTrue(
          Hash::check('password',User::first()->password),
          'The password, needs to be hashed'
        );
    }
}
