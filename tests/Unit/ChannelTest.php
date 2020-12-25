<?php

namespace Tests\Unit;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ChannelTest extends TestCase
{
    use RefreshDatabase;

    public function testChannelHasManyThreads()
    {
        $channel = create('Channel');

        $this->assertInstanceOf(Collection::class, $channel->threads);
    }
}
