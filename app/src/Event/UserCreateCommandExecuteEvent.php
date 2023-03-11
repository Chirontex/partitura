<?php
declare(strict_types=1);

namespace Partitura\Event;

use Partitura\Dto\CreateUserDto;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * Class UserCreateCommandExecuteEvent
 * @package Partitura\Event
 */
class UserCreateCommandExecuteEvent extends Event
{
    public function __construct(protected CreateUserDto $createUserDto)
    {
    }

    /**
     * @return CreateUserDto
     */
    public function getCreateUserDto() : CreateUserDto
    {
        return $this->createUserDto;
    }
}
