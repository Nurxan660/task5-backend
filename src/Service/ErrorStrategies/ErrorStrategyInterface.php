<?php

namespace App\Service\ErrorStrategies;

interface ErrorStrategyInterface
{
    public function applyError(string $record, string $alphabet): string;
}