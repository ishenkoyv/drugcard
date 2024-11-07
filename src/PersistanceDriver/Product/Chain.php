<?php

namespace App\PersistanceDriver\Product;

class Chain
{
    private array $drivers = [];

    public function addPersistanceDriver(ProductPersistanceDriverInterface $driver): void
    {
        $this->drivers[] = $driver;
    }

    public function getPersistanceDrivers(): array
    {
        return $this->drivers;
    }
}
