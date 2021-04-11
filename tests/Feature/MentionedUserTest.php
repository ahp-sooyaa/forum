<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MentionedUserTest extends TestCase
{
    use RefreshDatabase;

    public function testMentionedUserGetNotification()
    {
        $jane = create('User', ['name' => 'Jane']);

        $this->signIn($jane);

        $jone = create('User', ['name' => 'Jone']);

        $thread = create('Thread');

        $reply = make('Reply', [
            'body' => '@Jone & @Frank look at this.'
        ]);

        $this->json('post', "{$thread->path()}/replies", $reply->toArray());

        $this->assertCount(1, $jone->notifications);
    }
}
