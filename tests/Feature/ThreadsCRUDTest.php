<?php

namespace Tests\Feature;

use App\Models\Activity;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ThreadsCRUDTest extends TestCase
{
    use RefreshDatabase;

    public function setUp():void
    {
        parent::setUp();

        $this->thread = create('Thread');
    }

    public function testGuestsCanNotCreateThreads()
    {
        $this->get('/threads/create')
            ->assertRedirect('login');

        $thread = make('Thread');

        $this->post('/threads', $thread->toArray())
            ->assertRedirect('login');
    }

    public function testAnAuthenticatedUserCanCreateThreads()
    {
        $this->signIn();

        $thread = make('Thread');

        // dd($thread->path());
        $response = $this->post('/threads', $thread->toArray());

        //dd($response->headers); //this is returning null so this cause problem

        $this->get($response->headers->get('Location'))
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }

    public function testThreadRequiresTitle()
    {
        $this->validatePublishThread(['title' => null], 'title');
    }

    public function testThreadRequiresBody()
    {
        $this->validatePublishThread(['body' => null], 'body');
    }

    public function testThreadRequiresChannelId()
    {
        create('Channel');

        $this->validatePublishThread(['channel_id' => null], 'channel_id');

        /** test the channel_id is valid or not */
        $this->validatePublishThread(['channel_id' => 9999], 'channel_id');
    }

    public function validatePublishThread($overrides = [], $column)
    {
        $this->signIn();

        $thread = make('Thread', $overrides);

        return $this->post('/threads', $thread->toArray())
                    ->assertSessionHasErrors($column);
    }

    /**
     * Read Threads Tests
     */
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
        $reply = create('Reply', ['thread_id' => $this->thread->id]);

        $this->assertDatabaseHas('replies', ['body' => $reply->body]);
    }

    public function testUserCanFilterThreadsByChannel()
    {
        $this->withoutExceptionHandling();

        $channel = create('Channel');

        $threadInChannel = create('Thread', ['channel_id' => $channel->id]);
        $threadNotInChannel = create('Thread');

        $this->get("/threads/{$channel->slug}")
            ->assertSee($threadInChannel->title)
            ->assertDontSee($threadNotInChannel->title);
    }

    public function testUserCanFilterThreadsByName()
    {
        $this->signIn(create('User', ['name' => 'JohnDoe']));

        $threadByJohn = create('Thread', ['user_id' => auth()->id()]);
        $threadNotByJohn = create('Thread');

        $this->get('/threads?by=JohnDoe')
            ->assertSee($threadByJohn->title)
            ->assertDontSee($threadNotByJohn->title);
    }

    public function testUserCanFilterThreadsByPopularity()
    {
        $threadWithThreeReplies = create('Thread');
        create('Reply', ['thread_id' => $threadWithThreeReplies->id], 3);

        $threadWithTwoReplies = create('Thread');
        create('Reply', ['thread_id' => $threadWithTwoReplies->id], 2);

        $threadWithOneReplies = $this->thread;

        $response = $this->getJson('/threads?popular=1')->json();

        $this->assertEquals([3, 2, 0], array_column($response, 'replies_count'));
    }

    public function testUserCanFilterUnansweredThreads()
    {
        $thread = create('Thread');
        create('Reply', ['thread_id' => $thread->id]);

        $response = $this->getJson('/threads?unanswered=1')->json();

        $this->assertCount(1, $response);
    }

    /**
     * Delete Threads Tests
     */
    public function testAnUnauthorizedUserCanNotDeleteThreads()
    {
        $this->delete($this->thread->path())
            ->assertRedirect('login');

        $this->signIn();
        $this->delete($this->thread->path())
            ->assertStatus(403);
    }

    public function testAnAuthorizedUserCanDeleteThreads()
    {
        $this->signIn();

        $thread = create('Thread', ['user_id' => auth_id()]);
        $reply = create('Reply', ['thread_id' => $thread->id]);

        $this->delete($thread->path());

        $this->assertDatabaseMissing('threads', ['id' => $thread->id]);
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);

        $this->assertEquals(0, Activity::count());
    }
}
