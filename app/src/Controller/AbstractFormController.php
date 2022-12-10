<?php
declare(strict_types=1);

namespace Partitura\Controller;

use Partitura\Event\Form\CsrfTokenValidationEvent;
use Partitura\Event\Form\RequestDtoHandleEvent;
use Partitura\Exception\ForbiddenAccessException;
use Partitura\Exception\InvalidArgumentException;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Class AbstractFormController
 * @package Partitura\Controller
 */
abstract class AbstractFormController extends Controller
{
    /** @var EventDispatcherInterface */
    protected $eventDispatcher;

    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @param RequestDtoHandleEvent $requestDtoHandleEvent
     *
     * @throws AccessDeniedException
     * @throws InvalidArgumentException
     * @return array<string, mixed>
     */
    protected function processForm(RequestDtoHandleEvent $requestDtoHandleEvent) : array
    {
        $requestDto = $requestDtoHandleEvent->getRequestDto();

        if ($requestDto !== null) {
            $csrfTokenValidationEvent = new CsrfTokenValidationEvent($requestDto);

            $this->eventDispatcher->dispatch($csrfTokenValidationEvent);

            $csrfTokenValidationResult = $csrfTokenValidationEvent->getCsrfTokenValidationResult();

            if ($csrfTokenValidationResult !== null) {
                $requestDtoHandleEvent->setCsrfTokenValidationResult($csrfTokenValidationResult);
            }

            try {
                $this->eventDispatcher->dispatch($requestDtoHandleEvent);
            } catch (ForbiddenAccessException $e) {
                throw $this->createAccessDeniedException($e->getMessage(), $e);
            }

            return $requestDtoHandleEvent->getResponseParameters()->toArray();
        }

        return [];
    }
}
