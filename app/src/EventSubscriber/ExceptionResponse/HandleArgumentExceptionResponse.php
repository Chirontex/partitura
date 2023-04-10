<?php

declare(strict_types=1);

namespace Partitura\EventSubscriber\ExceptionResponse;

use Doctrine\Common\Collections\ArrayCollection;
use Partitura\Exception\ArgumentException;
use Partitura\Service\RouteDataGettingService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Twig\Environment;

/**
 * Class HandleArgumentExceptionResponse
 */
class HandleArgumentExceptionResponse extends AbstractHandleExceptionResponse
{
    public function __construct(
        protected RouteDataGettingService $routeDataGettingService,
        protected Environment $twig
    ) {
    }

    /** {@inheritDoc} */
    public static function getSubscribedEvents(): array
    {
        return ["kernel.exception" => ["handleExceptionResponse", -2]];
    }

    /** {@inheritDoc} */
    public function handleExceptionResponse(ExceptionEvent $event): void
    {
        if (!$this->isSubscriberRelevant($event)) {
            return;
        }

        $routeDataDto = $this->routeDataGettingService->getRouteDataByName($event->getRequest()->attributes->get("_route"));

        if ($routeDataDto === null) {
            return;
        }

        /** @var ArgumentException $exception */
        $exception = $event->getThrowable();
        $context = [
            "csrf_token_id" => $routeDataDto->getCsrfTokenId(),
            "errors" => $exception->getErrorMessages(),
        ];
        $fillerCallback = $routeDataDto->getFillerCallback();

        if ($fillerCallback !== null) {
            /** @var ArrayCollection */
            $fillerValues = $fillerCallback();
            $context = array_merge($context, $fillerValues->toArray());
        }

        $event->setResponse(new Response(
            $this->twig->render($routeDataDto->getView(), $context)
        ));
    }

    /** {@inheritDoc} */
    protected function isSubscriberRelevant(ExceptionEvent $event): bool
    {
        return $event->getResponse() === null
            && $event->getThrowable() instanceof ArgumentException;
    }
}
