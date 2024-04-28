<?php

namespace App\Service;

class ErrorGenerationService
{
    private iterable $strategies;
    private array $errorFields;

    public function __construct(iterable $strategies, array $errorFields) {
        $this->strategies = $strategies;
        $this->errorFields = $errorFields;
    }

    private function callRandomErrorFunc(string $record, string $alphabet)
    {
        $strategies = iterator_to_array($this->strategies);
        $strategy = $strategies[random_int(0, count($strategies) - 1)];
        return $strategy->applyError($record, $alphabet);
    }

    private function applyErrors($string, $numErrors, $alphabet)
    {
        for ($i = 0; $i < $numErrors; $i++) {
            $string = $this->callRandomErrorFunc($string, $alphabet);
        }
        return $string;
    }

    private function introduceErrors($string, $errors, $alphabet)
    {
        $errorCount = floor($errors);
        $string = $this->applyErrors($string, $errorCount, $alphabet);

        if (mt_rand() / mt_getrandmax() < $errors - $errorCount) {
            $string = $this->callRandomErrorFunc($string, $alphabet);
        }

        return $string;
    }

    public function applyErrorsToFields(array $str, float $errRate, array $alphabets): array
    {
        foreach ($this->errorFields as $field) {
            $alphabet = $field === 'Phone' ? $alphabets['numeric'] : $alphabets['text'];
            $str[$field] = $this->introduceErrors($str[$field] ?? '', $errRate, $alphabet);
        }
        return $str;
    }
}