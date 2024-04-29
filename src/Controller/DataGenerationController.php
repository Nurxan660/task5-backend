<?php

namespace App\Controller;

use App\DTO\DataGenerationRequest;
use App\Service\DataGenerationService;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route(path: "/data", name: "data_")]
class DataGenerationController extends AbstractController
{
    private DataGenerationService $dataGeneratorService;
    private RequestStack $requestStack;
    private LoggerInterface $logger;

    public function __construct(DataGenerationService $dataGeneratorService, RequestStack $requestStack, LoggerInterface $logger)
    {
        $this->dataGeneratorService = $dataGeneratorService;
        $this->requestStack = $requestStack;
        $this->logger = $logger;
    }

    #[Route(path: "/generate", name: "generate", methods: ["GET"])]
    public function generate(ValidatorInterface $validator): JsonResponse
    {
        $req = new DataGenerationRequest($this->requestStack);
        $errors = $validator->validate($req);
        if (count($errors) > 0) return new JsonResponse(['error' => (string)$errors], 400);
        $data = $this->dataGeneratorService->generateData($req->getPage(), $req->getSize(), $req->getError());
        return new JsonResponse($data);
    }
}