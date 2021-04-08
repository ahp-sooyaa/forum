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
        KeyHeldDown::class
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
        // $this->detectInvalidKeywords($body);
        // $this->detectKeyHeldDown($body);

        return false;
    }

    // protected function detectInvalidKeywords($body)
    // {
    //     $invalidKeywords = [
    //         'google customer Support'
    //     ];

    //     foreach ($invalidKeywords as $keyword) {
    //         if (stripos($body, $keyword) !== false) {
    //             throw new Exception('Your reply contains spam');
    //         }
    //     }
    // }

    // protected function detectKeyHeldDown($body)
    // {
    //     if (preg_match('/(.)\\1{4,}/', $body)) {
    //         throw new Exception('Your reply contains spam');
    //     }
    // }
}
