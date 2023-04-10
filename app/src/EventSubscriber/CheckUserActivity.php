<?php

declare(strict_types=1);

namespace Partitura\EventSubscriber;

use Partitura\Entity\User;
use Partitura\Exception\InactiveUserException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Http\Event\CheckPassportEvent;

/**
 * Class CheckUserActivity.
 */
class CheckUserActivity implements EventSubscriberInterface
{
    /** {@inheritDoc} */
    public static function getSubscribedEvents(): array
    {
        return [
            CheckPassportEvent::class => ["throwIfUserInactive", -10],
        ];
    }

    /**
     *
     * @throws AuthenticationException
     */
    public function throwIfUserInactive(CheckPassportEvent $event): void
    {
        $user = $event->getPassport()->getUser();

        if ($user instanceof User && !$user->isActive()) {
            throw new InactiveUserException();
        }
    }
}
