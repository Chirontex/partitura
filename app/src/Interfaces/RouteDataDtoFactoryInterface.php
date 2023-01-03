<?php

declare(strict_types=1);

namespace Partitura\Interfaces;

use Partitura\Dto\RouteDataDto;

/**
 * Interface RouteDataDtoFactoryInterface
 * @package Partitura\Interfaces
 */
interface RouteDataDtoFactoryInterface
{
    /**
     * Возвращает коллекцию DTO, созданных на основе данных из параметра routes_data.
     *
     * @return array<string, RouteDataDto> Имя маршрута также служит ключом для соответствующего DTO в массиве.
     */
    public function createRouteDataDtoCollection() : array;
}
