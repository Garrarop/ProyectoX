<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function users_can_register()
    {
        $response = $this->post(route('register'), $this->userValidData());

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
    /* NAME TESTS */
    /** @test */
    public function the_name_is_required()
    {
      $response = $this->post(
        route('register'),
        $this->userValidData(['name' => null])
      )->assertSessionHasErrors('name');
    }
    /** @test */
    public function the_name_must_be_a_string()
    {
      $response = $this->post(
        route('register'),
        $this->userValidData(['name' => 123])
      )->assertSessionHasErrors('name');
    }
    /** @test */
    public function the_name_not_be_greater_than_60_characters()
    {
      $response = $this->post(
        route('register'),
        $this->userValidData(['name' => Str::random(61)])
      )->assertSessionHasErrors('name');
    }
    /* FIRST_NAME TESTS */
    /** @test */
    public function the_first_name_is_required()
    {
      $response = $this->post(
        route('register'),
        $this->userValidData(['first_name' => null])
      )->assertSessionHasErrors('first_name');
    }
    /** @test */
    public function the_first_name_must_be_a_string()
    {
      $response = $this->post(
        route('register'),
        $this->userValidData(['first_name' => 123])
      )->assertSessionHasErrors('first_name');
    }
    /** @test */
    public function the_first_name_not_be_greater_than_60_characters()
    {
      $response = $this->post(
        route('register'),
        $this->userValidData(['first_name' => Str::random(61)])
      )->assertSessionHasErrors('first_name');
    }
    /* LAST_NAME TESTS */
    /** @test */
    public function the_last_name_is_required()
    {
      $response = $this->post(
        route('register'),
        $this->userValidData(['last_name' => null])
      )->assertSessionHasErrors('last_name');
    }
    /** @test */
    public function the_last_name_must_be_a_string()
    {
      $response = $this->post(
        route('register'),
        $this->userValidData(['last_name' => 123])
      )->assertSessionHasErrors('last_name');
    }
    /** @test */
    public function the_last_name_not_be_greater_than_60_characters()
    {
      $response = $this->post(
        route('register'),
        $this->userValidData(['last_name' => Str::random(61)])
      )->assertSessionHasErrors('last_name');
    }
    /* EMAIL TESTS */
    /** @test */
    public function the_email_is_required()
    {
      $response = $this->post(
        route('register'),
        $this->userValidData(['email' => null])
      )->assertSessionHasErrors('email');
    }
    /** @test */
    public function the_email_must_be_a_valid_email_address()
    {
      $response = $this->post(
        route('register'),
        $this->userValidData(['email' => 'invalid-email'])
      )->assertSessionHasErrors('email');
    }
    /** @test */
    public function the_email_must_be_unique()
    {
      factory(User::class)->create(['email' => 'Gar@mail.com']);
      $response = $this->post(
        route('register'),
        $this->userValidData(['email' => 'Gar@mail.com'])
      )->assertSessionHasErrors('email');
    }
    /* PASSWORD TESTS */
    /** @test */
    public function the_password_is_required()
    {
      $pass = null;
      $response = $this->post(
        route('register'),
        $this->userValidData(['password' => $pass,'password_confirmation' => $pass])
      )->assertSessionHasErrors('password');
    }
    /** @test */
    public function the_password_must_be_a_string()
    {
      $pass = 123456789;
      $response = $this->post(
        route('register'),
        $this->userValidData(['password' => $pass,'password_confirmation' => $pass])
      )->assertSessionHasErrors('password');
    }
    /** @test */
    public function the_password_must_be_at_least_8_characters()
    {
      $pass = Str::random(7);
      $response = $this->post(
        route('register'),
        $this->userValidData(['password' => $pass,'password_confirmation' => $pass])
      )->assertSessionHasErrors('password');
    }
    /** @test */
    public function the_password_must_be_confirmed()
    {
      $pass = Str::random(8);
      $response = $this->post(
        route('register'),
        $this->userValidData(['password' => $pass,'password_confirmation' => null])
      )->assertSessionHasErrors('password');
    }

    protected function userValidData($overrides = []): array
    {
      return array_merge([
        'name' => 'Garraro',
        'first_name' => 'Gary',
        'last_name' => 'Shacklebolt',
        'email' => 'asd@asd.com',
        'password' => 'password',
        'password_confirmation' => 'password'
      ], $overrides);
    }
}
