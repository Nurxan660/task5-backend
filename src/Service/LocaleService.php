<?php

namespace App\Service;

use Symfony\Component\Finder\Finder;

class LocaleService
{
    private string $projectDir;

    public function __construct(string $projectDir)
    {
        $this->projectDir = $projectDir;
    }

    public function getAvailableLocales(): array
    {
        return $this->extractLocalesFromDirectories($this->getFakerLocalePath());
    }

    private function getFakerLocalePath(): string
    {
        return $this->projectDir . '/vendor/fakerphp/faker/src/Faker/Provider';
    }

    private function extractLocalesFromDirectories(string $localePath): array
    {
        $finder = (new Finder())->directories()->in($localePath)->depth('== 0');
        $directories = [];
        foreach ($finder as $dir)
            $directories[] = ['name' => $dir->getFilename()];
        return $directories;
    }
}