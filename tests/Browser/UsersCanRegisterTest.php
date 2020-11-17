<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class UsersCanRegisterTest extends DuskTestCase
{
    use DatabaseMigrations;
    /**
    * @test void
    * @throws \Throwable
    */
    public function user_can_register()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                    ->type('name', 'GarraroShacklebolt')
                    ->type('first_name', 'Garraro')
                    ->type('last_name', 'Shacklebolt')
                    ->type('email', 'Garraro@mail.com')
                    ->type('password', 'password')
                    ->type('password_confirmation', 'password')
                    ->press('@register-btn')
                    ->assertPathIs('/')
                    ->assertAuthenticated();
        });
    }
    /**
    * @test void
    * @throws \Throwable
    */
    public function user_cannot_register_with_invalid_information()
    {
      $this->browse(function (Browser $browser) {
          $browser->visit('/register')
                  ->type('name', 'asd')
                  ->type('first_name', 'Garraro')
                  ->type('last_name', 'Shacklebolt')
                  ->type('email', 'Garraro@mail.com')
                  ->type('password', 'password')
                  ->type('password_confirmation', 'password')
                  ->press('@register-btn')
                  ->assertPathIs('/register')
                  ->assertPresent('@errors');
      });
    }

}
