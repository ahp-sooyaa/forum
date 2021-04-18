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
            'body' => '@Jone & @whodoesnotexist look at this.'
        ]);

        $this->post("{$thread->path()}/replies", $reply->toArray());

        $this->assertCount(1, $jone->notifications);
    }

    /** @test */
    public function testFetchAllUsersData()
    {
        // $this->withoutExceptionHandling();
        create('User', ['name' => 'JohnDoe']);
        create('User', ['name' => 'JohnDoe2']);
        create('User', ['name' => 'JaneDoe']);

        $response = $this->json('GET', '/api/users', ['name' => 'John']);

        $this->assertCount(2, $response->json());
    }
}
