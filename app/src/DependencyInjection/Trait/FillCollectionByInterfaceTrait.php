<?php

declare(strict_types=1);

namespace Partitura\DependencyInjection\Trait;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Trait FillCollectionByInterfaceTrait
 */
trait FillCollectionByInterfaceTrait
{
    /**
     * @param string $keyGetter имя метода-геттера, возвращающего ключ для помещения в коллекцию
     *
     * @return ArrayCollection<string, Reference>
     */
    protected function getReferences(
        ContainerBuilder $container,
        string $inteface,
        string $keyGetter
    ): ArrayCollection {
        $result = new ArrayCollection();

        foreach ($container->getDefinitions() as $definition) {
            $class = $definition->getClass();

            if ($class === null || !class_exists($class)) {
                continue;
            }

            if (!in_array($inteface, class_implements($class), true)) {
                continue;
            }

            $key = $class::$keyGetter();

            if ($result->containsKey($key)) {
                continue;
            }

            $result->set($key, new Reference($class));
        }

        return $result;
    }
}
