<?php
declare(strict_types=1);

namespace Partitura\Factory\ConsoleInputDto;

use Partitura\Dto\UserChangePasswordDto;

/**
 * Class UserChangePasswordDtoFactory
 * @package Partitura\Factory\ConsoleInputDto
 */
class UserChangePasswordDtoFactory extends AbstractConsoleInputDtoFactory
{
    /** {@inheritDoc} */
    protected function getDtoClass() : string
    {
        return UserChangePasswordDto::class;
    }
}
