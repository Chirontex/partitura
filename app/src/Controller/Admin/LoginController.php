<?php
declare(strict_types=1);

namespace Partitura\Controller\Admin;

use Partitura\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

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
     * @Route("/", name=LoginController::ROUTE_LOGIN, methods={"GET", "POST"})
     */
    public function login(Request $request, AuthenticationUtils $authenticationUtils) : Response
    {
        return $this->render(
            "genesis/admin/login.html.twig",
            array_merge(
                [
                    "route_name" => static::ROUTE_LOGIN,
                    "last_username" => $authenticationUtils->getLastUsername(),
                    "error" => $authenticationUtils->getLastAuthenticationError(),
                ],
                $this->getCsrfTokenBase($request)
            )
        );
    }
}
