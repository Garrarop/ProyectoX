<?php

namespace Tests\Browser;

use App\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UsersCanLoginTest extends DuskTestCase
{
    use DatabaseMigrations;
    /**
     * A Dusk test example.
     *
     * @test
     * @throws \Throwable
     */
    public function registered_users_can_login()
    {
        factory(User::class)->create(['email' => 'Gary@mail.com']);

        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->type('email', 'Gary@mail.com')
                    ->type('password', 'password')
                    ->press('@login-btn')
                    ->screenshot('Prueba')
                    ->assertAuthenticated();
        });
    }
    /**
    * @test void
    * @throws \Throwable
    */
    public function user_cannot_login_with_invalid_information()
    {
      $this->browse(function (Browser $browser) {
          $browser->visit('/login')
                  ->type('email', 'Gary@mail')
                  ->type('password', 'passwrd')
                  ->press('@login-btn')
                  ->assertPathIs('/login')
                  ->assertPresent('@errors');
      });
    }
}
