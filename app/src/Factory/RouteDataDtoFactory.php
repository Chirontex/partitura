<?php

declare(strict_types=1);

namespace Partitura\Factory;

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

    public function __construct(ArrayTransformerInterface $arrayTransformer)
    {
        $this->arrayTransformer = $arrayTransformer;
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
