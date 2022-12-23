<?php

declare(strict_types=1);

namespace Partitura\EventSubscriber\ExceptionResponse;

use InvalidArgumentException;
use Partitura\Exception\ArgumentException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Throwable;

/**
 * Class AbstractHandleExceptionResponse
 * @package Partitura\EventSubscriber\ExceptionResponse
 */
abstract class AbstractHandleExceptionResponse implements EventSubscriberInterface
{
    /** {@inheritDoc} */
    public static function getSubscribedEvents() : array
    {
        return ["kernel.exception" => ["handleExceptionResponse", -1]];
    }

    /**
     * @param ExceptionEvent $event
     */
    abstract public function handleExceptionResponse(ExceptionEvent $event) : void;

    /**
     * @param ExceptionEvent $event
     *
     * @return bool
     */
    protected function isSubscriberRelevant(ExceptionEvent $event) : bool
    {
        return true;
    }

    protected function getResponseCode(Throwable $exception) : int
    {
        if ($exception->getCode() > 399) {
            return $exception->getCode();
        }

        return match (get_class($exception)) {
            default => Response::HTTP_INTERNAL_SERVER_ERROR,
            ArgumentException::class => Response::HTTP_BAD_REQUEST,
            InvalidArgumentException::class => Response::HTTP_BAD_REQUEST,
        };
    }
}
