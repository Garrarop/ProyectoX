<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Friendship extends Model
{
    protected $guarded = [];
    public function sender()
    {
      return $this->belongsTo(User::class);
    }
    public function recipient()
    {
      return $this->belongsTo(User::class);
    }
}
