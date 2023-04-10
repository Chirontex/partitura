<?php

declare(strict_types=1);

namespace Partitura\Service;

use Doctrine\Common\Collections\ArrayCollection;
use Partitura\Kernel;
use Partitura\Dto\RouteDataDto;
use Partitura\Exception\InvalidArgumentException;
use Partitura\Factory\RouteDataDtoFactory;
use Partitura\Interfaces\RouteDataGettingServiceInterface;

/**
 * Class RouteDataGettingService
 */
class RouteDataGettingService implements RouteDataGettingServiceInterface
{
    /** @var null|ArrayCollection<string, RouteDataDto> */
    protected ?ArrayCollection $routeDataDtoCollection = null;

    public function __construct(
        protected RouteDataDtoFactory $routeDataDtoFactory
    ) {
    }

    /** {@inheritDoc} */
    public function getRouteDataByName(string $name): ?RouteDataDto
    {
        $this->initializeRouteDataDtoCollection();

        foreach ($this->routeDataDtoCollection as $routeName => $routeDataDto) {
            if ($routeName === $name || $routeDataDto->getName() === $name) {
                return $routeDataDto;
            }
        }

        return null;
    }

    protected function initializeRouteDataDtoCollection(): void
    {
        if (
            $this->routeDataDtoCollection instanceof ArrayCollection
            && !$this->routeDataDtoCollection->isEmpty()
        ) {
            return;
        }

        $this->routeDataDtoCollection = new ArrayCollection(
            $this->routeDataDtoFactory->createRouteDataDtoCollection(
                $this->getRoutesDataFromContainer()
            )
        );
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    protected function getRoutesDataFromContainer(): array
    {
        try {
            $data = $this->getRawRoutesDataFromContainer();
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
     *
     * @return array<string, array<string, mixed>>
     */
    protected function getRawRoutesDataFromContainer(): array
    {
        $dataRaw = Kernel::getInstance()->getParameter("routes_data");

        if (!is_array($dataRaw)) {
            throw new InvalidArgumentException("Data must be an array.");
        }

        return $dataRaw;
    }
}
