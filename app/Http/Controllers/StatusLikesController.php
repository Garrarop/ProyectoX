<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Status;

class StatusLikesController extends Controller
{
    public function store(Status $status)
    {
      $status->like();
    }

    public function destroy(Status $status)
    {
      $status->unlike();
    }
}
