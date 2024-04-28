<?php

namespace App\Controller;

use App\Service\ExportService;
use League\Csv\CannotInsertRecord;
use League\Csv\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ExportController extends AbstractController
{
    private ExportService $exportService;

    public function __construct(ExportService $exportService) {
        $this->exportService = $exportService;
    }

    /**
     * @throws CannotInsertRecord
     * @throws Exception
     */
    #[Route(path: "/get/csv", name: "get_csv", methods: ["POST"])]
    public function getCsv(Request $request): Response
    {
        $jsonContent = $request->getContent();
        $csv = $this->exportService->exportToCsv($jsonContent);
        return $this->createCsvResponse($csv, 'data.csv');
    }

    private function createCsvResponse(string $content, string $filename): Response
    {
        $response = new Response($content);
        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="' . $filename . '"');
        return $response;
    }
}