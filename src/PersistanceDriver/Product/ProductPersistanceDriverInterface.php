<?php

namespace App\PersistanceDriver\Product;

use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;
use App\PersistanceDriver\PersistanceDriverInterface;

#[AutoconfigureTag('app.product_persistance_driver')]
interface ProductPersistanceDriverInterface extends PersistanceDriverInterface
{
    public function setProducts(array $products): void;

    public function getProducts(): array;
}
