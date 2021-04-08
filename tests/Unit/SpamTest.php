<?php

namespace Tests\Unit;

use App\Inspections\Spam;
use Tests\TestCase;

class SpamTest extends TestCase
{
    public function testInvalidKeyword()
    {
        $spam = new Spam();

        $this->assertFalse($spam->detect('Innocent reply'));

        $this->expectException('Exception');

        $spam->detect('Google customer Support');
    }

    public function testKeyHeldDown()
    {
        $spam = new Spam();

        $this->expectException('Exception');

        $spam->detect('spam mmmmmmmmmmmmm');
    }
}
