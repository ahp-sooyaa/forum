<?php

namespace Tests\Feature;

use App\Models\Thread;
use App\Models\Reply;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ThreadsTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp():void
    {
        parent::setUp();

        $this->thread = Thread::factory()->create();
    }

    public function testUserCanSeeAllThreads()
    {
        $this->get('/threads')
            ->assertSee($this->thread->title);
    }

    public function testUserCanSeeSingleThread()
    {
        $this->get('/threads/' . $this->thread->id)
            ->assertSee($this->thread->title);
    }

    public function testUserCanSeeThreadReplies()
    {
        $reply = Reply::factory()->create(['thread_id' => $this->thread->id]);

        $this->get('/threads/' . $this->thread->id)
            ->assertSee($reply->body);
    }
}
