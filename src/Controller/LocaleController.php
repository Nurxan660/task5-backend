<?php

namespace App\Controller;

use App\Service\LocaleService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: "/locales", name: "locales_")]
class LocaleController
{
    #[Route(path: "/get", name: "get", methods: ["GET"])]
    public function getLocales(LocaleService $localeService): JsonResponse
    {
        $locales = $localeService->getAvailableLocales();
        return new JsonResponse($locales);
    }
}