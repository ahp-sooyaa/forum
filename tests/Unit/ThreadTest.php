<?php

namespace Tests\Unit;

use App\Models\Channel;
use App\Models\User;
use App\Notifications\ThreadWasUpdated;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Redis;

class ThreadTest extends TestCase
{
    use RefreshDatabase;

    public function setUp() :void
    {
        parent::setUp();

        $this->thread = create('Thread');
    }

    public function testThreadHasPath()
    {
        $this->assertEquals(
            "/threads/{$this->thread->channel->slug}/{$this->thread->slug}", $this->thread->path()
        );
    }

    /**
    * Testing database relationship between thread & reply
    *
    */
    public function testThreadHasManyReplies()
    {
        $this->assertInstanceOf(Collection::class, $this->thread->replies);
    }

    /**
    * Testing database relationship between thread & reply
    *
    */
    public function testThreadMorphManyActivities()
    {
        $this->assertInstanceOf(Collection::class, $this->thread->activities);
    }

    /**
    * Testing database relationship between thread & channel
    *
    */
    public function testThreadBelongsToChannel()
    {
        $this->assertInstanceOf(Channel::class, $this->thread->channel);
    }

    /**
    * Testing database relationship between thread & user
    *
    */
    public function testThreadBelongsToCreator()
    {
        $this->assertInstanceOf(User::class, $this->thread->creator);
    }

    public function testThreadCanAddReplies()
    {
        $this->thread->addReply([
            'body' => 'hello body',
            'user_id' => 1
        ]);

        $this->assertCount(1, $this->thread->replies);
    }

    public function testANotificationSentToAllSubscribedUsers()
    {
        Notification::fake();

        $this->signIn();

        $this->thread
            ->subscribe()
            ->addReply([
                'body' => 'hello body',
                'user_id' => 1
            ]);

        Notification::assertSentTo(auth_user(), ThreadWasUpdated::class);
    }

    public function testThreadCanCheckIfAuthenticatedUserHasReadAllReplies()
    {
        $this->signIn();

        $thread = create('Thread');

        $this->assertTrue($thread->updatedSince());

        auth_user()->read($thread);

        $this->assertFalse($thread->updatedSince());
    }

    public function testThreadCanBeSubscribedByUser()
    {
        $this->thread->subscribe($userId = 1);

        $this->assertEquals(1, $this->thread->subscriptions()->where('user_id', $userId)->count());
    }

    public function testThreadCanBeUnSubscribedByUser()
    {
        $this->thread->subscribe($userId = 1);
        $this->thread->unsubscribe($userId);

        $this->assertEquals(0, $this->thread->subscriptions()->where('user_id', $userId)->count());
    }

    public function testThreadRecordsVisits()
    {
        $this->thread->resetVisits();

        $this->assertSame(0, $this->thread->visits());

        $this->thread->recordVisit();

        $this->assertEquals(1, $this->thread->visits());

        $this->thread->recordVisit();

        $this->assertEquals(2, $this->thread->visits());
    }
}
