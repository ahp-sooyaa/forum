<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ThreadsCRUDTest extends TestCase
{
    use DatabaseMigrations, RefreshDatabase;

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
        $this->withoutExceptionHandling()->signIn();

        $thread = make('Thread');

        $reponse = $this->post('/threads', $thread->toArray());

        $this->get($reponse->headers->get('Location'))
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
}
