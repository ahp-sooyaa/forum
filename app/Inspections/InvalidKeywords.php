<?php

namespace App\Inspections;

use Dotenv\Exception\ValidationException;

class InvalidKeywords
{
    protected $keywords = [
        'google customer support'
    ];

    public function detect($body)
    {
        foreach ($this->keywords as $keyword) {
            if (stripos($body, $keyword) !== false) {
                throw new ValidationException('Your reply contains spam');
            }
        }
    }
}
