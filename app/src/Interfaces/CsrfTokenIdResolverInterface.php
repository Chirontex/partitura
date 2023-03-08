<?php

namespace Partitura\Interfaces;

use Partitura\Exception\EntityNotFoundException;

/**
 * Interface CsrfTokenIdResolverInterface
 * @package Partitura\Interfaces
 */
interface CsrfTokenIdResolverInterface
{
    /**
     * Returns CSRF token ID by route name.
     *
     * @param string $routeName
     *
     * @throws EntityNotFoundException Throws if route was not found by provided name.
     * @return string CSRF token ID associated with this route.
     */
    public function resolveCsrfTokenIdByRouteName(string $routeName) : string;
}
