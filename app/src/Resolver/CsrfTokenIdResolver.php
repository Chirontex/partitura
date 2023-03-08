<?php

declare(strict_types=1);

namespace Partitura\Resolver;

use Partitura\Exception\EntityNotFoundException;
use Partitura\Interfaces\CsrfTokenIdResolverInterface;
use Partitura\Service\RouteDataGettingService;

/**
 * Class CsrfTokenIdResolver
 * @package Partitura\Resolver
 */
class CsrfTokenIdResolver implements CsrfTokenIdResolverInterface
{
    public function __construct(
        protected RouteDataGettingService $routeDataGettingService
    ) { 
    }

    /** {@inheritDoc} */
    public function resolveCsrfTokenIdByRouteName(string $routeName) : string
    {
        $routeDataDto = $this->routeDataGettingService->getRouteDataByName($routeName);

        if ($routeDataDto === null) {
            throw new EntityNotFoundException(sprintf(
                "Route \"%s\" was not found.",
                $routeName
            ));
        }

        return $routeDataDto->getCsrfTokenId();
    }
}
