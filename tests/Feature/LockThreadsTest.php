<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LockThreadsTest extends TestCase
{
    use RefreshDatabase;

    public function testOnceLockedThreadMayNotReceiveNewReplies()
    {
        $this->signIn();

        $thread = create('Thread');

        $thread->lock();

        $reply = make('Reply', [
            'user_id' => auth_id(),
            'thread_id' => $thread->id
        ]);

        $this->post("{$thread->path()}/replies" , $reply->toArray())
            ->assertStatus(422);
    }

    public function testOnlyAdministratorCanLockThread()
    {
        $this->signIn(create('User', ['name' => 'aung']));

        $thread = create('Thread');

        $this->post(route('locked-thread.store', $thread));

        $this->assertTrue(!!$thread->fresh()->locked);
    }

    public function testNonAdministratorCanNotLockThread()
    {
        $this->signIn();

        $thread = create('Thread');

        $this->post(route('locked-thread.store', $thread))
            ->assertStatus(302);

        $this->assertFalse(!!$thread->fresh()->locked);
    }
}
