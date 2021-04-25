<?php

namespace Tests\Feature;

use App\Models\Activity;
use App\Models\Thread;
use App\Rules\Recaptcha;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ThreadsCRUDTest extends TestCase
{
    use RefreshDatabase;

    public function setUp():void
    {
        parent::setUp();

        $this->thread = create('Thread');

        $this->mock(Recaptcha::class, function ($mock) {
            $mock->shouldReceive('passes')->andReturn(true);
        });
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

        $response = $this->post('/threads', $thread->toArray() + ['g-recaptcha-response' => 'token']);

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

    public function testThreadRequireRecaptchaVerification()
    {
        unset(app()[Recaptcha::class]);

        $this->validatePublishThread(['g-recaptcha-response' => 'invalid'], 'g-recaptcha-response');
    }

    public function testThreadSlugMustBeUnique()
    {
        $this->signIn();

        $thread = create('Thread', ['title' => 'Thread slug','slug' => 'thread-slug']);

        $this->assertEquals($thread->fresh()->slug, 'thread-slug');

        $thread2 = make('Thread', ['title' => 'Thread slug','slug' => 'thread-slug']); 
        // dd($thread2->toArray() + ['g-recaptcha-response' => 'token']); we need to check data if an error occured

        $this->post('/threads', $thread2->toArray() + ['g-recaptcha-response' => 'token']);

        $this->assertCount(2, Thread::whereTitle('Thread slug')->get()); 
        //actually i should slug but slug is using unique id so i can't guess about that id in test case
        // e.g after created post that should redirect to thread->path() /threads/channelSlug/thread-slug_uniqueid
        // that unique id is problem to guess in test
    }

    public function testThreadRequiresChannelId()
    {
        create('Channel');

        $this->validatePublishThread(['channel_id' => null], 'channel_id');

        /** test the channel_id is valid or not */
        $this->validatePublishThread(['channel_id' => 9999], 'channel_id');
    }

    public function validatePublishThread(Array $overrides = null, $column)
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
        // dd($response['data']); becoz laravel is returning pagination collection & we only need data from response not pagination data such as current page
        $this->assertEquals([3, 2, 0], array_column($response['data'], 'replies_count'));
    }

    public function testUserCanFilterUnansweredThreads()
    {
        $thread = create('Thread');
        create('Reply', ['thread_id' => $thread->id]);

        $response = $this->getJson('/threads?unanswered=1')->json();

        $this->assertCount(1, $response['data']);
    }

    /**
     * Update Threads Tests
     */
    public function testAuthorizedUsersCanUpdateThreads()
    {
        $this->withoutExceptionHandling();
        $this->signIn();

        $thread = create('Thread', ['user_id' => auth_id()]);

        $this->patch($thread->path(), ['title' => 'changed', 'body' => 'changed body']);

        tap($thread->fresh(), function($thread){
            $this->assertEquals('changed', $thread->title);
            $this->assertEquals('changed body', $thread->body);
        });
    }

    public function testUnAuthorizedUsersCanNotUpdateThreads()
    {
        $this->signIn();

        $this->patch($this->thread->path(), ['title' => 'changed', 'body' => 'changed body'])
            ->assertStatus(403);
    }

    public function testUpdateThreadRequiredTitle()
    {
        $this->signIn();

        $thread = create('Thread', ['user_id' => auth_id()]);

        $this->patch($thread->path(), [
            'title' => null
        ])->assertSessionHasErrors('title');
    }

    public function testUpdateThreadRequiredBody()
    {
        $this->signIn();

        $thread = create('Thread', ['user_id' => auth_id()]);

        $this->patch($thread->path(), [
            'body' => null
        ])->assertSessionHasErrors('body');
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
