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

      return response()->json([
        'friendship_status' => 'accepted'
      ]);
    }
    public function destroy(User $sender)
    {
      Friendship::where([
        'sender_id' => $sender->id,
        'recipient_id' => auth()->id()
      ])->update(['status' => 'denied']);

      return response()->json([
        'friendship_status' => 'denied'
      ]);
    }

    public function index()
    {
      $friendshipRequests = Friendship::with('sender')->where([
        'recipient_id' => auth()->id(),
        ])->get();

      return view('friendships.index', compact('friendshipRequests'));
    }
}
