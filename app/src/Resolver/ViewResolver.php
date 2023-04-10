<?php

declare(strict_types=1);

namespace Partitura\Resolver;

use Partitura\Enum\RouteEnum;
use Partitura\Interfaces\ViewResolverInterface;

/**
 * Class ViewResolver.
 */
class ViewResolver implements ViewResolverInterface
{
    /** {@inheritDoc} */
    public function resolveViewByRoute(string $route): string
    {
        /** @var RouteEnum */
        $routeEnum = RouteEnum::getInstanceByValue($route);

        return $routeEnum->getView();
    }
}
