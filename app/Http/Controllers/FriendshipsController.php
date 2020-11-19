<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\Friendship;
use Illuminate\Http\Request;

class FriendshipsController extends Controller
{
    public function store(User $recipient)
    {
      Friendship::create([
        'sender_id' => auth()->id(),
        'recipient_id' => $recipient->id
      ]);
    }
    public function destroy(User $recipient)
    {
      Friendship::where([
        'sender_id' => auth()->id(),
        'recipient_id' => $recipient->id
      ])->delete();
    }
}
