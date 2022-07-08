<?php
declare(strict_types=1);

namespace Partitura\EventSubscriber\Trait;

use Symfony\Component\HttpFoundation\Request;

/**
 * Trait RequestEventSubscriberTrait
 * @package Partitura\EventSubscriber\Trait
 */
trait RequestEventSubscriberTrait
{
    /**
     * @param Request $request
     *
     * @return bool
     */
    protected function isNeedJsonResponse(Request $request) : bool
    {
        return $request->get("Accept") === "application/json"
            || explode("/", trim($request->getPathInfo(), "/"))[0] === "api";
    }
}
