<?php

namespace App\Provider;

use Faker\Provider\Base;
use Symfony\Component\Yaml\Yaml;

class CustomAddressProvider extends Base
{
    private array $formats;
    private array $placeholders;

    public function __construct($generator)
    {
        parent::__construct($generator);
        $this->loadConfiguration();
    }

    private function loadConfiguration(): void
    {
        $config = Yaml::parse(file_get_contents('C:/Users/nurxa/PhpstormProjects/task5/config/address_formats.yaml'));
        $this->formats = $config['address_formats'] ?? [];
        $this->placeholders = $config['placeholders'] ?? [];
    }

    private function getRandomFormat(): string
    {
        return $this->formats[array_rand($this->formats)];
    }

    private function fillFormatWithData(string $format): string
    {
        $replacements = [$this->generator->postcode(), $this->generator->city(),
            $this->generator->streetName(), $this->generator->buildingNumber(),
            $this->generator->address()];
        return str_replace(array_values($this->placeholders), $replacements, $format);
    }

    public function getCustomAddress(): string
    {
        $format = $this->getRandomFormat();
        return $this->fillFormatWithData($format);
    }

}