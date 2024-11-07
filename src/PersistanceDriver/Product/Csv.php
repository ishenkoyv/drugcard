<?php

namespace App\PersistanceDriver\Product;

use Symfony\Component\DependencyInjection\Attribute\Autowire;

class Csv extends ProductPersistanceDriver
{
    public function __construct(
        #[Autowire('%kernel.project_dir%/storage')]
        private string $dataDir
    ) {
    }

    public function save(): void
    {
        $filePath = $this->dataDir . '/products.csv';

        $products = $this->getProducts();

        foreach ($products as $product) {
            $file = fopen($filePath, 'a');

            fputcsv($file, [
                'name' => $product['name'],
                'price' => $product['price'],
                'imageUrl' => $product['imageUrl'],
                'productUrl' => $product['productUrl'],
            ]);

            fclose($file);
        }
    }
}
