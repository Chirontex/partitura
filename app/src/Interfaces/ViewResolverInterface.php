<?php

namespace Partitura\Interfaces;

use Partitura\Exception\CaseNotFoundException;

/**
 * Interface ViewResolverInterface
 * @package Partitura\Interfaces
 */
interface ViewResolverInterface
{
    /**
     * Returns view template path by route name.
     *
     * @param string $route Route name.
     *
     * @throws CaseNotFoundException Throws if view or route was not found.
     * @return string View template file path.
     */
    public function resolveViewByRoute(string $route) : string;
}
