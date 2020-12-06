<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ThreadRepliesCRUDTest extends TestCase
{
    use RefreshDatabase, DatabaseMigrations;

    public function setUp() :void
    {
        parent::setUp();

        $this->thread = create('Thread');
    }

    public function testGuestsCanNotAddRepliesInThreads()
    {
        $this->post("{$this->thread->path()}/replies", [])
            ->assertRedirect('login');
    }

    public function testAnAuthenticatedUserCanAddRepliesInThreads()
    {
        $this->withoutExceptionHandling()->signIn();

        $reply = create('Reply');

        $this->post("{$this->thread->path()}/replies", $reply->toArray());

        $this->get($this->thread->path())
            ->assertSee($reply->body);
    }

    public function testReplyRequiresBody()
    {
        $this->signIn();

        $reply = make('Reply', ['body' => null]);

        $this->post("{$this->thread->path()}/replies", $reply->toArray())
            ->assertSessionHasErrors('body');
    }
}
