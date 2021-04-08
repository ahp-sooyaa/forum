<?php

namespace Tests\Feature;

use Database\Factories\DatabaseNotificationFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NotificationTest extends TestCase
{
    use RefreshDatabase;

    public function testNotificationIsPreparedWhenSubscribedThreadReceivesANewReplyThatIsNotByCurrentUser()
    {
        $this->signIn();

        $thread = create('Thread')->subscribe();

        $this->assertCount(0, auth_user()->notifications);

        $thread->addReply([
            'user_id' => auth_id(),
            'body' => 'hi this is reply body'
        ]);

        $this->assertCount(0, auth_user()->fresh()->notifications); // if above assertCount is not included fresh() is no need to add

        $thread->addReply([
            'user_id' => create('User')->id,
            'body' => 'hi this is reply body'
        ]);

        $this->assertCount(1, auth_user()->fresh()->notifications);
    }

    public function testUserCanMarkNotificationsAsRead()
    {
        $this->signIn();

        DatabaseNotificationFactory::new()->create();

        tap(auth_user(), function ($user) {
            $this->assertCount(1, $user->unreadNotifications);

            $notificationId = $user->unreadNotifications->first()->id;

            $this->delete('profiles/' . $user->name . "/notifications/$notificationId");

            $this->assertCount(0, $user->fresh()->unreadNotifications);
        });
    }

    public function testUserCanFetchUnreadNotifications()
    {
        $this->signIn();

        DatabaseNotificationFactory::new()->create();

        $response = $this->getJson('profiles/' . auth_user()->name . '/notifications')->json();

        $this->assertCount(1, $response);
    }
}
