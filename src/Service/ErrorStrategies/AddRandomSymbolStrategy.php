<?php

namespace App\Service\ErrorStrategies;

use Random\RandomException;

class AddRandomSymbolStrategy implements ErrorStrategyInterface
{

    public function applyError(string $record, string $alphabet): string
    {
        $pos = random_int(0, mb_strlen($record));
        $index = random_int(0, mb_strlen($alphabet) - 1);
        $char = mb_substr($alphabet, $index, 1);
        return mb_substr($record, 0, $pos) . $char . mb_substr($record, $pos);
    }
}