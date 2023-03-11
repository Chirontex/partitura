<?php

declare(strict_types=1);

namespace Partitura\EventSubscriber;

use Partitura\Enum\CsrfTokenValidationResultEnum;
use Partitura\Event\Form\CsrfTokenValidationEvent;
use Partitura\Exception\LogicException;
use Partitura\Service\CsrfTokenValidationService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class CheckCsrfToken
 * @package Partitura\EventSubscriber
 */
class CheckCsrfToken implements EventSubscriberInterface
{
    public function __construct(protected CsrfTokenValidationService $csrfTokenValidationService)
    {
    }

    /** {@inheritDoc} */
    public static function getSubscribedEvents() : array
    {
        return [CsrfTokenValidationEvent::class => ["checkToken", PHP_INT_MAX]];
    }

    /**
     * @param CsrfTokenValidationEvent $event
     */
    public function checkToken(CsrfTokenValidationEvent $event) : void
    {
        $requestDto = $event->getRequestDto();

        if ($requestDto === null) {
            return;
        }

        try {
            $event->setCsrfTokenValidationResult(
                $this->csrfTokenValidationService->isFormRequestDtoTokenValid($requestDto)
                    ? CsrfTokenValidationResultEnum::VALID
                    : CsrfTokenValidationResultEnum::INVALID
            );
        } catch (LogicException) {
            $event->setCsrfTokenValidationResult(CsrfTokenValidationResultEnum::EMPTY);
        }
    }
}
