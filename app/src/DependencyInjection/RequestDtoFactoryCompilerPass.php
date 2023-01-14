<?php
declare(strict_types=1);

namespace Partitura\DependencyInjection;

use Partitura\DependencyInjection\Trait\FillCollectionByInterfaceTrait;
use Partitura\Interfaces\RequestDtoFactoryInterface;
use Partitura\Locator\RequestDtoFactoryLocator;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class RequestDtoFactoryCompilerPass implements CompilerPassInterface
{
    use FillCollectionByInterfaceTrait;

    /** {@inheritDoc} */
    public function process(ContainerBuilder $container) : void
    {
        $locatorDefinition = $container->getDefinition(RequestDtoFactoryLocator::class);
        $references = $this->getReferences(
            $container,
            RequestDtoFactoryInterface::class,
            "getDtoClass"
        );

        foreach ($references as $dtoClassName => $reference) {
            $locatorDefinition->addMethodCall("addFactory", [$dtoClassName, $reference]);
        }
    }
}
