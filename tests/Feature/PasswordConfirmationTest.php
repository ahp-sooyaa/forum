<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PasswordConfirmationTest extends TestCase
{
    use RefreshDatabase;

    public function testConfirmPasswordScreenCanBeRendered()
    {
        $user = create('User');

        $response = $this->signIn($user)->get('/password/confirm');

        $response->assertStatus(200);
    }

    public function testPasswordCanBeConfirmed()
    {
        $user = create('User');

        $response = $this->signIn($user)->post('/password/confirm', [
            'password' => 'password',
        ]);

        $response->assertRedirect();
        $response->assertSessionHasNoErrors();
    }

    public function testPasswordIsNotConfirmedWithInvalidPassword()
    {
        $user = create('User');

        $response = $this->signIn($user)->post('/password/confirm', [
            'password' => 'wrong-password',
        ]);

        $response->assertSessionHasErrors();
    }
}
