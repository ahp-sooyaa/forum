<?php

namespace App\Inspections;

use Dotenv\Exception\ValidationException;

class KeyHeldDown
{
    public function detect($body)
    {
        if (preg_match('/(.)\\1{4,}/', $body)) {
            throw new ValidationException('Your reply contains spam');
        }
    }
}
