<?php

namespace App\DTO;

use Symfony\Component\HttpFoundation\RequestStack;

class DataGenerationRequest
{
    private string $region;
    private int $seed;
    private int $page;
    private int $size;
    private int $error;

    public function __construct(RequestStack $requestStack)
    {
        $query = $requestStack->getCurrentRequest();
        $this->region = $query->get('region');
        $this->seed = $query->get('seed');
        $this->page = $query->get('page');
        $this->size = $query->get('size');
        $this->error = $query->get('error');
    }

    public function getRegion(): string
    {
        return $this->region;
    }

    public function getSeed(): int
    {
        return $this->seed + $this->page;
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function getSize(): int
    {
        return $this->size;
    }

    public function getError(): int
    {
        return $this->error;
    }




}