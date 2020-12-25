<?php

namespace Tests\Feature;

use App\Models\Activity;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ActivityTest extends TestCase
{
    use RefreshDatabase;

    public function testThreadActivitiesCanRecord()
    {
        $this->signIn();

        // $thread = create('Thread');

        // $this->assertDatabaseHas('activities', [
        //     'type' => 'created_thread',
        //     'user_id' => auth()->id(),
        //     'subject_id' => $thread->id,
        //     'subject_type' => 'App\Models\Thread'
        // ]);

        // $activity = Activity::first();

        // $this->assertEquals($activity->subject->id, $thread->id);
        $thread = create('Thread');

        $this->assertCount(1, $thread->activities);
    }

    public function testReplyActivitiesCanRecord()
    {
        $this->signIn();

        create('Reply');

        $this->assertEquals(2, Activity::count());
    }

    public function testActivityFetchFeed()
    {
        $this->signIn();

        create('Thread', ['user_id' => auth_id()], 2);

        auth_user()->activities()->first()->update(['created_at' => Carbon::now()->subWeek()]);

        $feed = Activity::feed(auth_user());

        $this->assertTrue($feed->keys()->contains(
            Carbon::now()->format('Y-M-d')
        ));
        $this->assertTrue($feed->keys()->contains(
            Carbon::now()->subWeek()->format('Y-M-d')
        ));
    }
}
