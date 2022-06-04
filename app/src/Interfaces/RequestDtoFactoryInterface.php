<?php
declare(strict_types=1);

namespace Partitura\Interfaces;

use Symfony\Component\HttpFoundation\Request;

/**
 * @package Partitura\Interfaces
 */
interface RequestDtoFactoryInterface
{
    /**
     * Creates DTO from Request object.
     *
     * @param Request $request
     */
    public function createFromRequest(Request $request);

    /**
     * Returns DTO class name.
     *
     * @return string
     */
    public static function getDtoClass() : string;
}
