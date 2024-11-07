<?php

namespace App\MessageHandler;

use App\Message\StoreParsedData;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use App\PersistanceDriver\Product\Chain as ProductPersistanceDriverChain;

#[AsMessageHandler]
class StoreParsedDataConsumer
{
    public function __construct(
        private ProductPersistanceDriverChain $persistanceChain,
    ) {
    }

    public function __invoke(
        StoreParsedData $message
    ): void {
        $products = $message->getProducts();

        foreach ($this->persistanceChain->getPersistanceDrivers() as $persistanceDriver) {
            $persistanceDriver->setProducts($products);
            $persistanceDriver->save();
        }
    }
}
