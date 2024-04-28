<?php

namespace App\Service\ErrorStrategies;

class RemoveRandomSymbolStrategy implements ErrorStrategyInterface
{

    public function applyError(string $record, string $alphabet): string
    {
        if (mb_strlen($record) > 0) {
            $pos = random_int(0, mb_strlen($record) - 1);
            return mb_substr($record, 0, $pos) . mb_substr($record, $pos + 1);
        }
        return $record;
    }
}