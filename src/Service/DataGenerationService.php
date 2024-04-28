<?php

namespace App\Service;

use App\DTO\DataGenerationRequest;
use App\Service\Builder\DataRecordBuilder;
use Faker\Factory;
use Faker\Generator;

class DataGenerationService
{
    private Generator $faker;
    private ErrorGenerationService $errService;
    private DataRecordBuilder $dataRecordBuilder;
    private AlphabetGeneratorService $alphabetGeneratorService;

    public function __construct(DataGenerationRequest $dataRequest,
                                ErrorGenerationService $errGenerationService,
                                AlphabetGeneratorService $alphabetGeneratorService)
    {
        $this->faker = Factory::create($dataRequest->getRegion());
        $this->faker->seed($dataRequest->getSeed());
        $this->errService = $errGenerationService;
        $this->dataRecordBuilder = new DataRecordBuilder($this->faker);
        $this->alphabetGeneratorService = $alphabetGeneratorService;
    }

    public function generateData(int $page, int $size, float $errRate): array
    {
        $alphabets = $this->alphabetGeneratorService->prepareAlphabets($this->faker);
        return array_map(function ($index) use ($page, $size, $errRate, $alphabets) {
            $record = $this->generateSingleRecord($page, $size, $index);
            return $errRate > 0 ? $this->errService->applyErrorsToFields($record, $errRate, $alphabets) : $record;
        }, range(1, $size));
    }

    private function generateSingleRecord(int $page, int $size, int $index): array
    {
        return $this->dataRecordBuilder
            ->setPageDetails($page, $size, $index)->setUUID()
            ->setName()->setPhone()->setAddress()
            ->build();
    }
}