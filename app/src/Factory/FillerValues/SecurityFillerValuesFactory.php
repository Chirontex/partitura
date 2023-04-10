<?php

declare(strict_types=1);

namespace Partitura\Factory\FillerValues;

class SecurityFillerValuesFactory extends ProfileFillerValuesFactory
{
    /** {@inheritDoc} */
    public static function getView(): string
    {
        return "genesis/profile/security.html.twig";
    }
}
