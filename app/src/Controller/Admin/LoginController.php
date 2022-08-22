<?php
declare(strict_types=1);

namespace Partitura\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * Class LoginController
 * @package Partitura\Controller\Admin
 * 
 * @Route("/admin/login")
 */
class LoginController extends AbstractController
{
    public const ROUTE_LOGIN = "partitura_admin_login";
    public const CSRF_TOKEN_ID = "admin_login";

    /**
     * @param AuthenticationUtils $authenticationUtils
     * 
     * @return Response
     * 
     * @Route("/", name=LoginController::ROUTE_LOGIN, methods={"GET", "POST"})
     */
    public function login(AuthenticationUtils $authenticationUtils) : Response
    {
        if ($this->getUser() !== null) {
            return $this->redirectToRoute(DashboardController::ROUTE_DASHBOARD);
        }

        return $this->render(
            "genesis/admin/login.html.twig",
            [
                "route_name" => static::ROUTE_LOGIN,
                "last_username" => $authenticationUtils->getLastUsername(),
                "error" => $authenticationUtils->getLastAuthenticationError(),
                "csrf_token_id" => static::CSRF_TOKEN_ID,
            ]
        );
    }
}
