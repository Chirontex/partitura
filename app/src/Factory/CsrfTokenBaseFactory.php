<?php
declare(strict_types=1);

namespace Partitura\Factory;

use Partitura\Dto\CsrfTokenBaseDto;
use Partitura\Interfaces\CsrfTokenBaseFactoryInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class CsrfTokenBaseFactory
 * @package Partitura\Factory
 */
class CsrfTokenBaseFactory implements CsrfTokenBaseFactoryInterface
{
    /** {@inheritDoc} */
    public function create(?Request $request = null) : CsrfTokenBaseDto
    {
        if ($request === null) {
            $request = Request::createFromGlobals();
        }

        return (new CsrfTokenBaseDto())
            ->setTokenBase(sprintf(
                "%s || %s",
                (string)$request->server->get("HTTP_USER_AGENT"),
                (string)$request->attributes->get("_route")
            ));
    }
}
