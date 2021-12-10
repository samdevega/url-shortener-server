<?php

namespace App\Http\Entities;

use Illuminate\Support\Facades\URL;

class TokenGenerator
{
    private $shortUrlPrefix;
    private $length;

    public function __construct() {
        $this->shortUrlPrefix = 'http://localhost:8080';
        $this->length = 8;
    }

    public function generate() {
        $shortUrlBody = '';
        for ($index = 0; $index < $this->length; $index++) {
            $shortUrlBody .= $this->generateRandomCharacter();
        }
        return $this->shortUrlPrefix . '/' . $shortUrlBody;
    }

    private function generateRandomCharacter() {
        $randomGenerators = [
            Array($this, 'generateRandomCapitalLetter'),
            Array($this, 'generateRandomLetter'),
            Array($this, 'generateRandomNumber')
        ];
        $randomType = rand(0, count($randomGenerators) - 1);
        return $randomGenerators[$randomType]();
    }

    private function generateRandomCapitalLetter() {
        return chr(rand(65, 90));
    }

    private function generateRandomLetter() {
        return chr(rand(97, 122));
    }

    private function generateRandomNumber() {
        return chr(rand(48, 57));
    }
}
