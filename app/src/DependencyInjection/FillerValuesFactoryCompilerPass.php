<?php

declare(strict_types=1);

namespace Partitura\DependencyInjection;

use Partitura\DependencyInjection\Trait\FillCollectionByInterfaceTrait;
use Partitura\Factory\RouteDataDtoFactory;
use Partitura\Interfaces\FillerValuesFactoryInterface;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class FillerValuesFactoryCompilerPass implements CompilerPassInterface
{
    use FillCollectionByInterfaceTrait;

    /** {@inheritDoc} */
    public function process(ContainerBuilder $container): void
    {
        $routeDataDtoFactoryDefinition = $container->getDefinition(RouteDataDtoFactory::class);
        $references = $this->getReferences(
            $container,
            FillerValuesFactoryInterface::class,
            "getView"
        );

        foreach ($references as $view => $reference) {
            $routeDataDtoFactoryDefinition->addMethodCall(
                "setFillerValueFactory",
                [$view, $reference]
            );
        }
    }
}
