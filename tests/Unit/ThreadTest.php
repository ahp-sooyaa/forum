<?php

namespace Tests\Unit;

use App\Models\Channel;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ThreadTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp() :void
    {
        parent::setUp();

        $this->thread = create('Thread');
    }

    public function testThreadHasPath()
    {
        $this->assertEquals("/threads/{$this->thread->channel->slug}/{$this->thread->id}", $this->thread->path());
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
}
