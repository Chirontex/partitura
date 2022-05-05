<?php
declare(strict_types=1);

namespace Partitura\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

/**
 * Abstract controller.
 * @package Partitura\Controller
 */
abstract class Controller extends AbstractController
{
    /**
     * @param null|Request $request
     *
     * @return array<string, string>
     */
    protected function getCsrfTokenBase(?Request $request = null) : array
    {
        if ($request === null) {
            $request = Request::createFromGlobals();
        }

        return ["token_base" => sprintf(
            "%s || %s",
            (string)$request->server->get("HTTP_USER_AGENT"),
            (string)$request->attributes->get("_route")
        )];
    }
}
