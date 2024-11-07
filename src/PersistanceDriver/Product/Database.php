<?php

namespace App\PersistanceDriver\Product;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Product;

class Database extends ProductPersistanceDriver
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }

    public function save(): void
    {
        $products = $this->getProducts();

        foreach ($products as $productData) {
            $product = new Product();
            $product->setName($productData['name']);
            $product->setPrice($productData['price']);
            $product->setImageUrl($productData['imageUrl']);
            $product->setProductUrl($productData['productUrl']);

            $this->entityManager->persist($product);
        }

        $this->entityManager->flush();
    }
}
