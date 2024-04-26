<?php

namespace App\Service;

use App\DTO\DataGenerationRequest;
use App\Provider\CustomAddressProvider;
use Faker\Factory;
use Faker\Generator;

class DataGenerationService
{
    private Generator $faker;
    private CustomAddressProvider $customProvider;

    public function __construct(DataGenerationRequest $dataRequest)
    {
        $this->faker = Factory::create($dataRequest->getRegion());
        $this->faker->seed($dataRequest->getSeed());
        $this->customProvider = new CustomAddressProvider($this->faker);
    }

    public function generateData(int $page, int $size): array
    {
        $data = [];
        for ($i = 1; $i <= $size; $i++) {
            $data[] = $this->generateSingleRecord($page, $size, $i);
        }
        return $data;
    }

    private function generateSingleRecord(int $page, int $size, int $index): array
    {
        return [
            'Number' => ($page - 1) * $size + $index, 'UUID' => $this->faker->uuid(),
            'Name' => $this->faker->name(), 'Phone' => $this->faker->phoneNumber(),
            'Address' => $this->customProvider->getCustomAddress()
        ];
    }

}