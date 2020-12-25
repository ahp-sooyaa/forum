<?php

namespace Tests\Unit;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function testUserHasManyThreads()
    {
        $user = create('User');

        $this->assertInstanceOf(Collection::class, $user->threads);
    }

    public function testUserHasManyReplies()
    {
        $user = create('User');

        $this->assertInstanceOf(Collection::class, $user->replies);
    }
}
