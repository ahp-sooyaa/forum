<?php

namespace Tests\Feature;

use App\Models\Reply;
use App\Models\Thread;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ParticipateInForumTest extends TestCase
{
    use RefreshDatabase, DatabaseMigrations;

    public function setUp() :void
    {
        parent::setUp();

        $this->thread = Thread::factory()->create();
    }

    public function testUnauthenticatedUserCanNotAddRepliesInThreads()
    {
        $this->post($this->thread->path() . '/replies', [])
            ->assertRedirect('login');
    }

    public function testAnAuthenticatedUserCanAddRepliesInThreads()
    {
        $this->withoutExceptionHandling();

        $this->signIn();

        $reply = Reply::factory()->create();

        $this->post($this->thread->path() . '/replies', $reply->toArray());

        $this->get($this->thread->path())
            ->assertSee($reply->body);
    }
}
