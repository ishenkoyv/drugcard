<?php

namespace App\DependencyInjection\Compiler;

use App\PersistanceDriver\Product\Chain as ProductPersistanceDriverChain;
use App\PersistanceDriver\Product\ProductPersistanceDriverInterface;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class ProductPersistanceDriver implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if (!$container->has(ProductPersistanceDriverChain::class)) {
            return;
        }

        $definition = $container->findDefinition(ProductPersistanceDriverChain::class);

        $taggedServices = $container->findTaggedServiceIds('app.product_persistance_driver');

        foreach ($taggedServices as $id => $tags) {
            $definition->addMethodCall('addPersistanceDriver', [new Reference($id)]);
        }
    }
}
