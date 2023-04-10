<?php

declare(strict_types=1);

namespace Partitura\Event\PostsLoading;

use Symfony\Component\Routing\RouteCollection;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * Class AfterEvent.
 */
class AfterEvent extends Event
{
    public function __construct(protected RouteCollection $routes)
    {
    }

    public function getRoutes(): RouteCollection
    {
        return $this->routes;
    }
}
