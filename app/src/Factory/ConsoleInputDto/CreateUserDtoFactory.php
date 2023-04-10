<?php

declare(strict_types=1);

namespace Partitura\Factory\ConsoleInputDto;

use Partitura\Dto\CreateUserDto;

/**
 * Class CreateUserDtoFactory.
 */
class CreateUserDtoFactory extends AbstractConsoleInputDtoFactory
{
    /** {@inheritDoc} */
    protected function getDtoClass(): string
    {
        return CreateUserDto::class;
    }
}
