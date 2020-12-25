<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RepliesFavoriteTest extends TestCase
{
    use RefreshDatabase;

    public function testGuestCanNotFavoriteReplies()
    {
        $this->post('/replies/1/favorite')
            ->assertRedirect('login');

        $this->delete('/replies/1/favorite')
            ->assertRedirect('login');
    }

    // public function testUserCanFavoriteReplies()
    // {
    //     $this->signIn();

    //     $reply = create('Reply');

    //     $this->post("/replies/{$reply->id}/favorite");

    //     $this->assertCount(1, $reply->favorites);
    // }

    public function testAuthenticatedUserCanToggleFavoriteReplies()
    {
        $this->signIn();

        $reply = create('Reply', ['user_id' => auth_id()]);

        $reply->favorite();

        $this->assertCount(1, $reply->favorites);

        $reply->unFavorite();

        $this->assertCount(0, $reply->fresh()->favorites);
    }
}
