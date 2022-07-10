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
    /** @var CreateUserDto */
    protected $createUserDto;

    public function __construct(CreateUserDto $createUserDto)
    {
        $this->createUserDto = $createUserDto;
    }

    /**
     * @return CreateUserDto
     */
    public function getCreateUserDto() : CreateUserDto
    {
        return $this->createUserDto;
    }
}
