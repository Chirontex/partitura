<?php

namespace Partitura\Interfaces;

use Partitura\Exception\EntityNotFoundException;

/**
 * Interface CsrfTokenIdResolverInterface
 */
interface CsrfTokenIdResolverInterface
{
    /**
     * Returns CSRF token ID by route name.
     *
     * @throws EntityNotFoundException throws if route was not found by provided name
     *
     * @return string CSRF token ID associated with this route
     */
    public function resolveCsrfTokenIdByRouteName(string $routeName): string;
}
