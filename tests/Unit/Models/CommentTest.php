<?php

namespace Tests\Unit\Models;

use App\User;
use App\Models\Comment;
use PHPUnit\Framework\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommentTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function a_comment_belongs_to_a_user()
    {
      $comment = factory(Comment::class)->create();
    }
}
