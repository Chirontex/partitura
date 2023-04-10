<?php

declare(strict_types=1);

namespace Partitura\Enum\Trait;

use Partitura\Exception\CaseNotFoundException;

/**
 * Trait GetInstanceByValueTrait
 *
 * @method static[] cases()
 */
trait GetInstanceByValueTrait
{
    /**
     *
     * @throws CaseNotFoundException
     */
    public static function getInstanceByValue($value): self
    {
        foreach (self::cases() as $case) {
            if ($case->value === $value) {
                return $case;
            }
        }

        throw new CaseNotFoundException(sprintf(
            "Case with value \"%s\" was not found.",
            $value
        ));
    }
}
