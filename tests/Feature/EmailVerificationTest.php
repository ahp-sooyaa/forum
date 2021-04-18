<?php

namespace Tests\Feature;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\Notification;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class EmailVerificationTest extends TestCase
{
    use RefreshDatabase;

    // public function testAConfirmationEmailIsSentUponRegisteration()
    // {
    //     Event::fake();

    //     $this->post('/register', [
    //         'name' => 'John',
    //         'email' => 'johndoe@test.com',
    //         'password' => 'passwordtest',
    //         'password_confirmation' => 'passwordtest'
    //     ]);

    //     Event::assertDispatched(Registered::class);
    // }

    public function testEmailVerificationScreenCanBeRendered()
    {
        $user = create('User', ['email_verified_at' => null]);

        $response = $this->signIn($user)->get('/email/verify');

        $response->assertStatus(200);
    }

    public function testEmailCanBeVerified()
    {
        Event::fake();

        $user = create('User', ['email_verified_at' => null]);

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1($user->email)]
        );

        $response = $this->signIn($user)->get($verificationUrl);

        Event::assertDispatched(Verified::class);
        $this->assertTrue($user->fresh()->hasVerifiedEmail());
        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    public function testEmailIsNotVerifiedWithInvalidHash()
    {
        $user = create('User', ['email_verified_at' => null]);

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1('wrong-email')]
        );

        $this->actingAs($user)->get($verificationUrl);

        $this->assertFalse($user->fresh()->hasVerifiedEmail());
    }
}
