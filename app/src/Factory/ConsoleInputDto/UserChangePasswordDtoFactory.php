<?php

declare(strict_types=1);

namespace Partitura\Factory\ConsoleInputDto;

use Partitura\Dto\UserChangePasswordDto;

/**
 * Class UserChangePasswordDtoFactory.
 */
class UserChangePasswordDtoFactory extends AbstractConsoleInputDtoFactory
{
    /** {@inheritDoc} */
    protected function getDtoClass(): string
    {
        return UserChangePasswordDto::class;
    }
}
