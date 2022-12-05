<?php
declare(strict_types=1);

namespace Partitura\EventSubscriber\Profile\Security;

use Partitura\Event\Form\Profile\SecurityHandlingStartEvent;
use Partitura\Exception\ArgumentException;
use Partitura\Factory\RequestDto\AbstractRequestDtoFactory;
use Partitura\Factory\RequestDto\Form\Profile\Security\ChangePasswordRequestDtoFactory;
use Partitura\Factory\RequestDto\Form\Profile\Security\DropRememberMeTokensRequestDtoFactory;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class CreateRequestDto
 * @package Partitura\EventSubscriber\Profile\Security
 */
class CreateRequestDto implements EventSubscriberInterface
{
    /** @var AbstractRequestDtoFactory[] */
    protected $requestDtoFactories = [];

    public function __construct(
        ChangePasswordRequestDtoFactory $changePasswordRequestDtoFactory,
        DropRememberMeTokensRequestDtoFactory $dropRememberMeTokensRequestDtoFactory
    ) {
        $this->requestDtoFactories = [
            $changePasswordRequestDtoFactory,
            $dropRememberMeTokensRequestDtoFactory,
        ];
    }

    /** {@inheritDoc} */
    public static function getSubscribedEvents() : array
    {
        return [SecurityHandlingStartEvent::class => "createDto"];
    }

    /**
     * @param SecurityHandlingStartEvent $event
     */
    public function createDto(SecurityHandlingStartEvent $event) : void
    {
        if ($event->getRequestDto() !== null) {
            return;
        }

        $request = $event->getSymfonyRequest();

        foreach ($this->requestDtoFactories as $factory) {
            try {
                $event->setRequestDto($factory->createFromRequest($request));

                break;
            } catch (ArgumentException) {
                // nothing to do here
            }
        }
    }
}
