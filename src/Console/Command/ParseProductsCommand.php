<?php

namespace App\Console\Command;

use App\Message\StoreParsedData;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\DomCrawler\Crawler;
use App\Mapper\ProductMapper;
use App\Service\Infrastructure\ProductCrawler;
use Psr\Log\LoggerInterface;

#[AsCommand(
    name: 'app:parse-products',
    description: 'Parses products and stores them.'
)]
class ParseProductsCommand extends Command
{
    public function __construct(
        private MessageBusInterface $bus,
        private ProductCrawler $pc,
        private ProductMapper $pm,
        private LoggerInterface $logger
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $productsData = [];

        $productsArray = $this->pc->crawl();

        foreach ($productsArray as $productDetails) {
            $name = isset($productDetails['name']) ? $productDetails['name'] : '';
            $price = isset($productDetails['price']) ? floatval($productDetails['price']) : 0;
            $imageUrl = isset($productDetails['imageUrl']) ? $productDetails['imageUrl'] : '';
            $productUrl = isset($productDetails['productUrl']) ? $productDetails['productUrl'] : '';

            try {
                $dto = $this->pm->mapToDto([
                    'name' => $name,
                    'price' => $price,
                    'imageUrl' => $imageUrl,
                    'productUrl' => $productUrl,
                ]);
            } catch (\Exception $e) {
                $this->logger($e->getMessage());
            }

            $productsData[] = $dto->getProductData();
            echo sprintf("Processed product %s\n", $productDetails['name']);
        }

        $parsedData = new StoreParsedData($productsData);

        $this->bus->dispatch($parsedData);
        echo sprintf("Dispatched message\n");


        return self::SUCCESS;
    }
}
