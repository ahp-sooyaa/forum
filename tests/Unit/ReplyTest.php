<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Reply;
use App\Models\Thread;
use Carbon\Carbon;
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

    public function testIfReplyWasJustPublished()
    {
        $reply = create('Reply');

        $this->assertTrue($reply->wasJustPublished());

        $reply->created_at = Carbon::now()->subMonth();

        $this->assertFalse($reply->wasJustPublished());
    }

    public function testCanDetectMentionedUsers()
    {
        $reply = new Reply([
            'body' => 'hello @Jane & @Jone'
        ]);

        $this->assertEquals(['Jane', 'Jone'], $reply->mentionedUsers());
    }

    public function testMentionedUsernameWrapWithinAnchorTag()
    {
        $reply = new Reply([
            'body' => 'hello @Jane-Doe!'
        ]);

        $this->assertEquals(
            'hello <a href="/profiles/Jane-Doe">@Jane-Doe</a>!',
            $reply->body
        );
    }

    public function testIsAReplyBest()
    {
        $reply = create('Reply');

        $this->assertFalse($reply->isBest());

        $reply->thread->update(['best_reply_id' => $reply->id]);

        $this->assertTrue($reply->fresh()->isBest());
    }
}
