<?php
declare(strict_types=1);

namespace Partitura\Controller\Admin;

use Partitura\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class LoginController
 * @package Partitura\Controller\Admin
 * 
 * @Route("/admin/login")
 */
class LoginController extends Controller
{
    public const ROUTE_LOGIN = "partitura_admin_login";

    /**
     * @param Request $request
     * 
     * @return Response
     * 
     * @Route("/", name=LoginController::ROUTE_LOGIN, methods={"GET"})
     */
    public function login(Request $request) : Response
    {
        return $this->render(
            "genesis/admin/login.html.twig",
            array_merge(
                ["route_name" => static::ROUTE_LOGIN],
                $this->getCsrfTokenBase($request)
            )
        );
    }
}
