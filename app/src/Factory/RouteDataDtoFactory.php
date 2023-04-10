<?php

declare(strict_types=1);

namespace Partitura\Factory;

use Doctrine\Common\Collections\ArrayCollection;
use Partitura\Dto\RouteDataDto;
use JMS\Serializer\ArrayTransformerInterface;
use Partitura\Interfaces\FillerValuesFactoryInterface;

/**
 * Class RouteDataDtoFactory.
 */
class RouteDataDtoFactory
{
    /** @var ArrayCollection<string, FillerValuesFactoryInterface> */
    protected ArrayCollection $fillerValuesFactoryCollection;

    public function __construct(protected ArrayTransformerInterface $arrayTransformer)
    {
        $this->fillerValuesFactoryCollection = new ArrayCollection();
    }

    /**
     *
     * @return $this
     */
    public function setFillerValueFactory(
        string $view,
        FillerValuesFactoryInterface $factory
    ): static {
        $this->fillerValuesFactoryCollection->set($view, $factory);

        return $this;
    }

    /**
     * Возвращает коллекцию DTO, созданных на основе данных из параметра routes_data.
     *
     * @param array<string, array<string, mixed>> $data
     *
     * @return array<string, RouteDataDto> имя маршрута также служит ключом для соответствующего DTO в массиве
     */
    public function createRouteDataDtoCollection(array $data): array
    {
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

            $dto->setFillerCallback(static function () use ($fillerValuesFactory): ArrayCollection {
                return $fillerValuesFactory->getFillerValuesCollection();
            });
        }

        return $result;
    }
}
