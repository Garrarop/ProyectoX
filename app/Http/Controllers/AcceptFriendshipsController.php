<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\Friendship;
use Illuminate\Http\Request;

class AcceptFriendshipsController extends Controller
{
    public function store(User $sender)
    {
      Friendship::where([
        'sender_id' => $sender->id,
        'recipient_id' => auth()->id()
      ])->update(['status' => 'accepted']);
    }
    public function destroy(User $sender)
    {
      Friendship::where([
        'sender_id' => $sender->id,
        'recipient_id' => auth()->id()
      ])->update(['status' => 'denied']);
    }
}
