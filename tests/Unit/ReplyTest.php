<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Thread;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReplyTest extends TestCase
{
    use RefreshDatabase;

    public function setUp() :void
    {
        parent::setUp();

        $this->reply = create('Reply');
    }

    public function testReplyHasPath()
    {
        $thread = create('Thread');
        $reply = create('Reply', ['thread_id' => $thread->id]);
        $this->assertEquals($thread->path() . "#reply-{$reply->id}", $reply->path());
    }

    public function testReplyHasOwner()
    {
        $this->assertInstanceOf(User::class, $this->reply->owner);
    }

    public function testReplyHasManyFavorites()
    {
        $this->assertInstanceOf(Collection::class, $this->reply->favorites);
    }

    public function testReplyMorphManyActivities()
    {
        $this->assertInstanceOf(Collection::class, $this->reply->activities);
    }

    public function testReplyBelongsToThread()
    {
        $this->assertInstanceOf(Thread::class, $this->reply->thread);
    }
}
