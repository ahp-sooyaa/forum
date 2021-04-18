<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

// use PHPUnit\Framework\TestCase;

class ThreadRepliesCRUDTest extends TestCase
{
    use RefreshDatabase;

    public function setUp() :void
    {
        parent::setUp();

        $this->thread = create('Thread');
    }

    /**
     * replies create
     */
    public function testGuestsCanNotAddRepliesInThreads()
    {
        $this->post("{$this->thread->path()}/replies", [])
            ->assertRedirect('login');
    }

    public function testAnAuthenticatedUserCanAddRepliesInThreads()
    {
        $this->signIn();

        $reply = create('Reply');

        $this->post("{$this->thread->path()}/replies", $reply->toArray());

        $this->assertDatabaseHas('replies', ['body' => $reply->body]);
        $this->assertEquals(1, $this->thread->fresh()->replies_count);
    }

    public function testReplyRequiresBody()
    {
        $this->signIn();

        $reply = make('Reply', ['body' => null]);

        $this->post("{$this->thread->path()}/replies", $reply->toArray())
            ->assertSessionHasErrors('body');
    }

    /**
     * replies update
     */
    public function testAuthorizedUserCanUpdateReplies()
    {
        $this->withoutExceptionHandling();
        $this->signIn();
        $reply = create('Reply', ['user_id' => auth_id()]);

        $this->patch("replies/{$reply->id}", ['body' => 'updated']);

        $this->assertDatabaseHas('replies', [
            'id' => $reply->id,
            'body' => 'updated'
        ]);
    }

    /**
     * replies delete
     */
    public function testUnauthorizedUserCanNotDeleteReplies()
    {
        $reply = create('Reply');
        $this->delete("/replies/{$reply->id}")
            ->assertRedirect('login');

        $this->signIn();
        $this->delete("/replies/{$reply->id}")
            ->assertStatus(403);
    }

    public function testAuthorizedUserCanDeleteReplies()
    {
        $this->signIn();

        $reply = create('Reply', ['user_id' => auth_id()]);

        $this->delete("/replies/{$reply->id}");

        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
        $this->assertEquals(0, $this->thread->fresh()->replies_count);
    }

    public function testSpamRepliesCanNotBeAdded()
    {
        $this->signIn();

        $reply = create('Reply', [
            'body' => 'google customer support'
        ]);

        // Check validation error message
        $this->post("{$this->thread->path()}/replies", $reply->toArray())
                ->assertSessionHasErrors('body');

        // Check validation exception
        $this->withoutExceptionHandling();
        $this->expectException('Illuminate\Validation\ValidationException');
        $this->post("{$this->thread->path()}/replies", $reply->toArray());
    }

    public function testUserCanNotRepliesMoreThanOncePerMinute()
    {
        $this->signIn();

        $reply = make('Reply', [
            'body' => 'Not spam reply'
        ]);

        $this->post("{$this->thread->path()}/replies", $reply->toArray())
            ->assertStatus(201);

        $this->post("{$this->thread->path()}/replies", $reply->toArray())
            ->assertStatus(429);
    }
}
