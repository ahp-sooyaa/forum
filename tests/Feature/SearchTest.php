<?php

namespace Tests\Feature;

use App\Models\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchTest extends TestCase
{
    use RefreshDatabase;
    public function testUserCanSearchThreads()
    {
        config(['scout.driver' => 'algolia']);

        $search = 'foobar';

        create('Thread', [], 2);
        create('Thread', ['body' => "a thread with {$search} keyword"], 2);

        do {
            sleep(.25);

            $results = $this->getJson("/threads/search?q={$search}")->json();
        }
        while (empty($results));

        $this->assertCount(2, $results['data']);

        Thread::latest()->take(4)->unsearchable();
    }
}
