<?php

namespace Partitura\Interfaces;

use Partitura\Dto\RouteDataDto;

/**
 * Interface RouteDataGettingServiceInterface
 * @package Partitura\Interfaces
 */
interface RouteDataGettingServiceInterface
{
    /**
     * Возвращает данные о маршруте по его имени.
     *
     * @param string $name
     *
     * @return null|RouteDataDto
     */
    public function getRouteDataByName(string $name) : ?RouteDataDto;
}
