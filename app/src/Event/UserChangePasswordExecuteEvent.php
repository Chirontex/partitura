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
    /** @var UserChangePasswordDto */
    protected $userChangePasswordDto;

    public function __construct(UserChangePasswordDto $userChangePasswordDto)
    {
        $this->userChangePasswordDto = $userChangePasswordDto;
    }

    /**
     * @return UserChangePasswordDto
     */
    public function getUserChangePasswordDto() : UserChangePasswordDto
    {
        return $this->userChangePasswordDto;
    }
}
