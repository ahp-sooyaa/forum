<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class PasswordResetTest extends TestCase
{
    use RefreshDatabase;

    public function testResetPasswordLinkScreenCanBeRendered()
    {
        $response = $this->get('/password/reset');

        $response->assertStatus(200);
    }

    public function testResetPasswordLinkCanBeRequested()
    {
        Notification::fake();

        $user = User::factory()->create();

        $this->post('/password/email', ['email' => $user->email]);

        Notification::assertSentTo($user, ResetPassword::class);
    }

    public function testResetPasswordScreenCanBeRendered()
    {
        Notification::fake();

        $user = User::factory()->create();

        $this->post('/password/email', ['email' => $user->email]);

        Notification::assertSentTo($user, ResetPassword::class, function ($notification) {
            $response = $this->get('/password/reset/'.$notification->token);

            $response->assertStatus(200);

            return true;
        });
    }

    public function testPasswordCanBeResetWithValidToken()
    {
        Notification::fake();

        $user = User::factory()->create();

        $this->post('/password/reset', ['email' => $user->email]);

        Notification::assertNotSentTo($user, ResetPassword::class, function ($notification) use ($user) {
            $response = $this->post('/password/reset', [
                'token' => $notification->token,
                'email' => $user->email,
                'password' => 'password',
                'password_confirmation' => 'password',
            ]);

            $response->assertSessionHasNoErrors();

            return true;
        });
    }
}
