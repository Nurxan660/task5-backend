<?php

namespace App\Service\ErrorStrategies;

class SwapSymbolsStrategy implements ErrorStrategyInterface
{

    public function applyError(string $record, string $alphabet): string
    {
        $len = mb_strlen($record);
        if ($len > 1) {
            return $this->createSwappedString($record, random_int(0, $len - 2));
        }
        return $record;
    }

    private function createSwappedString(string $record, int $pos): string
    {
        return mb_substr($record, 0, $pos) .
            mb_substr($record, $pos + 1, 1) .
            mb_substr($record, $pos, 1) .
            mb_substr($record, $pos + 2);
    }
}