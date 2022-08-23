<?php
declare(strict_types=1);

namespace Partitura\Controller\Profile;

use Partitura\Controller\MainController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * Class LoginController
 * @package Partitura\Controller\Profile
 * 
 * @Route("/profile/login")
 */
class LoginController extends AbstractController
{
    public const ROUTE_LOGIN = "partitura_login";

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
            return $this->redirectToRoute(MainController::ROUTE_INDEX);
        }

        return $this->render(
            "genesis/admin/login.html.twig",
            [
                "route_name" => static::ROUTE_LOGIN,
                "last_username" => $authenticationUtils->getLastUsername(),
                "error" => $authenticationUtils->getLastAuthenticationError(),
                "csrf_token_id" => "login",
            ]
        );
    }
}
