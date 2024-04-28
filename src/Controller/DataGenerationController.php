<?php

namespace App\Controller;

use App\DTO\DataGenerationRequest;
use App\Service\DataGenerationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: "/data", name: "data_")]
class DataGenerationController extends AbstractController
{
    private DataGenerationService $dataGeneratorService;
    private RequestStack $requestStack;

    public function __construct(DataGenerationService $dataGeneratorService, RequestStack $requestStack)
    {
        $this->dataGeneratorService = $dataGeneratorService;
        $this->requestStack = $requestStack;
    }

    #[Route(path: "/generate", name: "generate", methods: ["GET"])]
    public function generate(): JsonResponse
    {
        $req = new DataGenerationRequest($this->requestStack);
        $data = $this->dataGeneratorService->generateData($req->getPage(), $req->getSize(), $req->getError());
        return new JsonResponse($data);
    }

}