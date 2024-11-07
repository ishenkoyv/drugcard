<?php

namespace App\PersistanceDriver\Product;

abstract class ProductPersistanceDriver implements ProductPersistanceDriverInterface
{
    protected array $products = [];

    public function setProducts(array $products): void
    {
        $this->products = $products;
    }

    public function getProducts(): array
    {
        return $this->products;
    }
}
