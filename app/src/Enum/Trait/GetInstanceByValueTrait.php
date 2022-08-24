<?php
declare(strict_types=1);

namespace Partitura\Enum\Trait;

use Partitura\Exception\CaseNotFoundException;

/**
 * Trait GetInstanceByValueTrait
 * @package Partitura\Enum\Trait
 * 
 * @method static[] cases()
 */
trait GetInstanceByValueTrait
{
    /**
     * @param mixed $value
     *
     * @throws CaseNotFoundException
     * @return self
     */
    public static function getInstanceByValue($value) : self
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
