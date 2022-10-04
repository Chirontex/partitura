<?php
declare(strict_types=1);

namespace Partitura\EventSubscriber\Profile\MainInfo;

use Partitura\Event\Form\Profile\MainInfoHandlingStartEvent;
use Partitura\Exception\ArgumentException;
use Partitura\Factory\RequestDto\Form\Profile\MainInfoRequestDtoFactory;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class CreateRequestDto
 * @package Partitura\EventSubscriber\Profile\MainInfo
 */
class CreateRequestDto implements EventSubscriberInterface
{
    /** @var MainInfoRequestDtoFactory */
    protected $requestDtoFactory;

    public function __construct(MainInfoRequestDtoFactory $requestDtoFactory)
    {
        $this->requestDtoFactory = $requestDtoFactory;
    }

    /** {@inheritDoc} */
    public static function getSubscribedEvents() : array
    {
        return [MainInfoHandlingStartEvent::class => "setRequestDtoToEvent"];
    }

    /**
     * @param MainInfoHandlingStartEvent $event
     * 
     * @throws ArgumentException
     */
    public function setRequestDtoToEvent(MainInfoHandlingStartEvent $event) : void
    {
        if ($event->getRequestDto() !== null) {
            return;
        }

        $event->setRequestDto(
            $this->requestDtoFactory->createFromRequest($event->getSymfonyRequest())
        );
    }
}
