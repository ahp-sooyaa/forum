<?php

namespace Tests\Feature;

use App\Models\Thread;
use App\Models\Reply;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ThreadsTest extends TestCase
{
    use DatabaseMigrations, RefreshDatabase;

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
        $this->get($this->thread->path())
            ->assertSee($this->thread->title);
    }

    public function testUserCanSeeThreadReplies()
    {
        $reply = Reply::factory()->create(['thread_id' => $this->thread->id]);

        $this->get($this->thread->path())
            ->assertSee($reply->body);
    }
}
