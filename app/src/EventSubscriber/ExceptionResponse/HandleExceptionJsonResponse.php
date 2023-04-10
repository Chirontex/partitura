<?php

declare(strict_types=1);

namespace Partitura\EventSubscriber\ExceptionResponse;

use Partitura\EventSubscriber\Trait\RequestEventSubscriberTrait;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

/**
 * Class HandleExceptionJsonResponse.
 */
class HandleExceptionJsonResponse extends AbstractHandleExceptionResponse
{
    use RequestEventSubscriberTrait;

    /** {@inheritDoc} */
    public function handleExceptionResponse(ExceptionEvent $event): void
    {
        if (!$this->isSubscriberRelevant($event)) {
            return;
        }

        $exception = $event->getThrowable();

        $event->setResponse(new JsonResponse(
            ["message" => $exception->getMessage()],
            $this->getResponseCode($exception)
        ));
    }

    /** {@inheritDoc} */
    protected function isSubscriberRelevant(ExceptionEvent $event): bool
    {
        return $this->isNeedJsonResponse($event->getRequest());
    }
}
