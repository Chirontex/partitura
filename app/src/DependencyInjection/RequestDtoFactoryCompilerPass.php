<?php
declare(strict_types=1);

namespace Partitura\DependencyInjection;

use Doctrine\Common\Collections\ArrayCollection;
use Partitura\Interfaces\RequestDtoFactoryInterface;
use Partitura\Locator\RequestDtoFactoryLocator;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class RequestDtoFactoryCompilerPass implements CompilerPassInterface
{
    /** {@inheritDoc} */
    public function process(ContainerBuilder $container) : void
    {
        $locatorDefinition = $container->getDefinition(RequestDtoFactoryLocator::class);
        $references = $this->getReferences($container);

        foreach ($references as $dtoClassName => $reference) {
            $locatorDefinition->addMethodCall("addFactory", [$dtoClassName, $reference]);
        }
    }

    /**
     * @param ContainerBuilder $container
     *
     * @return ArrayCollection<string, Reference>
     */
    protected function getReferences(ContainerBuilder $container) : ArrayCollection
    {
        $result = new ArrayCollection();

        foreach ($container->getDefinitions() as $definition) {
            $class = $definition->getClass();

            if ($class === null || !class_exists($class)) {
                continue;
            }

            if (!in_array(RequestDtoFactoryInterface::class, class_implements($class), true)) {
                continue;
            }

            $dtoClassName = $class::getDtoClass();

            if ($result->containsKey($dtoClassName)) {
                continue;
            }

            $result->set($dtoClassName, new Reference($class));
        }

        return $result;
    }
}
