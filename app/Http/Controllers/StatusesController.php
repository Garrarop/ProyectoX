<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Http\Request;

class StatusesController extends Controller
{

    public function index()
    {
      return Status::latest()->paginate();
    }


    public function store()
    {
      request()->validate(['body' => 'required|min:5']);

      $status = Status::create([
        'user_id' => auth()->id(),
        'body' => request('body')
      ]);

      return response()->json(['body' => $status->body]);
    }
}
