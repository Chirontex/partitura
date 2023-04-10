<?php

declare(strict_types=1);

namespace Partitura\Event;

use Partitura\Dto\CreateUserDto;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * Class UserCreateCommandExecuteEvent
 */
class UserCreateCommandExecuteEvent extends Event
{
    public function __construct(protected CreateUserDto $createUserDto)
    {
    }

    public function getCreateUserDto(): CreateUserDto
    {
        return $this->createUserDto;
    }
}
