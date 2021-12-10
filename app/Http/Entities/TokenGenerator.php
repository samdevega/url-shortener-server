<?php

namespace App\Http\Entities;

use Illuminate\Support\Facades\URL;

class TokenGenerator
{
    private const LENGTH = 8;

    public function generate() {
        $token = '';
        for ($index = 0; $index < self::LENGTH; $index++) {
            $token .= $this->generateRandomCharacter();
        }
        return $token;
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
