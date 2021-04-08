<?php

namespace App\Inspections;

class InvalidKeywords
{
    protected $keywords = [
        'google customer support'
    ];

    public function detect($body)
    {
        foreach ($this->keywords as $keyword) {
            if (stripos($body, $keyword) !== false) {
                throw new \Exception('Your reply contains spam');
            }
        }
    }
}
