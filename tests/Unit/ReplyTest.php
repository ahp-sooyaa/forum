<?php

namespace Tests\Unit;

// use PHPUnit\Framework\TestCase; this is causing an error
use Tests\TestCase;
use App\Models\Reply;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ReplyTest extends TestCase
{
    use DatabaseMigrations;

    public function testReplyHasOwner()
    {
        $reply = Reply::factory()->create();

        $this->assertInstanceOf('App\Models\User', $reply->owner);
    }
}
