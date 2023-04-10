<?php

declare(strict_types=1);

namespace Partitura\Exception;

use Throwable;

/**
 * Class ForbiddenAccessException.
 */
class ForbiddenAccessException extends AuthenticationException
{
    public function __construct(
        string $message = "Access is forbidden for this user.",
        int $code = 0,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
