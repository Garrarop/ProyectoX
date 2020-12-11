<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\Friendship;
use Illuminate\Http\Request;

class FriendshipsController extends Controller
{
    public function store(User $recipient)
    {
      $friendship = Friendship::firstOrCreate([
        'sender_id' => auth()->id(),
        'recipient_id' => $recipient->id
      ]);

      return response()->json([
        'friendship_status' => $friendship->fresh()->status
      ]);
    }
    public function destroy(User $user)
    {
      $friendship = Friendship::where([
        'sender_id' => auth()->id(),
        'recipient_id' => $user->id
      ])->orWhere([
        'sender_id' => $user->id,
        'recipient_id' => auth()->id()
      ])->first();

      if($friendship->status === 'denied'){
        return response()->json([
          'friendship_status' => $friendship->status
        ]);
      }

      return response()->json([
        'friendship_status' => $friendship->delete() ? 'deleted' : ''
      ]);
    }
}
