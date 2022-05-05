<?php
declare(strict_types=1);

namespace Partitura\Interfaces;

use Partitura\Dto\CsrfTokenBaseDto;
use Symfony\Component\HttpFoundation\Request;

/**
 * @package Partitura\Interfaces
 */
interface CsrfTokenBaseFactoryInterface
{
    /**
     * @param null|Request $request
     *
     * @return CsrfTokenBaseDto
     */
    public function create(?Request $request = null) : CsrfTokenBaseDto;
}
