<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanSeeProfile()
    {
        $user = create('User');

        $this->get("profiles/{$user->name}")
            ->assertSee($user->name);
    }

    public function testProfileShowAssociatedUserThreads()
    {
        $this->signIn(); // user need to sign in bcuz activity require user_id in order to create record

        $thread = create('Thread', ['user_id' => auth_id()]);

        $this->get('profiles/' . auth_user()->name)
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }
}
