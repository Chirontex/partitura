<?php

declare(strict_types=1);

namespace Partitura\Interfaces;

use Symfony\Component\HttpFoundation\Request;

interface RequestDtoFactoryInterface
{
    /**
     * Creates DTO from Request object.
     *
     */
    public function createFromRequest(Request $request);

    /**
     * Returns DTO class name.
     *
     */
    public static function getDtoClass(): string;
}
