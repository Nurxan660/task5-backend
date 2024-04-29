<?php

namespace App\DTO;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Constraints as Assert;

class DataGenerationRequest
{
    #[Assert\NotBlank]
    private ?string $region;
    #[Assert\NotBlank]
    private ?int $seed;
    #[Assert\NotBlank]
    private ?int $page;
    #[Assert\NotBlank]
    #[Assert\LessThanOrEqual(value: 20)]
    private ?int $size;
    #[Assert\NotBlank]
    #[Assert\Range(min: 0, max: 1000)]
    private ?float $error;

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