<?php
declare(strict_types=1);

namespace Partitura\Event\PostsLoading;

use Symfony\Component\Routing\RouteCollection;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * Class AfterEvent
 * @package Partitura\Event\PostsLoading
 */
class AfterEvent extends Event
{
    /** @var RouteCollection */
    protected $routes;

    public function __construct(RouteCollection $routes)
    {
        $this->routes = $routes;
    }

    /**
     * @return RouteCollection
     */
    public function getRoutes() : RouteCollection
    {
        return $this->routes;
    }
}
