<?php
declare(strict_types=1);

namespace Partitura\Event\UserSaving;

use Partitura\Entity\User;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * Class UserSavingEvent
 * @package Partitura\Event\UserSaving
 */
abstract class UserSavingEvent extends Event
{
    /** @var User */
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return User
     */
    public function getUser() : User
    {
        return $this->user;
    }
}
