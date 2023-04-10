<?php

declare(strict_types=1);

namespace Partitura\Exception;

use Throwable;

/**
 * Class InvalidCredentialsException.
 */
class InvalidCredentialsException extends AuthenticationException
{
    public function __construct(
        string $message = "Invalid credentials.",
        int $code = 0,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
