<?php
declare(strict_types=1);

namespace Partitura\Enum;

use Partitura\Exception\CaseNotFoundException;

/**
 * @package Partitura\Enum
 */
enum PostTypeEnum : string
{
    case PUBLISHED = "published";
    case DRAFT = "draft";
    case TRASH = "trash";

    /**
     * @param string $value
     *
     * @return self
     */
    public static function getInstanceByValue(string $value) : self
    {
        foreach (self::cases() as $case) {
            if ($case->value === $value) {
                return $case;
            }
        }

        throw new CaseNotFoundException(sprintf(
            "Post type \"%s\" was not found.",
            $value
        ));
    }
}
