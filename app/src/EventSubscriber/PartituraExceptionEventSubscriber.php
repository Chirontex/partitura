<?php
declare(strict_types=1);

namespace Partitura\EventSubscriber;

use InvalidArgumentException;
use Partitura\EventSubscriber\Trait\RequestEventSubscriberTrait;
use Partitura\Exception\ArgumentException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Throwable;

/**
 * Class PartituraExceptionEventSubscriber
 * @package Partitura\EventSubscriber
 */
class PartituraExceptionEventSubscriber implements EventSubscriberInterface
{
    use RequestEventSubscriberTrait;

    /** {@inheritDoc} */
    public static function getSubscribedEvents() : array
    {
        return ["kernel.exception" => ["handleException", -1]];
    }

    /**
     * @param ExceptionEvent $event
     */
    public function handleException(ExceptionEvent $event) : void
    {
        $e = $event->getThrowable();

        if ($this->isNeedJsonResponse($event->getRequest())) {
            $event->setResponse(new JsonResponse(
                ["message" => $e->getMessage()],
                $this->getResponseCode($e)
            ));
        }
    }

    /**
     * @param Throwable $e
     *
     * @return int
     */
    protected function getResponseCode(Throwable $e) : int
    {
        if ($e->getCode() > 399) {
            return $e->getCode();
        }

        switch (get_class($e)) {
            case ArgumentException::class:
            case InvalidArgumentException::class:
                return 400;

            default:
                return 500;
        }
    }
}
