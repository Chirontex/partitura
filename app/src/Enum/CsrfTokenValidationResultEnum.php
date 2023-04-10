<?php

declare(strict_types=1);

namespace Partitura\Enum;

/**
 * Enum CsrfTokenValidationResultEnum
 */
enum CsrfTokenValidationResultEnum: string
{
    case VALID = "valid";
    case INVALID = "invalid";
    case EMPTY = "empty";
}
