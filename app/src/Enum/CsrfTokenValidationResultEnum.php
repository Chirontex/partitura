<?php

declare(strict_types=1);

namespace Partitura\Enum;

/**
 * Enum CsrfTokenValidationResultEnum
 * @package Partitura\Enum
 */
enum CsrfTokenValidationResultEnum : string
{
    case VALID = "valid";
    case INVALID = "invalid";
    case EMPTY = "empty";
}
