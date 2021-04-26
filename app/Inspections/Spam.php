<?php

namespace App\Inspections;

use Exception;

class Spam
{
    /**
     * Registered all inspections classes
     */
    protected $inspections = [
        InvalidKeywords::class,
        KeyHeldDown::class,
    ];

    /**
     * detect the spam
     *
     * @param $body
     * @return boolean
     */
    public function detect($body)
    {
        foreach ($this->inspections as $inspection) {
            app($inspection)->detect($body);
        }

        return false;
    }
}
