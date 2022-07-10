<?php
declare(strict_types=1);

namespace Partitura\Factory\ConsoleInputDto;

use Partitura\Dto\CreateUserDto;

/**
 * Class CreateUserDtoFactory
 * @package Partitura\Factory\ConsoleInputDto
 */
class CreateUserDtoFactory extends AbstractConsoleInputDtoFactory
{
    /** {@inheritDoc} */
    protected function getDtoClass() : string
    {
        return CreateUserDto::class;
    }
}
