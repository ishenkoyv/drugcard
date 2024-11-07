<?php

namespace App\Message;

class StoreParsedData
{
    public function __construct(private array $products) {
    }

    public function getProducts(): array
    {
        return $this->products;
    }
}
