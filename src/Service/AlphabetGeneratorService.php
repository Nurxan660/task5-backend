<?php

namespace App\Service;

use Faker\Generator;

class AlphabetGeneratorService
{
    private function generateAlphabet(Generator $faker): string
    {
        $text = $faker->realText(200);
        return preg_replace("/[^\p{L}]/u", "", $text);
    }

    private function generateDigits(): string
    {
        $digits = range(0, 9);
        return implode('', $digits);
    }

    public function prepareAlphabets(Generator $faker): array
    {
        return [
            'text' => $this->generateAlphabet($faker),
            'numeric' => $this->generateDigits()
        ];
    }
}