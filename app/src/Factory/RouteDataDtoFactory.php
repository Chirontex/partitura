<?php

declare(strict_types=1);

namespace Partitura\Factory;

use Doctrine\Common\Collections\ArrayCollection;
use Partitura\Dto\RouteDataDto;
use Partitura\Interfaces\RouteDataDtoFactoryInterface;
use Partitura\Kernel;
use JMS\Serializer\ArrayTransformerInterface;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;

/**
 * Class RouteDataDtoFactory
 * @package Partitura\Factory
 */
class RouteDataDtoFactory implements RouteDataDtoFactoryInterface
{
    protected ArrayTransformerInterface $arrayTransformer;

    protected ArrayCollection $fillerObjectCollection;

    public function __construct(
        ArrayTransformerInterface $arrayTransformer,
        ...$fillerObjects
    ) {
        $this->arrayTransformer = $arrayTransformer;
        $this->fillerObjectCollection = new ArrayCollection();

        foreach ($fillerObjects as $fillerObject) {
            $this->fillerObjectCollection->set(get_class($fillerObject), $fillerObject);
        }
    }

    /** {@inheritDoc} */
    public function createRouteDataDtoCollection() : array
    {
        $data = $this->getRoutesData();

        if (empty($data)) {
            return [];
        }

        /** @var RouteDataDto[] $data */
        $data = $this->arrayTransformer->fromArray($data, sprintf("array<%s>", RouteDataDto::class));
        $result = [];

        foreach ($data as $dto) {
            $result[$dto->getName()] = $dto;
            $filler = $dto->getFiller();

            if (empty($filler)) {
                continue;
            }

            if (count($filler) === 1) {
                $dto->setFillerCallback(static function() use ($dto) {
                    return (string)reset($dto->getFiller())();
                });
            } elseif (count($filler) > 1) {
                [$class, $method] = $filler;

                if ($this->fillerObjectCollection->containsKey($class)) {
                    $fillerObject = $this->fillerObjectCollection->get($class);

                    $dto->setFillerCallback(static function() use ($fillerObject, $method) {
                        return $fillerObject->$method();
                    });
                } else {
                    $dto->setFillerCallback(static function() use ($class, $method) {
                        return $class::$method();
                    });
                }
            }
        }

        return $result;
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    protected function getRoutesData() : array
    {
        try {
            $data = $this->getRawRoutesData();
        } catch (InvalidArgumentException) {
            return [];
        }

        foreach ($data as $routeName => $routeData) {
            $data[$routeName] = array_merge(["name" => $routeName], $routeData);
        }

        return $data;
    }

    /**
     * @throws InvalidArgumentException
     * @return array<string, array<string, mixed>>
     */
    protected function getRawRoutesData() : array
    {
        $dataRaw = Kernel::getInstance()->getParameter("routes_data");

        if (!is_array($dataRaw)) {
            throw new InvalidArgumentException("Data must be an array.");
        }

        return $dataRaw;
    }
}
