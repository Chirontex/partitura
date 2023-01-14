<?php

declare(strict_types=1);

namespace Partitura\Factory;

use Doctrine\Common\Collections\ArrayCollection;
use Partitura\Dto\RouteDataDto;
use Partitura\Interfaces\RouteDataDtoFactoryInterface;
use Partitura\Kernel;
use JMS\Serializer\ArrayTransformerInterface;
use Partitura\Interfaces\FillerValuesFactoryInterface;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;

/**
 * Class RouteDataDtoFactory
 * @package Partitura\Factory
 */
class RouteDataDtoFactory implements RouteDataDtoFactoryInterface
{
    protected ArrayTransformerInterface $arrayTransformer;

    /** @var ArrayCollection<string, FillerValuesFactoryInterface> */
    protected ArrayCollection $fillerValuesFactoryCollection;

    public function __construct(ArrayTransformerInterface $arrayTransformer)
    {
        $this->arrayTransformer = $arrayTransformer;
        $this->fillerValuesFactoryCollection = new ArrayCollection();
    }

    /**
     * @param string $view
     * @param FillerValuesFactoryInterface $factory
     *
     * @return $this
     */
    public function setFillerValueFactory(
        string $view,
        FillerValuesFactoryInterface $factory
    ) : static {
        $this->fillerValuesFactoryCollection->set($view, $factory);

        return $this;
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
            $view = $dto->getView();

            if (
                empty($view)
                || !$this->fillerValuesFactoryCollection->containsKey($view)
            ) {
                continue;
            }

            /** @var FillerValuesFactoryInterface $fillerValuesFactory */
            $fillerValuesFactory = $this->fillerValuesFactoryCollection->get($view);

            $dto->setFillerCallback(static function() use ($fillerValuesFactory) : ArrayCollection {
                return $fillerValuesFactory->getFillerValuesCollection();
            });
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
