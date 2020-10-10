<?php

namespace App\Http\Controllers;

use App\Models\Status;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Resources\CommentResource;

class StatusCommentsController extends Controller
{
    public function store(Status $status)
    {
      $comment = Comment::create([
        'user_id' => auth()->id(),
        'status_id' => $status->id,
        'body' => request('body')
      ]);

      return CommentResource::make($comment);
    }
}
