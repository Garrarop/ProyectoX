<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $guarded = [];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $appends = ['avatar'];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getRouteKeyName()
    {
      return 'name';
    }

    public function link()
    {
      return route('users.show', $this);
    }

    public function avatar()
    {
      return 'https://i.ibb.co/HtZWgQj/default-avatar.jpg';
    }

    public function getAvatarAttribute()
    {
      return $this->avatar();
    }

}
