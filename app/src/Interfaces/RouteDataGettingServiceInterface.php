<?php

namespace Partitura\Interfaces;

use Partitura\Dto\RouteDataDto;

/**
 * Interface RouteDataGettingServiceInterface.
 */
interface RouteDataGettingServiceInterface
{
    /**
     * Возвращает данные о маршруте по его имени.
     *
     */
    public function getRouteDataByName(string $name): ?RouteDataDto;
}
