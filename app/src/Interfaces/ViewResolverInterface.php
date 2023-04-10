<?php

namespace Partitura\Interfaces;

use Partitura\Exception\CaseNotFoundException;

/**
 * Interface ViewResolverInterface.
 */
interface ViewResolverInterface
{
    /**
     * Returns view template path by route name.
     *
     * @param string $route route name
     *
     * @throws CaseNotFoundException throws if view or route was not found
     *
     * @return string view template file path
     */
    public function resolveViewByRoute(string $route): string;
}
