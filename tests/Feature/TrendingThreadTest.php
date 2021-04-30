<?php

namespace Tests\Feature;

use App\TrendingThreads;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class TrendingThreadTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp():void
    {
        parent::setUp();

        $this->trending = new TrendingThreads();

        $this->trending->reset();
    }

    public function testRedisIncrementsThreadScoreEachTimeItIsRead()
    {
        $this->assertEmpty($this->trending->get());

        $thread = create('Thread');

        $this->get($thread->path());

        $this->assertCount(1, $trending = $this->trending->get());

        $this->assertEquals($thread->title, $trending[0]->title);
    }
}
