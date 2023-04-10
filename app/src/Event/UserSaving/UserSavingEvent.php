<?php

declare(strict_types=1);

namespace Partitura\Event\UserSaving;

use Partitura\Entity\User;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * Class UserSavingEvent
 */
abstract class UserSavingEvent extends Event
{
    public function __construct(protected User $user)
    {
    }

    public function getUser(): User
    {
        return $this->user;
    }
}
