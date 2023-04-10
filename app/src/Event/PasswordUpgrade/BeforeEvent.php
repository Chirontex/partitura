<?php

declare(strict_types=1);

namespace Partitura\Event\PasswordUpgrade;

use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * Class BeforeEvent
 */
class BeforeEvent extends Event
{
    public function __construct(protected PasswordAuthenticatedUserInterface $user)
    {
    }

    public function getUser(): PasswordAuthenticatedUserInterface
    {
        return $this->user;
    }
}
