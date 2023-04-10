<?php

declare(strict_types=1);

namespace Partitura\Exception;

use Throwable;

/**
 * Class InactiveUserException.
 */
class InactiveUserException extends AuthenticationException
{
    public function __construct(
        string $message = "User is inactive",
        int $code = 0,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
