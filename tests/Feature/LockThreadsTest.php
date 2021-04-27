<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Rules\Recaptcha;

class LockThreadsTest extends TestCase
{
    use RefreshDatabase;

    public function testOnceLockedThreadMayNotReceiveNewReplies()
    {
        $this->signIn();

        $thread = create('Thread', ['locked' => true]);

        $reply = make('Reply', [
            'user_id' => auth_id(),
            'thread_id' => $thread->id,
        ]);

        $this->mock(Recaptcha::class, function ($mock) {
            $mock->shouldReceive('passes')->andReturn(true);
        });

        $this->post("{$thread->path()}/replies" , $reply->toArray() + ['g-recaptcha-response' => 'token'])
            ->assertStatus(422);
    }

    public function testOnlyAdministratorCanLockThread()
    {
        $this->signIn(create('User', ['name' => 'aung']));

        $thread = create('Thread');

        $this->post(route('locked-thread.store', $thread));

        $this->assertTrue($thread->fresh()->locked);
    }

    public function testOnlyAdministratorCanUnLockThread()
    {
        $this->signIn(create('User', ['name' => 'aung']));

        $thread = create('Thread', ['locked' => true]);

        $this->delete(route('locked-thread.destroy', $thread));

        // $this->assertFalse(!!$thread->fresh()->locked); if there is no attribute casting !! should use to cast 1,0 to true, false
        $this->assertFalse($thread->fresh()->locked);
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
