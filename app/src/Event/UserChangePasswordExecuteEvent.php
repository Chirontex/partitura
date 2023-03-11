<?php
declare(strict_types=1);

namespace Partitura\Event;

use Partitura\Dto\UserChangePasswordDto;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * Class UserChangePasswordExecuteEvent
 * @package Partitura\Event
 */
class UserChangePasswordExecuteEvent extends Event
{
    public function __construct(protected UserChangePasswordDto $userChangePasswordDto)
    {
    }

    /**
     * @return UserChangePasswordDto
     */
    public function getUserChangePasswordDto() : UserChangePasswordDto
    {
        return $this->userChangePasswordDto;
    }
}
