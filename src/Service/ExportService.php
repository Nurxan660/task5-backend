<?php

namespace App\Service;


use League\Csv\CannotInsertRecord;
use League\Csv\Exception;
use League\Csv\Writer;

class ExportService
{
    /**
     * @throws CannotInsertRecord
     * @throws Exception
     */
    public function exportToCsv(string $jsonData): Writer
    {
        $csv = Writer::createFromString('');
        $csv->insertAll(json_decode($jsonData, true));
        return $csv;
    }
}