<?php

declare(strict_types=1);

namespace Partitura\Factory\RequestDto\Form\Profile\Security;

use Partitura\Dto\Form\Profile\Security\DropRememberMeTokensRequestDto;
use Partitura\Factory\RequestDto\AbstractRequestDtoFactory;

/**
 * Class DropRememberMeTokensRequestDtoFactory
 */
class DropRememberMeTokensRequestDtoFactory extends AbstractRequestDtoFactory
{
    /** {@inheritDoc} */
    public static function getDtoClass(): string
    {
        return DropRememberMeTokensRequestDto::class;
    }
}
