<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ThreadSubscriptiontest extends TestCase
{
    use RefreshDatabase;

    public function testAnAuthenticatedUserCanSubscribedToThread()
    {
        $this->signIn();

        $thread = create('Thread');

        $this->post("{$thread->path()}/subscriptions");

        $this->assertCount(1, $thread->subscriptions);
    }

    public function testAnAuthenticatedUserCanUnSubscribedFromThread()
    {
        $this->signIn();

        $thread = create('Thread');

        $thread->subscribe();

        $this->delete("{$thread->path()}/subscriptions");

        $this->assertCount(0, $thread->subscriptions);
    }
}
