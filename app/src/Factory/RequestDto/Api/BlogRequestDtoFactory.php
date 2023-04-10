<?php

declare(strict_types=1);

namespace Partitura\Factory\RequestDto\Api;

use Partitura\Dto\Api\BlogRequestDto;
use Partitura\Factory\RequestDto\AbstractRequestDtoFactory;

/**
 * Class BlogRequestDtoFactory.
 */
class BlogRequestDtoFactory extends AbstractRequestDtoFactory
{
    /** {@inheritDoc} */
    public static function getDtoClass(): string
    {
        return BlogRequestDto::class;
    }
}
