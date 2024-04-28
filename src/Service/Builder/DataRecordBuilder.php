<?php

namespace App\Service\Builder;

use App\Provider\CustomAddressProvider;
use Faker\Generator;

class DataRecordBuilder
{
    private array $data = [];
    private Generator $faker;
    private CustomAddressProvider $customProvider;

    public function __construct(Generator $faker) {
        $this->faker = $faker;
        $this->customProvider = new CustomAddressProvider($faker);
    }

    public function setPageDetails(int $page, int $size, int $index): self {
        $num = ($page - 1) * $size + $index;
        $size === 10 ? $num += 10 : null;
        $this->data['Number'] = $num;
        return $this;
    }

    public function setUUID(): self {
        $this->data['UUID'] = $this->faker->uuid();
        return $this;
    }

    public function setName(): self {
        $this->data['Name'] = $this->faker->name();
        return $this;
    }

    public function setPhone(): self {
        $this->data['Phone'] = $this->faker->phoneNumber();
        return $this;
    }

    public function setAddress(): self {
        $this->data['Address'] = $this->customProvider->getCustomAddress();
        return $this;
    }

    public function build(): array {
        return $this->data;
    }
}