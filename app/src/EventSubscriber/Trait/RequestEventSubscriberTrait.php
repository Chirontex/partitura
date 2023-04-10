<?php

declare(strict_types=1);

namespace Partitura\EventSubscriber\Trait;

use Symfony\Component\HttpFoundation\Request;

/**
 * Trait RequestEventSubscriberTrait
 */
trait RequestEventSubscriberTrait
{
    protected function isNeedJsonResponse(Request $request): bool
    {
        return $request->server->get("HTTP_ACCEPT") === "application/json"
            || explode("/", trim($request->getPathInfo(), "/"))[0] === "api";
    }
}
