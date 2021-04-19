<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BestReplyTest extends TestCase
{
    use RefreshDatabase;

    public function setUp() :void
    {
        parent::setUp();

        $this->signIn();

        $this->thread = create('Thread', ['user_id' => auth_id()]);

        $this->replies = create('Reply', ['thread_id' => $this->thread->id], 2);
    }

    public function testThreadCreatorCanMarkBestReply()
    {
        $this->assertFalse($this->replies[1]->isBest());

        $this->postJson(route('best-replies.store', [$this->replies[1]->id]));

        $this->assertTrue($this->replies[1]->fresh()->isBest());
    }

    public function testOnlyThreadCreatorCanMark()
    {
        $this->assertFalse($this->replies[1]->isBest());

        $this->postJson(route('best-replies.store', [$this->replies[1]->id]));

        $this->assertTrue($this->replies[1]->fresh()->isBest());

        $this->signIn(create('User'));

        $this->postJson(route('best-replies.store', [$this->replies[0]->id]))->assertStatus(403);

        $this->assertFalse($this->replies[0]->fresh()->isBest());
    }

    public function testIfBestReplyIsDeletedThenThreadShouldUpdated()
    {
        $this->signIn();

        $reply = create('Reply', ['user_id' => auth_id()]);

        $reply->thread->markBestReply($reply->id);

        $this->delete(route('replies.destroy', $reply));

        $this->assertNull($reply->thread->fresh()->best_reply_id);
    }
}
